<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Carbon\Carbon;
use Inertia\Inertia;

class MpesaController extends Controller
{
    public function generateAccessToken()
    {
        $consumer_key="gbV4576LDAHqjvav3ONLOLB1JpOgtoIG";
        $consumer_secret="oTBARjSNV43DudRy";
        $credentials = base64_encode($consumer_key.":".$consumer_secret);
        $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        $access_token=json_decode($curl_response);

        return $access_token->access_token;
    }

    public function getLipaNaMpesaPassword()
    {
        $timestamp = Carbon::rawParse('now')->format('YmdHms');
        $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
        $BusinessShortCode = 174379;
        $lipa_na_mpesa_password = base64_encode($BusinessShortCode.$passkey.$timestamp);

        return $lipa_na_mpesa_password;
    }

    public function customerMpesaSTKPush()
    {
        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generateAccessToken()));
        
        $curl_post_data = [
            //Fill in the request parameters with valid values
            'BusinessShortCode' => 174379,
            'Password' => $this->getLipaNaMpesaPassword(),
            'Timestamp' => Carbon::rawParse('now')->format('YmdHms'),
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => 1,
            'PartyA' => 254721798372, // replace this with your phone number
            'PartyB' => 174379,
            'PhoneNumber' => 254721798372, // replace this with your phone number
            'CallBackURL' => 'https://192.168.0.30:8000/',
            'AccountReference' => "Moba App",
            'TransactionDesc' => "Testing stk push on sandbox"
        ];

        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);

        $response = json_decode($curl_response, true);

        if (isset($response['ResponseCode'])) {
            return Redirect::route('mpesa.stk_push_status')->with('success', $response);
        }

        return Redirect::route('mpesa.stk_push_status')->with('error', $response);
    }

    /**
     * J-son Response to M-pesa API feedback - Success or Failure
     */
    public function createValidationResponse($result_code, $result_description)
    {
        $result=json_encode(["ResultCode"=>$result_code, "ResultDesc"=>$result_description]);
        $response = new Response();
        $response->headers->set("Content-Type", "application/json; charset=utf-8");
        $response->setContent($result);
        return $response;
    }

    /**
     *  M-pesa Validation Method
     * Safaricom will only call your validation if you have requested by writing an official letter to them
     */
    public function mpesaValidation(Request $request)
    {
        $result_code = "0";
        $result_description = "Accepted validation request.";
        return $this->createValidationResponse($result_code, $result_description);
    }

    /**
     * M-pesa Transaction confirmation method, we save the transaction in our databases
     */
    public function mpesaConfirmation(Request $request)
    {
        $content = json_decode($request->getContent());

        $mpesa_transaction = new MpesaTransaction();
        $mpesa_transaction->transaction_type = $content->TransactionType;
        $mpesa_transaction->transaction_id = $content->TransID;
        $mpesa_transaction->transaction_time = $content->TransTime;
        $mpesa_transaction->transaction_amount = $content->TransAmount;
        $mpesa_transaction->business_shortcode = $content->BusinessShortCode;
        $mpesa_transaction->bill_ref_number = $content->BillRefNumber;
        $mpesa_transaction->invoice_number = $content->InvoiceNumber;
        $mpesa_transaction->Organisation_account_balance = $content->OrgAccountBalance;
        $mpesa_transaction->third_party_trans_id = $content->ThirdPartyTransID;
        $mpesa_transaction->msisdn = $content->MSISDN;
        $mpesa_transaction->first_name = $content->FirstName;
        $mpesa_transaction->middle_name = $content->MiddleName;
        $mpesa_transaction->last_name = $content->LastName;
        $mpesa_transaction->save();

        // Responding to the confirmation request
        $response = new Response();
        $response->headers->set("Content-Type", "text/xml; charset=utf-8");
        $response->setContent(json_encode(["C2BPaymentConfirmationResult"=>"Success"]));

        return $response;
    }

    /**
     * M-pesa Register Validation and Confirmation method
     */
    public function mpesaRegisterUrls()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Bearer '. $this->generateAccessToken()));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
            'ShortCode' => "600141",
            'ResponseType' => 'Completed',
            'ConfirmationURL' => "https://moba.tandaa.africa/transaction/confirmation",
            'ValidationURL' => "https://moba.tandaa.africa/validation"
        )));
        
        $curl_response = curl_exec($curl);

        echo $curl_response;
    }

    public function getStkPushStatus()
    {
        return Inertia::render('Auth/StkPushResponse');
    }
}

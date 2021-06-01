<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\MpesaTransaction;
use Illuminate\Support\Facades\Log;

class MpesaController extends Controller
{
    public function generateAccessToken()
    {
        $consumer_key="";
        $consumer_secret="";
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

    public function customerMpesaSTKPush(Request $request)
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
            'PartyA' => $request->phone, // replace this with your phone number
            'PartyB' => 174379,
            'PhoneNumber' => $request->phone, // replace this with your phone number
            'CallBackURL' => 'https://crm.moba.or.ke/transaction/confirmation',
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
        $content = json_decode($request->getContent(), true);

        Log::debug("Mpesa Callback", $content);
        
        if (isset($content)) {
            $body = $content['Body'];
            $stkCallback = $body['stkCallback'];

            $merchantRequestID = null;
            $checkoutRequestID = null;
            $resultCode = null;
            $resultDesc = null;
            $callbackMetadata = null;
            $amount = null;
            $mpesaReceiptNumber = null;
            $balance = null;
            $transactionDate = null;
            $phoneNumber = null;

            if (isset($stkCallback)) {
                $merchantRequestID = $stkCallback['MerchantRequestID'];
                $checkoutRequestID = $stkCallback['CheckoutRequestID'];
                $resultCode = $stkCallback['ResultCode'];
                $resultDesc = $stkCallback['ResultDesc'];
                $callbackMetadata = $stkCallback['CallbackMetadata'];
                $amount = isset($callbackMetadata['Item'][0]['Value']) ? $callbackMetadata['Item'][0]['Value'] : 0;
                $mpesaReceiptNumber = isset($callbackMetadata['Item'][1]['Value']) ? $callbackMetadata['Item'][1]['Value']: '';
                $balance = isset($callbackMetadata['Item'][2]['Value']) ? $callbackMetadata['Item'][2]['Value']: 0;
                $transactionDate = isset($callbackMetadata['Item'][3]['Value']) ? $callbackMetadata['Item'][3]['Value']: '';
                $phoneNumber = isset($callbackMetadata['Item'][4]['Value']) ? $callbackMetadata['Item'][4]['Value']: '';
            }
           
            $mpesa_transaction = new MpesaTransaction();
            $mpesa_transaction->merchant_request_id = $merchantRequestID;
            $mpesa_transaction->checkout_request_id = $checkoutRequestID;
            $mpesa_transaction->result_code = $resultCode;
            $mpesa_transaction->result_desc= $resultDesc;
            $mpesa_transaction->transaction_date = $transactionDate;
            $mpesa_transaction->phone_number = $phoneNumber;
            $mpesa_transaction->mpesa_receipt_number = $mpesaReceiptNumber;
            $mpesa_transaction->amount = $amount;
            $mpesa_transaction->balance = $balance;
        
            $mpesa_transaction->save();
        }

        // // Responding to the confirmation request
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
            'ShortCode' => "174379",
            'ResponseType' => 'Completed',
            'ConfirmationURL' => "https://moba.tandaa.africa/api/transaction/confirmation",
            'ValidationURL' => "https://moba.tandaa.africa/api/validation"
        )));
        
        $curl_response = curl_exec($curl);

        echo $curl_response;
    }

    public function getStkPushStatus()
    {
        return Inertia::render('Auth/StkPushResponse');
    }
}

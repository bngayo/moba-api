import React from 'react';
import Helmet from 'react-helmet';
import { usePage, useForm } from '@inertiajs/inertia-react';
import Logo from '@/Shared/Logo';
import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/TextInput';

export default () => {
  const { flash } = usePage().props;
  return (
    <div className="flex items-center justify-center min-h-screen p-6 bg-gray-200">
      <Helmet title="MOBA | Payment" />
      <div className="w-1/2 overflow-hidden bg-gray-100 rounded shadow">
        <div className="px-10 py-2">
          <Logo
            className="max-w-xs mx-auto text-white fill-current"
            width={150}
          />
          <h1 className="text-3xl font-bold text-center">M-Pesa Payment</h1>

          {flash.success && (
            <>
              <h3 className="text-xl font-bold text-center text-green-500">
                {flash.success}
              </h3>

              <p className="text-center text-gray-500">
                Kindly check your phone and then enter your M-Pesa PIN to
                complete the transaction.
              </p>
            </>
          )}

          {flash.error && (
            <h3 className="text-2xl font-bold text-center text-red-500">
              {flash.error}
            </h3>
          )}
        </div>
      </div>
    </div>
  );
};

import React from 'react';
import Helmet from 'react-helmet';
import { usePage, useForm } from '@inertiajs/inertia-react';
import Logo from '@/Shared/Logo';
import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/TextInput';

export default () => {
  const { user } = usePage().props;
  const { data, setData, errors, post, processing } = useForm({
    phone: user.phone,
    membership: user.active_subscription.subscription_plan,
    amount: user.active_subscription.amount,
    billing_cycle: user.active_subscription.billing_cycle
  });

  function handleSubmit(e) {
    e.preventDefault();
    post(route('login.attempt'));
  }

  return (
    <div className="flex items-center justify-center min-h-screen p-6 bg-gray-200">
      <Helmet title="Payment" />
      <div className="w-1/2 overflow-hidden bg-gray-100 rounded shadow">
        <form
          onSubmit={handleSubmit}
          className="mt-8 overflow-hidden bg-white rounded-lg shadow-xl"
        >
          <div className="px-10 py-2">
            <Logo
              className="max-w-xs mx-auto text-white fill-current"
              width={150}
            />
            <h1 className="text-3xl font-bold text-center">Payment</h1>
            <h3 className="mt-5 pb-8 text-center text-lg text-red-600">
              Hello {user.name}, complete your payment to activate your account.
            </h3>

            <TextInput
              className="w-full pb-8 pr-6"
              label="Membership Type"
              name="membership"
              type="text"
              value={data.membership}
              disabled
              onChange={e => setData('membership', e.target.value)}
            />
            <TextInput
              className="w-full pb-8 pr-6"
              label="Subscription Amount"
              name="amount"
              type="text"
              value={data.amount}
              disabled
              onChange={e => setData('amount', e.target.value)}
            />
            <TextInput
              className="w-full pb-8 pr-6"
              label="Billing Cycle"
              name="billing_cycle"
              type="text"
              value={data.billing_cycle}
              disabled
              onChange={e => setData('billing_cycle', e.target.value)}
            />
            <TextInput
              className="w-full pb-8 pr-6"
              label="M-Pesa Number"
              name="phone"
              type="text"
              errors={errors.phone}
              value={data.phone}
              onChange={e => setData('phone', e.target.value)}
            />
          </div>
          <div className="flex items-center justify-between px-10 py-4 bg-gray-100 border-t border-gray-200">
            <LoadingButton
              type="submit"
              loading={processing}
              className="btn-indigo"
            >
              Make Payment
            </LoadingButton>
          </div>
        </form>
      </div>
    </div>
  );
};

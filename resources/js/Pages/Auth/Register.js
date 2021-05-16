import React from 'react';
import Helmet from 'react-helmet';
import { InertiaLink, useForm } from '@inertiajs/inertia-react';
import Logo from '@/Shared/Logo';
import LoadingButton from '@/Shared/LoadingButton';
import PersonalInfo from './PersonalInfo';

const Create = () => {
  const { data, setData, errors, post, processing } = useForm({
    name: '',
    email: '',
    country: '',
    phone: '',
    password: '',
    confirm_password: '',
    photo: '',
    member: true
  });

  function handleSubmit(e) {
    e.preventDefault();
    post(route('register.store'));
  }

  return (
    <div className="flex items-center justify-center min-h-screen p-6 bg-green-900">
      <Helmet title="Register" />
      <div className="w-2/3 overflow-hidden bg-white rounded shadow">
        <form name="createForm" onSubmit={handleSubmit}>
            <Logo
              className="max-w-xs mx-auto text-white fill-current"
              width={150}
            />
            <h1 className="text-3xl font-bold text-center">Create account</h1>
            <p className="mt-2 text-center text-sm text-gray-600">
              Or
              <InertiaLink className="font-medium text-lg text-red-600 hover:text-red-500" href="/register">
                &nbsp;Create account if not a member
              </InertiaLink>
            </p>

          <div className="flex flex-wrap p-8 -mb-8 -mr-6">

            <PersonalInfo data={data} errors={errors} />
           
          </div>
          <div className="flex items-center justify-end px-8 py-4 bg-gray-100 border-t border-gray-200">
            <LoadingButton
              loading={processing}
              type="submit"
              className="btn-indigo"
            >
              Create User
            </LoadingButton>
          </div>
        </form>
      </div>
    </div>
  );
};

export default Create;

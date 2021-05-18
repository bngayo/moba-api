import React from 'react';
import Helmet from 'react-helmet';
import { InertiaLink, usePage, useForm } from '@inertiajs/inertia-react';
import Logo from '@/Shared/Logo';
import LoadingButton from '@/Shared/LoadingButton';
import PersonalInfo from './PersonalInfo';
import TextInput from '@/Shared/TextInput';
import SelectInput from '@/Shared/SelectInput';
import FileInput from '@/Shared/FileInput';

const Create = () => {
  const { years } = usePage().props;
  const { data, setData, errors, post, processing } = useForm({
    year_completed: '',
    house: '',
    prefect: '',
    prefect_title: ''
  });

  function handleSubmit(e) {
    e.preventDefault();
    post(route('register.store'));
  }

  return (
    <div className="flex items-center justify-center min-h-screen p-6 bg-green-900">
      <Helmet title="Register" />
      <div className="w-full overflow-hidden bg-gray-100 rounded shadow">
        <form name="createForm" onSubmit={handleSubmit}>
          <Logo
            className="max-w-xs mx-auto text-white fill-current"
            width={150}
          />
          <h1 className="text-3xl font-bold text-center">Create account</h1>
          <p className="mt-2 text-center text-sm text-gray-600">
            Or
            <InertiaLink
              className="font-medium text-lg text-red-600 hover:text-red-500"
              href="/register"
            >
              &nbsp;Create account if not a member
            </InertiaLink>
          </p>

          <div className="flex flex-wrap p-8 -mb-8 -mr-6">
            <p></p>
          </div>
        </form>
      </div>
    </div>
  );
};

export default Create;

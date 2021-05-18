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
    prefect_title: '',
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

          <div className="mt-10 sm:mt-0">
                <div className="md:grid md:grid-cols-3 md:gap-6">
                    <div className="md:col-span-1">
                        <div className="px-4 sm:px-0">
                        <h3 className="text-lg font-medium leading-6 text-gray-900">School Information</h3>
                        <p className="mt-1 text-sm text-gray-600">Please provide more details about your time at Maseno School.</p>
                        </div>
                    </div>
                    <div className="mt-5 md:mt-0 md:col-span-2">

                        <SelectInput
                            className="w-full pb-8 pr-6"
                            label="Which year did you leave Maseno School?"
                            name="year_completed"
                            errors={errors.year_completed}
                            value={data.year_completed}
                            onChange={e => setData('year_completed', e.target.value)}
                        >
                          <option value="">Select Year</option>
                          {years.map(year => {
                              return (<option value={year}>{year}</option>)
                          })}
  
                        </SelectInput>

                        <TextInput
                            className="w-full pb-8 pr-6"
                            label="Full Name"
                            name="name"
                            errors={errors.name}
                            value={data.name}
                            onChange={e => setData('name', e.target.value)}
                        />

                        <TextInput
                            className="w-full pb-8 pr-6"
                            label="Email"
                            name="email"
                            type="email"
                            errors={errors.email}
                            value={data.email}
                            onChange={e => setData('email', e.target.value)}
                        />
                        

                        <TextInput
                            className="w-full pb-8 pr-6"
                            label="Phone Number"
                            name="phone"
                            errors={errors.phone}
                            value={data.phone}
                            onChange={e => setData('phone', e.target.value)}
                        />
                        <TextInput
                            className="w-full pb-8 pr-6"
                            label="Password"
                            name="password"
                            type="password"
                            errors={errors.password}
                            value={data.password}
                            onChange={e => setData('password', e.target.value)}
                        />

                        <TextInput
                            className="w-full pb-8 pr-6"
                            label="Confirm Password"
                            name="password_confirmation"
                            type="password"
                            errors={errors.password_confirmation}
                            value={data.password_confirmation}
                            onChange={e => setData('password_confirmation', e.target.value)}
                        />

                        <FileInput
                            className="w-full pb-8 pr-6"
                            label="Photo"
                            name="photo"
                            accept="image/*"
                            errors={errors.photo}
                            value={data.photo}
                            onChange={photo => setData('photo', photo)}
                        />
                    </div>
                </div>
            </div>
           
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

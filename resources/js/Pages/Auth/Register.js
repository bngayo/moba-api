import React from 'react';
import Helmet from 'react-helmet';
import { InertiaLink, usePage, useForm } from '@inertiajs/inertia-react';
import Logo from '@/Shared/Logo';
import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/TextInput';
import SelectInput from '@/Shared/SelectInput';
import FileInput from '@/Shared/FileInput';
import RadioButton from '../../Shared/RadioButtonInput';

const Register = () => {
  const { countries, years } = usePage().props;
  const { data, setData, errors, post, processing } = useForm({
    name: '',
    email: '',
    phone: '',
    country: '',
    city: '',
    password: '',
    password_confirmation: '',
    photo: '',
    year_completed: '',
    house: '',
    prefect: '',
    prefect_title: '',
    membership_plan: '',
    billing_cycle: '',
    member: true
  });

  function handleSubmit(e) {
    e.preventDefault();
    post(route('register.store'));
  }

  function handleMembershipSelect(e) {
    setData('membership_plan', e.target.value);
    console.log(e.target.name);
  }

  function handleYearCompletedSelect(e) {
    setData('year_completed', e.target.value);
    const current_date = new Date();
    const current_year = current_date.getFullYear();
    const diff = parseInt(current_year) - parseInt(e.target.value);
    const leftAfter7years = diff > 7;

    document.getElementById('associate_membership').disabled = leftAfter7years;

    if (leftAfter7years) {
      document.getElementById('full_membership').checked = true;
    } else {
      document.getElementById('associate_membership').checked = true;
    }

    element.dispatchEvent(event);
  }

  return (
    <div className="flex items-center justify-center min-h-screen p-6 bg-gray-200">
      <Helmet title="Register" />
      <div className="w-full overflow-hidden bg-gray-100 rounded shadow">
        <Logo
          className="max-w-xs mx-auto text-white fill-current"
          width={150}
        />
        <h1 className="text-3xl font-bold text-center">Create account</h1>
        <p className="mt-2 text-center text-sm text-gray-600">
          Or
          <InertiaLink
            className="font-medium text-lg text-red-600 hover:text-red-500"
            href="/login"
          >
            &nbsp;Login if already registered
          </InertiaLink>
        </p>
        <div className="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
          <form name="createForm" onSubmit={handleSubmit}>
            <div>
              <div className="md:grid md:grid-cols-3 md:gap-3">
                <div className="md:col-span-1">
                  <div className="px-4 sm:px-0">
                    <h3 className="text-lg font-medium leading-6 text-gray-900">
                      Personal Information
                    </h3>
                    <p className="mt-1 text-sm text-gray-600">
                      Basic information about you and your contact information.
                    </p>
                  </div>
                </div>
                <div className="mt-5 md:mt-0 md:col-span-2">
                  <div className="shadow overflow-hidden sm:rounded-md">
                    <div className="px-4 py-5 bg-white sm:p-6">
                      <div className="grid grid-cols-6 gap-3">
                        <div className="col-span-6">
                          <TextInput
                            label="Full Name"
                            name="name"
                            errors={errors.name}
                            value={data.name}
                            onChange={e => setData('name', e.target.value)}
                          />
                        </div>

                        <div className="col-span-6 sm:col-span-3">
                          <SelectInput
                            label="Country"
                            name="country"
                            errors={errors.country}
                            value={data.country}
                            onChange={e => setData('country', e.target.value)}
                          >
                            <option value="">Select Country</option>
                            {Object.values(countries).map(country => {
                              return (
                                <option key={country} value={country}>
                                  {country}
                                </option>
                              );
                            })}
                          </SelectInput>
                        </div>

                        <div className="col-span-6 sm:col-span-3">
                          <TextInput
                            label="City/County"
                            name="city"
                            errors={errors.city}
                            value={data.city}
                            onChange={e => setData('city', e.target.value)}
                          />
                        </div>

                        <div className="col-span-6 sm:col-span-3">
                          <TextInput
                            label="Email"
                            name="email"
                            type="email"
                            errors={errors.email}
                            value={data.email}
                            onChange={e => setData('email', e.target.value)}
                          />
                        </div>

                        <div className="col-span-6 sm:col-span-3">
                          <TextInput
                            label="Phone Number"
                            name="phone"
                            errors={errors.phone}
                            value={data.phone}
                            onChange={e => setData('phone', e.target.value)}
                          />
                        </div>

                        <div className="col-span-6 sm:col-span-3">
                          <TextInput
                            label="Password"
                            name="password"
                            type="password"
                            errors={errors.password}
                            value={data.password}
                            onChange={e => setData('password', e.target.value)}
                          />
                        </div>

                        <div className="col-span-6 sm:col-span-3">
                          <TextInput
                            label="Confirm Password"
                            name="password_confirmation"
                            type="password"
                            errors={errors.password_confirmation}
                            value={data.password_confirmation}
                            onChange={e =>
                              setData('password_confirmation', e.target.value)
                            }
                          />
                        </div>

                        <div className="col-span-6 sm:col-span-3">
                          <FileInput
                            className="w-full pb-8 pr-6 lg:w-1/2"
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
                </div>
              </div>
            </div>

            <div className="hidden sm:block" aria-hidden="true">
              <div className="py-5">
                <div className="border-t border-gray-200" />
              </div>
            </div>

            <div className="mt-10 sm:mt-0">
              <div className="md:grid md:grid-cols-3 md:gap-3">
                <div className="md:col-span-1">
                  <div className="px-4 sm:px-0">
                    <h3 className="text-lg font-medium leading-6 text-gray-900">
                      Detailed Information
                    </h3>
                    <p className="mt-1 text-sm text-gray-600">
                      Information about your time at Maseno School.
                    </p>
                  </div>
                </div>
                <div className="mt-5 md:mt-0 md:col-span-2">
                  <div className="shadow sm:rounded-md sm:overflow-hidden">
                    <div className="px-4 py-5 bg-white space-y-6 sm:p-6">
                      <div className="grid grid-cols-6 gap-3">
                        <div className="col-span-6 sm:col-span-3">
                          <SelectInput
                            label="Year Completed"
                            name="year_completed"
                            errors={errors.year_completed}
                            value={data.year_completed}
                            onChange={handleYearCompletedSelect}
                          >
                            <option value="">Select Year</option>
                            {years.map(year => {
                              return (
                                <option key={year} value={year}>
                                  {year}
                                </option>
                              );
                            })}
                          </SelectInput>
                        </div>

                        <div className="col-span-6 sm:col-span-3">
                          <TextInput
                            label="Dormitory/House"
                            name="house"
                            errors={errors.house}
                            value={data.house}
                            onChange={e => setData('house', e.target.value)}
                          />
                        </div>

                        <div className="col-span-6">
                          <fieldset>
                            <div>
                              <legend className="text-base font-medium text-gray-900">
                                Were you a prefect while at Maseno School?
                              </legend>
                            </div>
                            <div className="mt-4 space-y-4">
                              <div className="flex items-center">
                                <RadioButton
                                  id="prefect_yes"
                                  name="prefect"
                                  label="Yes, I was a prefect"
                                  onChange={e =>
                                    setData('prefect', e.target.value)
                                  }
                                />
                              </div>
                              <div className="flex items-center">
                                <RadioButton
                                  id="prefect_yes"
                                  name="prefect"
                                  label="No, I was not a prefect"
                                  onChange={e =>
                                    setData('prefect', e.target.value)
                                  }
                                />
                              </div>
                            </div>
                          </fieldset>
                        </div>

                        <div className="col-span-6">
                          <TextInput
                            label="What was your title as a prefect?"
                            name="prefect_title"
                            errors={errors.prefect_title}
                            value={data.prefect_title}
                            onChange={e =>
                              setData('prefect_title', e.target.value)
                            }
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div className="hidden sm:block" aria-hidden="true">
              <div className="py-5">
                <div className="border-t border-gray-200" />
              </div>
            </div>

            <div className="mt-10 sm:mt-0">
              <div className="md:grid md:grid-cols-3 md:gap-3">
                <div className="md:col-span-1">
                  <div className="px-4 sm:px-0">
                    <h3 className="text-lg font-medium leading-6 text-gray-900">
                      Membership
                    </h3>
                    <p className="mt-1 text-sm text-gray-600">
                      Select your membership plan and billing cycle.
                    </p>
                  </div>
                </div>
                <div className="mt-5 md:mt-0 md:col-span-2">
                  <div className="shadow overflow-hidden sm:rounded-md">
                    <div className="px-4 py-5 bg-white space-y-3 sm:p-3">
                      <fieldset>
                        <legend className="form-label">Membership Plans</legend>
                        <div className="mt-4 space-y-4">
                          <RadioButton
                            className="flex items-center h-5"
                            id="associate_membership"
                            name="membership"
                            label="Associate Membership"
                            description=" For those currently in school or completed
							  less than 7 years ago"
                            onChange={handleMembershipSelect}
                          />
                          <RadioButton
                            className="flex items-center h-5"
                            id="full_membership"
                            name="membership"
                            label="Full Membership"
                            description="For those more than 7 years since completion"
                            onChange={handleMembershipSelect}
                          />
                          <RadioButton
                            className="flex items-center h-5"
                            id="lifetime_membership"
                            name="membership"
                            label="Life time Membership"
                            description="One time life membership."
                            onChange={handleMembershipSelect}
                          />
                        </div>
                      </fieldset>
                      <fieldset>
                        <div>
                          <legend className="form-label">Billing Cycle</legend>
                        </div>
                        <div className="mt-4 space-y-4">
                          <RadioButton
                            id="monthly"
                            name="billing_cycle"
                            label="Monthly"
                            onChange={e =>
                              setData('billing_cycle', e.target.value)
                            }
                          />

                          <RadioButton
                            id="quarterly"
                            name="billing_cycle"
                            label="Quarterly"
                            onChange={e =>
                              setData('billing_cycle', e.target.value)
                            }
                          />

                          <RadioButton
                            id="semi_annually"
                            name="billing_cycle"
                            label="Semi Annually"
                            onChange={e =>
                              setData('billing_cycle', e.target.value)
                            }
                          />

                          <RadioButton
                            id="annually"
                            name="billing_cycle"
                            label="Annually"
                            onChange={e =>
                              setData('billing_cycle', e.target.value)
                            }
                          />
                        </div>
                      </fieldset>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div className="hidden sm:block" aria-hidden="true">
              <div className="py-5"></div>
            </div>

            <div className="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-200">
              <LoadingButton
                loading={processing}
                type="submit"
                className="btn-indigo"
              >
                Register
              </LoadingButton>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default Register;

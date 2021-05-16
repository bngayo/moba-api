import React from 'react';
import TextInput from '@/Shared/TextInput';
import SelectInput from '@/Shared/SelectInput';
import FileInput from '@/Shared/FileInput';

export default (data, errors) => {
    return(
        <>
            <div className="mt-10 sm:mt-0">
                <div className="md:grid md:grid-cols-3 md:gap-6">
                    <div className="md:col-span-1">
                        <div className="px-4 sm:px-0">
                        <h3 className="text-lg font-medium leading-6 text-gray-900">Personal Information</h3>
                        <p className="mt-1 text-sm text-gray-600">Please fill the form to create your account with MOBA.</p>
                        </div>
                    </div>
                    <div className="mt-5 md:mt-0 md:col-span-2">

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
                        <SelectInput
                            className="w-full pb-8 pr-6"
                            label="Country"
                            name="country"
                            errors={errors.country}
                            value={data.country}
                            onChange={e => setData('country', e.target.value)}
                        >
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </SelectInput>

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
                            name="confirm_password"
                            type="confirm_password"
                            errors={errors.confirm_password}
                            value={data.confirm_password}
                            onChange={e => setData('confirm_password', e.target.value)}
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
        </>
    );
}
import React from 'react';
import { usePage } from '@inertiajs/inertia-react';
import MainMenuItem from '@/Shared/MainMenuItem';

export default ({ className }) => {
  const { auth } = usePage().props;

  return (
    <div className={className}>
      <MainMenuItem text="Dashboard" link="dashboard" icon="dashboard" />
      <MainMenuItem text="Members" link="users" icon="users" />
      <MainMenuItem text="Payments" link="contacts" icon="office" />
      <MainMenuItem text="Users" link="users" icon="users" />
      <MainMenuItem text="Reports" link="reports" icon="printer" />
    </div>
  );
};

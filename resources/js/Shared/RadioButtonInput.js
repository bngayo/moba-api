import React from 'react';

export default ({
  label,
  name,
  className,
  errors = [],
  description = '',
  ...props
}) => {
  return (
    <div className="flex items-start">
      <div className="flex items-center h-5">
        <input
          id={name}
          name={name}
          type="radio"
          {...props}
          className="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
        />
      </div>
      <div className="ml-3">
        {label && <label htmlFor={name}> {label}</label>}
        {description && <p className="text-gray-500 py-1">{description}</p>}
        {errors && <div className="form-error">{errors}</div>}
      </div>
    </div>
  );
};

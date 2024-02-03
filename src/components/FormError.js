import React from 'react';

function FormError({ errorMessage }) {
  return (
    <div className="jbls-form-error">
      <div className="jbls-form-error__emoji">(≥o≤)</div>
      <div className="jbls-form-error__text jbls-text-size-h3">
        {errorMessage || 'An error occurred. Please try again.'}
      </div>
    </div>
  )
}

export default FormError;

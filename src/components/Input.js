import React from 'react';

function Input(props) {

  const { value, label, name, helper, error, ...remainingProps } = props;

  return (
    <div className="jbls-input">
      <label
        htmlFor={`jbls-input-${name}`}
        className="jbls-input__label jbls-text-size-p">
          {label}
      </label>
      <input
        {...remainingProps}
        value={value}
        name={name}
        id={`jbls-input-${name}`}
        className="jbls-input__control"
      />
      {helper && <div className="jbls-input__helper jbls-text-size-small">{helper}</div>}
      {error && <div className="jbls-input__error jbls-text-size-small">{error}</div>}
    </div>
  )
}

export default Input;

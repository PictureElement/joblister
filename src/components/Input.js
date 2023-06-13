import React from 'react'

function Input(props) {

  const { label, name, ...remainingProps } = props;

  return (
    <div className="js-input">
      <label
        htmlFor={`js-input-${name}`}
        className="js-input__label">
          {label}
      </label>
      <input
        {...remainingProps}
        name={name}
        id={`js-input-${name}`}
        className="js-input__control"
      />
    </div>
  )
}

export default Input;
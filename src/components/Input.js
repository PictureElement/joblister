import React from 'react'

function Input(props) {

  const { value, label, name, helper, error, ...remainingProps } = props;

  return (
    <div className="jl-input">
      <label
        htmlFor={`jl-input-${name}`}
        className="jl-input__label jl-text-size-p">
          {label}
      </label>
      <input
        {...remainingProps}
        value={value}
        name={name}
        id={`jl-input-${name}`}
        className="jl-input__control"
      />
      {helper && <div className="jl-input__helper jl-text-size-small">{helper}</div>}
      {error && <div className="jl-input__error jl-text-size-small">{error}</div>}
    </div>
  )
}

export default Input;
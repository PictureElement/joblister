import React from 'react'

function Input(props) {

  const { label, name, hint, ...remainingProps } = props;

  return (
    <div className="jl-input">
      <label
        htmlFor={`jl-input-${name}`}
        className="jl-input__label jl-text-size-p">
          {label}
      </label>
      <input
        {...remainingProps}
        name={name}
        id={`jl-input-${name}`}
        className="jl-input__control"
      />
      <div className="jl-input__hint jl-text-size-small">{hint}</div>
      <div className="jl-input__error jl-text-size-small">Please provide a valid name.</div>
    </div>
  )
}

export default Input;
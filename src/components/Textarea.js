import React from 'react';

function Textarea(props) {
  const { value, label, name, helper, error, ...remainingProps } = props;

  return (
    <div className="jl-input">
      <label
        htmlFor={`jl-input-${name}`}
        className="jl-input__label jl-text-size-p">
          {label}
      </label>
      <textarea {...remainingProps} value={value} name={name} id={`jl-input-${name}`} className="jl-input__control" rows="5"></textarea>
      {helper && <div className="jl-input__helper jl-text-size-small">{helper}</div>}
      {error && <div className="jl-input__error jl-text-size-small">{error}</div>}
    </div>
  )
}

export default Textarea;
import React from 'react';
import DOMPurify from 'dompurify';

function Checkbox(props) {
  const { value, label, name, error, ...remainingProps } = props;

  return (
    <div className="jl-checkbox">
      <input
        type="checkbox"
        {...remainingProps}
        checked={value}
        name={name}
        id={`jl-checkbox-${name}`}
        className="jl-checkbox__control"
      />
      <label
        htmlFor={`jl-checkbox-${name}`}
        className="jl-checkbox__label jl-text-size-p"
        dangerouslySetInnerHTML={ {__html: DOMPurify.sanitize(label, { ADD_ATTR: ['target'] })} }
      />
      {error && <div className="jl-checkbox__error jl-text-size-small">{error}</div>}
    </div>
  )
}

export default Checkbox;
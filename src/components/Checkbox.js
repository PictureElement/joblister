import React from 'react';
import DOMPurify from 'dompurify';

function Checkbox(props) {
  const { value, label, name, error, ...remainingProps } = props;

  return (
    <div className="jbls-checkbox">
      <input
        type="checkbox"
        {...remainingProps}
        checked={value}
        name={name}
        id={`jbls-checkbox-${name}`}
        className="jbls-checkbox__control"
      />
      <label
        htmlFor={`jbls-checkbox-${name}`}
        className="jbls-checkbox__label jbls-text-size-p"
        dangerouslySetInnerHTML={ {__html: DOMPurify.sanitize(label, { ADD_ATTR: ['target'] })} }
      />
      {error && <div className="jbls-checkbox__error jbls-text-size-small">{error}</div>}
    </div>
  )
}

export default Checkbox;

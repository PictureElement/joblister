import { useState } from 'react';
import DOMPurify from 'dompurify';
import InputFactory from '../helpers/InputFactory';
import inputConfig from '../config/inputConfig';

function Form() {

  const nonceHiddenFields = { __html: DOMPurify.sanitize(jl_script_data.nonce) };

  const [values, setValues] = useState({
    name: '',
    email: ''
  }); 

  function handleSubmit(e) {
    // Prevent the browser from reloading the page
    e.preventDefault();
  }

  function onChange(e) {
    setValues({
      ...values,
      [e.target.name]: e.target.value
    });
  }

  console.log(values);

  return (
    <form className="js-form" method="post" onSubmit={handleSubmit}>
      {inputConfig.map((config, index) => {
        return (
          <InputFactory
            key={index}
            {...config}
            value={values[config.name]}
            onChange={onChange}
          />
        );
      })}
      <div dangerouslySetInnerHTML={ nonceHiddenFields }></div>
      <button type="submit" className="js-form__submit">Submit</button>
    </form>
  )
}

export default Form;
import { useState } from 'react';
import InputFactory from '../helpers/InputFactory';
import inputConfig from '../config/inputConfig';

function Form() {

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
      <button type="submit" className="js-form__submit">Submit</button>
    </form>
  )
}

export default Form;
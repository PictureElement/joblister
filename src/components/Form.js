import { useState } from 'react';
import Input from "./Input";

const inputs = [
  {
    name: 'name',
    type: 'text',
    placeholder: 'Name',
    label: 'Name'
  },
  {
    name: 'email',
    type: 'text',
    placeholder: 'Email',
    label: 'Email'
  }
];

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
      {inputs.map((input, index) => (
        <Input
          key={index}
          {...input}
          value={values[input.name]}
          onChange={onChange}
        />
      ))}
      <button type="submit" className="js-form__submit">Submit</button>
    </form>
  )
}

export default Form;
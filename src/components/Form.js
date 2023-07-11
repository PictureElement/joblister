import { useState } from 'react';
import { useParams } from 'react-router-dom';
import InputFactory from '../helpers/InputFactory';
import inputConfig from '../config/inputConfig';

function Form() {
  
  /**
   * State variables
   */
  const [values, setValues] = useState({
    name: '',
    email: ''
  });
  const [errors, setErrors] = useState({
    name: '',
    email: ''
  })

  // Get the :idDashSlug parameter from the URL.
  const { idDashSlug } = useParams();
  // Extract the job id.
  const id = parseInt(idDashSlug.split('-').shift());

  function handleSubmit(e) {
    // Prevent the browser from reloading the page
    e.preventDefault();

    // Retrieve credentials for accessing the WP REST API
    const username = process.env.APP_USERNAME;
    const password = process.env.APP_PASSWORD;

    // Encode credentials in Base64
    const encodedCredentials = window.btoa(`${username}:${password}`);
    const basicAuthHeader = `Basic ${encodedCredentials}`;

    const requestBody = JSON.stringify({
      job_id: id,
      name: values.name,
      email: values.email
      // Include other form fields as needed
    });

    console.log(requestBody);

    // Initiate POST request
    fetch("https://dev.test/wp-json/wp/v2/jl-applications", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Authorization": basicAuthHeader
      },
      body: requestBody
    })
      .then(response => response.json())
      .then(data => {
        // Handle the response data
        console.log(data);
      })
      .catch(error => {
        // Handle any errors
        console.error('Error:', error);
      });
  }

  function onChange(e) {
    setValues({
      ...values,
      [e.target.name]: e.target.value
    });
  }

  return (
    <form className="jl-form" onSubmit={handleSubmit}>
      <h2 className="jl-form__title">Apply for this job</h2>
      <p className="jl-form__subtitle">Use the form below to submit your job application</p>
      <div className="jl-form__required jl-text-size-small">* indicates a required field</div>
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
      <button type="submit" className="jl-form__submit">Submit</button>
    </form>
  )
}

export default Form;
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
    email: '',
    resume: null
  });
  const [errors, setErrors] = useState({
    name: '',
    email: '',
    resume: ''
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

    const formData = new FormData();
    formData.append('job_id', id);
    formData.append('name', values.name);
    formData.append('email', values.email);
    formData.append('resume', values.resume);

    // Initiate POST request
    fetch("https://dev.test/wp-json/wp/v2/jl-applications", {
      method: "POST",
      headers: {
        "Authorization": basicAuthHeader,
        "Content-Type": "multipart/form-data" // Add this line
      },
      body: formData
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
    if (e.target.type === 'file') {
      const file = e.target.files.length > 0 ? e.target.files[0] : null;
      setValues({
        ...values,
        [e.target.name]: file,
      });
    } else {
      setValues({
        ...values,
        [e.target.name]: e.target.value,
      });
    }
  } 
  
  return (
    <form className="jl-form" onSubmit={handleSubmit} encType="multipart/form-data">
      <h2 className="jl-form__title">Apply for this job</h2>
      <p className="jl-form__subtitle">Use the form below to submit your job application</p>
      <div className="jl-form__required jl-text-size-small">* indicates a required field</div>
      {inputConfig.map((config, index) => {
        return (
          <InputFactory
            key={index}
            {...config}
            onChange={onChange}
          />
        );
      })}
      <button type="submit" className="jl-form__submit">Submit</button>
    </form>
  )
}

export default Form;
import { useState, useRef } from 'react';
import { useParams } from 'react-router-dom';
import InputFactory from '../helpers/InputFactory';
import inputConfig from '../config/inputConfig';
import validate from '../helpers/validate';
import ReCAPTCHA from "react-google-recaptcha";

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
  const [verified, setVerified] = useState(false);
  const recaptchaRef = useRef();

  // Get the :idDashSlug parameter from the URL.
  const { idDashSlug } = useParams();
  // Extract the job id.
  const id = parseInt(idDashSlug.split('-').shift());

  async function handleSubmit(e) {
    // Prevent the browser from reloading the page
    e.preventDefault();
  
    const validationErrors = validate(values);
    
    setErrors(validationErrors);
  
    // Check if there are any validation errors
    const isFormValid = Object.values(validationErrors).every(x => !x);
  
    if (isFormValid && verified) {
      const formData = new FormData();
      formData.append('job_id', id);
      formData.append('name', values.name);
      formData.append('email', values.email);
      formData.append('resume', values.resume);
  
      // Retrieve credentials for accessing the WP REST API
      const username = process.env.APP_USERNAME;
      const password = process.env.APP_PASSWORD;
  
      // Encode credentials in Base64
      const encodedCredentials = window.btoa(`${username}:${password}`);
      const basicAuthHeader = `Basic ${encodedCredentials}`;
  
      // Initiate POST request
      try {
        const response = await fetch("https://dev.test/wp-json/wp/v2/jl-applications", {
          method: "POST",
          headers: {
            "Authorization": basicAuthHeader
          },
          body: formData
        });
        
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
  
        const data = await response.json();
        
        // Handle the response data
        console.log(data);
        // Reset state
        setValues({name: '', email: '', resume: null});
        setErrors({name: '', email: '', resume: ''});
        // Reset all file input elements
        const fileInputs = document.querySelectorAll('.jl-form input[type="file"]');
        fileInputs.forEach((input) => (input.value = ''));
        // Reset captcha
        if (recaptchaRef.current) {
          recaptchaRef.current.reset();
        }
      } catch (error) {
        // Handle any errors
        console.error('Error:', error);
        // Reset captcha
        if (recaptchaRef.current) {
          recaptchaRef.current.reset();
        }
      }
    }
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

  // The function to be called when the user successfully completes the captcha
  function onCaptchaVerification(value) {
    setVerified(true);
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
            value={values[config.name]}
            error={errors[config.name]}
          />
        );
      })}
      <div className="jl-form__captcha-wrapper">
        <ReCAPTCHA
          ref={recaptchaRef}
          sitekey={process.env.APP_CAPTCHA_KEY}
          onChange={onCaptchaVerification}
        />
      </div>
      <button type="submit" className="jl-form__submit">Submit</button>
    </form>
  )
}

export default Form;
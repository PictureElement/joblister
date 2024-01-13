import { useState, useRef } from 'react';
import { useParams } from 'react-router-dom';
import InputFactory from '../helpers/InputFactory';
import inputConfig from '../config/inputConfig';
import validate from '../helpers/validate';
import ReCAPTCHA from "react-google-recaptcha";
import Success from './Success';

function Form() {
  
  /**
   * State variables
   */
  const [values, setValues] = useState({
    name: '',
    email: '',
    cover: '',
    resume: null,
    consent: false
  });
  const [errors, setErrors] = useState({
    name: '',
    email: '',
    cover: '',
    resume: '',
    consent: ''
  })
  const [verified, setVerified] = useState(false);
  const [isFormSubmitted, setIsFormSubmitted] = useState(false);
  const recaptchaRef = useRef();

  // Get the :idDashSlug parameter from the URL.
  const { idDashSlug } = useParams();
  // Extract the job id.
  const id = parseInt(idDashSlug.split('-').shift());

  function handleSubmit(e) {
    // Prevent the browser from reloading the page
    e.preventDefault();
  
    const validationErrors = validate(values);
    
    setErrors(validationErrors);
  
    // Check if there are any validation errors
    const isFormValid = Object.values(validationErrors).every(x => !x);

    if (isFormValid) {
      // Execute the invisible ReCAPTCHA check
      recaptchaRef.current.execute();
    }
  }

  async function submitForm() {
    const formData = new FormData();
    
    formData.append('job_id', id);
    formData.append('name', values.name);
    formData.append('email', values.email);
    formData.append('cover', values.cover);
    formData.append('resume', values.resume);
    formData.append('consent', values.consent);

    // Display the key/value pairs
    for (var pair of formData.entries()) {
      console.log(pair[0]+ ', ' + pair[1]); 
    }
  
    // Retrieve credentials for accessing the WP REST API
    const username = jblsData.wordpressUsername;
    const password = jblsData.applicationPassword;

    // Encode credentials in Base64
    const encodedCredentials = window.btoa(`${username}:${password}`);
    const basicAuthHeader = `Basic ${encodedCredentials}`;

    // Initiate POST request
    try {
      const response = await fetch(jblsData.restBaseUrl + "wp/v2/jbls-applications", {
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

      // Handle successful submission
      setIsFormSubmitted(true);
      
      // Handle the response data
      console.log(data);
      // Reset state
      setValues({name: '', email: '', cover: '', resume: null, consent: false});
      setErrors({name: '', email: '', cover: '', resume: '', consent: ''});
      // Reset all file input elements
      const fileInputs = document.querySelectorAll('.jbls-form input[type="file"]');
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
  
  function onChange(e) {
    if (e.target.type === 'file') {
      const file = e.target.files.length > 0 ? e.target.files[0] : null;
      setValues({
        ...values,
        [e.target.name]: file,
      });
    } else if (e.target.type === 'checkbox') {
      setValues({
        ...values,
        [e.target.name]: e.target.checked,
      });
    } else {
      setValues({
        ...values,
        [e.target.name]: e.target.value,
      });
    }
  }

  function onCaptchaVerification(value) {
    if (value) {
      setVerified(true);
      // Continue with the form submission
      submitForm();
    } else {
      // Handle the case where the ReCAPTCHA verification failed
      console.error('ReCAPTCHA verification failed');
    }
  }
  
  return (
    <div className="jbls-form">
      {isFormSubmitted ? (
        <Success />
      ) : (
        <form className="jbls-form__form" onSubmit={handleSubmit} encType="multipart/form-data">
          <h2 className="jbls-form__title">Apply for this job</h2>
          <p className="jbls-form__subtitle">Use the form below to submit your job application</p>
          <div className="jbls-form__required jbls-text-size-small">* indicates a required field</div>
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
          <ReCAPTCHA
            ref={recaptchaRef}
            sitekey={jblsData.captchaSiteKey}
            size="invisible"
            onChange={onCaptchaVerification}
          />
          <button type="submit" className="jbls-form__submit">Submit</button>
        </form>
      )}
    </div>
  )
}

export default Form;
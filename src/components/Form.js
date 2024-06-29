import { useState, useRef } from 'react';
import { useParams } from 'react-router-dom';
import InputFactory from '../helpers/InputFactory';
import inputConfig from '../config/inputConfig';
import validate from '../helpers/validate';
import ReCAPTCHA from "react-google-recaptcha";
import FormSuccess from './FormSuccess';
import FormError from './FormError';

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
  const [isSubmitted, setIsSubmitted] = useState(false);
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [formError, setFormError] = useState(null);
  const recaptchaRef = useRef();

  // Get the :idDashSlug parameter from the URL.
  const { idDashSlug } = useParams();
  // Extract the job id.
  const id = parseInt(idDashSlug.split('-').shift());
  
  const handleChange = (e) => {
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

  const handleSubmit = (e) => {
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

  const handleCaptchaVerification = (value) => {
    if (value) {
      // Continue with the form submission
      submitForm();
    } else {
      // Handle the case where the ReCAPTCHA verification failed
      setFormError('Submission failed: reCAPTCHA verification failed. Please try again.');
      // Reset captcha
      if (recaptchaRef.current) {
        recaptchaRef.current.reset();
      }
      // Stop submitting
      setIsSubmitting(false);
    }
  }

  const submitForm = async () => {
    const formData = new FormData();
    
    formData.append('job_id', id);
    formData.append('name', values.name);
    formData.append('email', values.email);
    formData.append('cover', values.cover);
    formData.append('resume', values.resume);
    formData.append('consent', values.consent);

    // Get the reCAPTCHA token
    const recaptchaToken = await recaptchaRef.current.executeAsync();

    formData.append('recaptcha_token', recaptchaToken);

    // Start submitting
    setIsSubmitting(true);

    // Initiate POST request
    try {
      const response = await fetch(jblsData.restBaseUrl + 'jbls/v1/jbls-applications', {
        method: 'POST',
        headers: {
          'X-WP-Nonce': jblsData.nonce
        },
        body: formData
      });
      
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();

      // Handle successful submission
      setIsSubmitted(true);
      
      // Handle the response data
      // Reset state
      setValues({
        name: '',
        email: '',
        cover: '',
        resume: null,
        consent: false
      });
      setErrors({
        name: '',
        email: '',
        cover: '',
        resume: '',
        consent: ''
      });
      // Reset all file input elements
      const fileInputs = document.querySelectorAll('.jbls-form input[type="file"]');
      fileInputs.forEach((input) => (input.value = ''));
      // Reset captcha
      if (recaptchaRef.current) {
        recaptchaRef.current.reset();
      }
      // Stop submitting after successful submission
      setIsSubmitting(false);
    } catch (error) {
      // Set the error message
      setFormError(`Submission failed: ${error.message}`);
      // Reset captcha
      if (recaptchaRef.current) {
        recaptchaRef.current.reset();
      }
      // Stop submitting on errors
      setIsSubmitting(false);
    }
  }
  
  return (
    <div className="jbls-form">
      {isSubmitted ? (
        <FormSuccess />
      ) : (
        <>
          {formError && <FormError errorMessage={formError} />}
          <form className="jbls-form__form" onSubmit={handleSubmit} encType="multipart/form-data">
            <h2 className="jbls-form__title">Apply for this job</h2>
            <p className="jbls-form__subtitle">Use the form below to submit your job application</p>
            <div className="jbls-form__required jbls-text-size-small">* indicates a required field</div>
            {inputConfig.map((config, index) => {
              return (
                <InputFactory
                  key={index}
                  {...config}
                  onChange={handleChange}
                  value={values[config.name]}
                  error={errors[config.name]}
                />
              );
            })}
            <ReCAPTCHA
              ref={recaptchaRef}
              sitekey={jblsData.captchaSiteKey}
              size="invisible"
              onChange={handleCaptchaVerification}
            />
            <button disabled={isSubmitting} type="submit" className="jbls-form__submit">
              {isSubmitting ? 'Submitting...' : 'Submit'}
            </button>
          </form>
        </>
      )}
    </div>
  )
}

export default Form;

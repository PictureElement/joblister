/**
 * Validate input values for a name, email, and resume file.
 * 
 * For name:
 * - It checks if the name is provided.
 * - It validates that the name is at least 2 characters and no more than 70 characters.
 * 
 * For email:
 * - It checks if the email is provided.
 * - It uses a regular expression to check if the email is in a valid format.
 * 
 *  * For cover letter:
 * - It checks if the cover letter is provided.
 * - It validates that the cover letter is no more than maxLength characters long.
 * 
 * For resume file:
 * - It checks if the file is provided.
 * - It validates the file extension, ensuring it is one of: 'pdf', 'doc', 'docx'.
 * - It validates the file type, ensuring it is one of: 'application/pdf', 'application/msword', 
 *   'application/vnd.openxmlformats-officedocument.wordprocessingml.document'.
 * - It checks if the file size is less than or equal to 5MB.
 * 
 * @param {Object} values - The input values to validate. It should have properties 'name', 'email', and 'resume'.
 * @returns {Object} errors - An object containing error messages for each input value. 
 *                            If a value is valid, there will be no corresponding property in the object. 
 *                            If a value is invalid, the property's value will be a string describing the error.
 */
export default function validate(values) {
  let errors = {};
  
  if (!values.name) {
    errors.name = 'Enter your name';
  } else if (values.name.length < 2) {
    errors.name = 'Use 2 characters or more for your name';
  } else if (values.name.length > 70) {
    errors.name = 'Use 70 characters or less for your name';
  }
  
  const validEmailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

  if (!values.email) {
    errors.email = 'Enter your email';
  } else if (!validEmailRegex.test(values.email)) {
    errors.email = 'Enter a valid email address';
  }

  const maxLength = 4000;

  if (!values.cover) {
    errors.cover = 'Provide a cover letter';
  } else if (values.cover.length > maxLength) {
    errors.cover = `Cover letter should be no more than ${maxLength} characters`;
  }

  if (!values.resume) {
    errors.resume = 'Upload your resume';
  } else if (!['pdf', 'doc', 'docx'].includes(values.resume.name.split('.').pop().toLowerCase())) {
    errors.resume = 'Invalid file extension. Please upload a .pdf, .doc, or .docx file.';
  } else if (!['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'].includes(values.resume.type)) {
    errors.resume = 'Invalid file type. Please upload a .pdf, .doc, or .docx file.';
  } else if (values.resume.size > 5000000) {
    errors.resume = 'File size is too large. Please upload a file that is 5MB or less.';
  }

  if (!values.consent) {
    errors.consent = 'Consent is required.';
  }

  return errors;
}

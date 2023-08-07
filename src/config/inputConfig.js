// inputConfig.js
// Configuration file for input fields used in the application form

const inputConfig = [
  {
    name: 'name',
    type: 'text',
    helper: '',
    label: '* Name'
  },
  {
    name: 'email',
    type: 'text',
    helper: '',
    label: '* Email'
  },
  {
    name: 'cover',
    type: 'textarea',
    helper: '',
    label: '* Cover Letter'
  },
  {
    name: 'resume',
    type: 'file',
    helper: 'Allowed Type(s): .pdf, .doc, .docx',
    label: '* Resume',
    accept: '.pdf,.doc,.docx'
  }
];

export default inputConfig;

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
  },
  {
    name: 'consent',
    type: 'checkbox',
    label: `I consent to have this website collect my submitted information so they can respond to my inquiry. I have read and accept the <a target="_blank" rel="noopener noreferrer" href="${jblsData.privacyLink}">Privacy Policy</a>.`
  }
];

export default inputConfig;

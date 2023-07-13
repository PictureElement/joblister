// inputConfig.js
// Configuration file for input fields used in the application form

const inputConfig = [
  {
    name: 'name',
    type: 'text',
    hint: 'Must have at least 6 characters',
    label: '* Name'
  },
  {
    name: 'email',
    type: 'text',
    hint: 'Must be a valid email address',
    label: '* Email'
  }
];

export default inputConfig;

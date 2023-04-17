import App from './App';
import './index.scss';

// We are using wp.element here.
const { render } = wp.element;

// Check if element exists before rendering
if (document.getElementById('msofJobsRoot')) {
  render(
    <App />,
    document.getElementById('msofJobsRoot')
  );
}

import './index.scss';
import App from './App';
import { createRoot, render } from '@wordpress/element';
import { RecoilRoot } from 'recoil';

const domElement = document.getElementById('jlRoot');

if (createRoot) {
  createRoot(domElement).render(
    <React.StrictMode>
      <RecoilRoot>
        <App />
      </RecoilRoot>
    </React.StrictMode>
  );
} else {
  render(
    <React.StrictMode>
      <RecoilRoot>
        <App />
      </RecoilRoot>
    </React.StrictMode>
  );
}

const { createRoot } = wp.element;
import { RecoilRoot } from 'recoil';
import App from './App';
import './index.scss';

const domNode = document.getElementById('jbls-root');

if (domNode) {
  const root = createRoot(domNode);
  root.render(
    <React.StrictMode>
      <RecoilRoot>
        <App />
      </RecoilRoot>
    </React.StrictMode>
  );
}

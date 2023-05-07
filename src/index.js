import Multi from './routes/Multi';
import Single from './routes/Single';
import './index.scss';
import { createRoot, render } from '@wordpress/element';
import { HashRouter, Routes, Route } from "react-router-dom";
import { RecoilRoot } from 'recoil';

const domElement = document.getElementById('jlRoot');

if (createRoot) {
  createRoot(domElement).render(
    <React.StrictMode>
      <RecoilRoot>
        <HashRouter>
          <Routes>
            <Route path="/">
              <Route index element={<Multi />} />
              <Route path=":id" element={<Single />} />
            </Route>
          </Routes>
        </HashRouter>
      </RecoilRoot>
    </React.StrictMode>
  );
} else {
  render(
    <React.StrictMode>
      <RecoilRoot>
        <HashRouter>
          <Routes>
            <Route path="/">
              <Route index element={<Multi />} />
              <Route path=":id" element={<Single />} />
            </Route>
          </Routes>
        </HashRouter>
      </RecoilRoot>
    </React.StrictMode>
  );
}

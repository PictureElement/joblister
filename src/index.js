import './index.scss';
import App from './App';
import Single from './routes/Single';
import Multiple from './routes/Multiple';
import { createRoot, render } from '@wordpress/element';
import { HashRouter, Routes, Route } from "react-router-dom";

const domElement = document.getElementById('jlRoot');

if (createRoot) {
  createRoot(domElement).render(
    <React.StrictMode>
      <HashRouter>
        <Routes>
          <Route path="/" element={<App />}>
            <Route index element={<Multiple />} />
            <Route path=":id" element={<Single />} />
          </Route>
        </Routes>
      </HashRouter>
    </React.StrictMode>
  );
} else {
  render(
    <React.StrictMode>
      <HashRouter>
        <Routes>
          <Route path="/" element={<App />}>
            <Route index element={<Multiple />} />
            <Route path=":id" element={<Single />} />
          </Route>
        </Routes>
      </HashRouter>
    </React.StrictMode>
  );
}

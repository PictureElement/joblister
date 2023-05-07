import Multi from './routes/Multi';
import Single from './routes/Single';
import './index.scss';
import { createRoot, render } from '@wordpress/element';
import { HashRouter, Routes, Route } from "react-router-dom";

const domElement = document.getElementById('jlRoot');

if (createRoot) {
  createRoot(domElement).render(
    <HashRouter>
      <Routes>
        <Route path="/">
          <Route index element={<Multi />} />
          <Route path=":id" element={<Single />} />
        </Route>
      </Routes>
    </HashRouter>
  );
} else {
  render(
    <HashRouter>
      <Routes>
        <Route path="/">
          <Route index element={<Multi />} />
          <Route path=":id" element={<Single />} />
        </Route>
      </Routes>
    </HashRouter>
  );
}

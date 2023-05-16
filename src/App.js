import { RecoilRoot } from 'recoil';
import { Outlet } from "react-router-dom";

function App() {
  return (
    <RecoilRoot>
      <Outlet />
    </RecoilRoot>
  )
}

export default App;
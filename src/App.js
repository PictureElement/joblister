import { RecoilRoot } from 'recoil';
import { Outlet } from "react-router-dom";

function App() {
  return (
    <RecoilRoot>
      {endpointJobs}<br />
      {endpointLocations}<br />
      {endpointCategories}<br />
      {endpointTypes}<br />
      {endpointExperienceLevels}<br />
      <Outlet />
    </RecoilRoot>
  )
}

export default App;
import { useState } from 'react';
import { RecoilRoot } from 'recoil';
import { Outlet } from "react-router-dom";
import {
  allJobsState,
  allLocationsState,
  allCategoriesState,
  allTypesState,
  allExperienceLevelsState
} from './recoil-state';

function App() {
  /**
   * State variables
   * Notes:
   * - Use useSetRecoilState() when a component intends to write to state without reading it.
   */
  const [endpointJobs] = useState(
    process.env.APP_ENV === 'dev' ?
    process.env.APP_BASE_URL_DEV + process.env.APP_ENDPOINT_JOBS :
    process.env.APP_BASE_URL_PROD + process.env.APP_ENDPOINT_JOBS
  );
  const [endpointLocations] = useState(
    process.env.APP_ENV === 'dev' ?
    process.env.APP_BASE_URL_DEV + process.env.APP_ENDPOINT_LOCATIONS :
    process.env.APP_BASE_URL_PROD + process.env.APP_ENDPOINT_LOCATIONS
  );
  const [endpointCategories] = useState(
    process.env.APP_ENV === 'dev' ?
    process.env.APP_BASE_URL_DEV + process.env.APP_ENDPOINT_CATEGORIES :
    process.env.APP_BASE_URL_PROD + process.env.APP_ENDPOINT_CATEGORIES
  );
  const [endpointTypes] = useState(
    process.env.APP_ENV === 'dev' ?
    process.env.APP_BASE_URL_DEV + process.env.APP_ENDPOINT_TYPES :
    process.env.APP_BASE_URL_PROD + process.env.APP_ENDPOINT_TYPES
  );
  const [endpointExperienceLevels] = useState(
    process.env.APP_ENV === 'dev' ?
    process.env.APP_BASE_URL_DEV + process.env.APP_ENDPOINT_EXPERIENCE_LEVELS :
    process.env.APP_BASE_URL_PROD + process.env.APP_ENDPOINT_EXPERIENCE_LEVELS
  );

  return (
    <RecoilRoot>
      {endpointJobs}<br />
      {endpointLocations}<br />
      {endpointCategories}<br />
      {endpointTypes}<br />
      {endpointExperienceLevels}
      {/* <Outlet /> */}
    </RecoilRoot>
  )
}

export default App;
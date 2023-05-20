import Single from './routes/Single';
import Multiple from './routes/Multiple';
import { useState, useEffect } from 'react';
import { useSetRecoilState } from 'recoil';
import { HashRouter, Routes, Route } from "react-router-dom";
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
   * - Use useSetRecoilState() when a component intends to write to state without reading it.
   */
  const setAllJobs = useSetRecoilState(allJobsState);
  const setAllLocations = useSetRecoilState(allLocationsState);
  const setAllCategories = useSetRecoilState(allCategoriesState);
  const setAllTypes = useSetRecoilState(allTypesState);
  const setAllExperienceLevels = useSetRecoilState(allExperienceLevelsState);
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

  async function getData() {
    try {
      /**
       * Fetch jobs and set recoil state
       */
      const response1 = await fetch(endpointJobs + '?per_page=' + process.env.APP_PER_PAGE);
      const data1 = await response1.json();
      setAllJobs(data1);

      /**
       * Fetch locations and set recoil state
       */
      const response2 = await fetch(endpointLocations + '?per_page=' + process.env.APP_PER_PAGE);
      const data2 = await response2.json();
      // Filter out locations with a count of 0
      setAllLocations(data2.filter(location => location.count > 0));

      /**
       * Fetch categories and set recoil state
       */
      const response3 = await fetch(endpointCategories + '?per_page=' + process.env.APP_PER_PAGE);
      const data3 = await response3.json();
      // Filter out categories with a count of 0
      setAllCategories(data3.filter(category => category.count > 0));

      /**
       * Fetch types and set recoil state
       */
      const response4 = await fetch(endpointTypes + '?per_page=' + process.env.APP_PER_PAGE);
      const data4 = await response4.json();
      // Filter out types with a count of 0
      setAllTypes(data4.filter(type => type.count > 0));

      /**
       * Fetch experience levels and set recoil state
       */
      const response5 = await fetch(endpointExperienceLevels + '?per_page=' + process.env.APP_PER_PAGE);
      const data5 = await response5.json();
      // Filter out experience levels with a count of 0
      setAllExperienceLevels(data5.filter(experienceLevel => experienceLevel.count > 0));
    } catch (error) {
      console.error(error);
    }
  }

  useEffect(() => {
    getData();
  }, []); // An empty array means it only runs once (after the component is mounted).

  return (
    <HashRouter>
      <Routes>
        <Route path="/" element={<Multiple />} />
        <Route path="/:idDashSlug" element={<Single />} />
      </Routes>
    </HashRouter>
  )
}

export default App;
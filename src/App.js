import Single from './routes/Single';
import Multiple from './routes/Multiple';
import { useState, useEffect } from 'react';
import { useSetRecoilState } from 'recoil';
import { HashRouter, Routes, Route } from 'react-router-dom';
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
  const [endpointJobs] = useState(jblsData.restBaseUrl + 'jbls/v1/jbls-jobs' + jblsData.separator + 'per_page=100');
  const [endpointLocations] = useState(jblsData.restBaseUrl + 'jbls/v1/jbls-locations' + jblsData.separator + 'per_page=100');
  const [endpointCategories] = useState(jblsData.restBaseUrl + 'jbls/v1/jbls-categories' + jblsData.separator + 'per_page=100');
  const [endpointTypes] = useState(jblsData.restBaseUrl + 'jbls/v1/jbls-types' + jblsData.separator + 'per_page=100');
  const [endpointExperienceLevels] = useState(jblsData.restBaseUrl + 'jbls/v1/jbls-experience-levels' + jblsData.separator + 'per_page=100');
  const [loading, setLoading] = useState(true);

  const getData = async() => {
    try {
      /**
       * Fetch jobs and set recoil state
       */
      const response1 = await fetch(endpointJobs);
      const data1 = await response1.json();
      setAllJobs(data1);

      /**
       * Fetch locations and set recoil state
       */
      const response2 = await fetch(endpointLocations);
      const data2 = await response2.json();
      // Filter out locations with a count of 0
      setAllLocations(data2.filter(location => location.count > 0));

      /**
       * Fetch categories and set recoil state
       */
      const response3 = await fetch(endpointCategories);
      const data3 = await response3.json();
      // Filter out categories with a count of 0
      setAllCategories(data3.filter(category => category.count > 0));

      /**
       * Fetch types and set recoil state
       */
      const response4 = await fetch(endpointTypes);
      const data4 = await response4.json();
      // Filter out types with a count of 0
      setAllTypes(data4.filter(type => type.count > 0));

      /**
       * Fetch experience levels and set recoil state
       */
      const response5 = await fetch(endpointExperienceLevels);
      const data5 = await response5.json();
      // Filter out experience levels with a count of 0
      setAllExperienceLevels(data5.filter(experienceLevel => experienceLevel.count > 0));

      // Set loading to false once data fetching is complete
      setLoading(false);
    } catch (error) {
      console.error(error);
    }
  }

  useEffect(() => {
    getData();
  }, []); // An empty array means it only runs once (after the component is mounted).

  // Render loading state while data is being fetched
  if (loading) {
    return (
      <div className="jbls-dot-flashing"><span className="jbls-visually-hidden">Loading...</span></div>
    )
  }

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

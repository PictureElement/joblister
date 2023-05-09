import { useState, useEffect } from 'react';
import { useSetRecoilState } from 'recoil';
import {
  allJobsState,
  allLocationsState,
  allCategoriesState,
  allTypesState,
  allExperienceLevelsState
} from '../recoil-state';

function Multiple() {
  /**
   * State variables
   * Notes:
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

  return (
    <div>Multiple</div>
  )
}

export default Multiple;
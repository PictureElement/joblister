import { atom, selector } from 'recoil';

/**
 * Atoms
 */
const allJobsState = atom({
  key: "allJobsState",
  default: []
});

const allLocationsState = atom({
  key: "allLocationsState",
  default: []
});

const allCategoriesState = atom({
  key: "allCategoriesState",
  default: []
});

const allTypesState = atom({
  key: "allTypesState",
  default: []
});

const allExperienceLevelsState = atom({
  key: "allExperienceLevelsState",
  default: []
});

const selectedJobIdState = selector({
  key: "selectedJobId",
  default: null
});

/**
 * Selectors
 */
const filteredJobsState = selector({
  key: "filteredJobsState",
  get: ({ get }) => {
    let list = get(allJobsState);
    return list;
  },
})

const selectedJobState = selector({
  key: 'selectedJobState',
  get: ({ get }) => {
    const selectedJobId = get(selectedJobIdState);
    const allJobs = get(allJobsState);
    return allJobs.find((job) => job.id === selectedJobId) || null;
  },
});

export {
  allJobsState,
  allLocationsState,
  allCategoriesState,
  allTypesState,
  allExperienceLevelsState,
  selectedJobIdState,
  filteredJobsState,
  selectedJobState
};
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

export {
  allJobsState,
  allLocationsState,
  allCategoriesState,
  allTypesState,
  allExperienceLevelsState
};
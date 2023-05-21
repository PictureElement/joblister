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

const searchQueryState = atom({
  key: "searchQueryState",
  default: ''
});

/**
 * Selectors
 */
const filteredJobsState = selector({
  key: "filteredJobsState",
  get: ({ get }) => {
    const searchQuery = get(searchQueryState);
    let list = get(allJobsState);

    if (searchQuery) {
      // Make string comparisons case-insensitive by converting to lowercase
      list = list.filter((item) => (item.title).toLowerCase().includes(searchQuery.toLocaleLowerCase()));
      // Return the list since search cancels filtration.
      return list;
    }

    return list;
  },
})

export {
  allJobsState,
  allLocationsState,
  allCategoriesState,
  allTypesState,
  allExperienceLevelsState,
  searchQueryState,
  filteredJobsState
};
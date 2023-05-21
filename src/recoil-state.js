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

const categoryFiltersState = atom({
  key: "categoryFiltersState",
  default: []
});

/**
 * Selectors
 */
const filteredJobsState = selector({
  key: "filteredJobsState",
  get: ({ get }) => {
    const searchQuery = get(searchQueryState);
    const categoryFilters = get(categoryFiltersState);
    const categoryFiltersIds = categoryFilters.map(category => category.id);
    let jobList = get(allJobsState);

    if (searchQuery) {
      // Make string comparisons case-insensitive by converting to lowercase
      jobList = jobList.filter((job) => (job.title).toLowerCase().includes(searchQuery.toLocaleLowerCase()));
      // Return the list since search cancels filtration.
      return jobList;
    }

    if (categoryFiltersIds.length) {
      // Include the job if its ID is included in the categoryFilterIds
      jobList = jobList.filter(job => categoryFiltersIds.includes(job.category.id));
    }

    return jobList;
  },
})

export {
  allJobsState,
  allLocationsState,
  allCategoriesState,
  allTypesState,
  allExperienceLevelsState,
  searchQueryState,
  categoryFiltersState,
  filteredJobsState
};
import { atom, selector } from 'recoil';

/**
 * Atoms
 */
const allJobsState = atom({
  key: 'allJobsState',
  default: []
});

const allLocationsState = atom({
  key: 'allLocationsState',
  default: []
});

const allCategoriesState = atom({
  key: 'allCategoriesState',
  default: []
});

const allTypesState = atom({
  key: 'allTypesState',
  default: []
});

const allExperienceLevelsState = atom({
  key: 'allExperienceLevelsState',
  default: []
});

const searchQueryState = atom({
  key: 'searchQueryState',
  default: ''
});

const locationFiltersState = atom({
  key: 'locationFiltersState',
  default: []
});

const categoryFiltersState = atom({
  key: 'categoryFiltersState',
  default: []
});

const typeFiltersState = atom({
  key: 'typeFiltersState',
  default: []
});

const experienceLevelFiltersState = atom({
  key: 'experienceLevelFiltersState',
  default: []
});

const currentPageState = atom({
  key: 'currentPageState',
  default: 1
});

const viewState = atom({
  key: 'viewState',
  default: 'list'
});

/**
 * Selectors
 */
const filteredJobsState = selector({
  key: 'filteredJobsState',
  get: ({ get }) => {
    const searchQuery = get(searchQueryState);
    const locationFilters = get(locationFiltersState);
    const locationFiltersIds = locationFilters.map(location => location.id);
    const categoryFilters = get(categoryFiltersState);
    const categoryFiltersIds = categoryFilters.map(category => category.id);
    const typeFilters = get(typeFiltersState);
    const typeFiltersIds = typeFilters.map(type => type.id);
    const experienceLevelFilters = get(experienceLevelFiltersState);
    const experienceLevelFiltersIds = experienceLevelFilters.map(experienceLevel => experienceLevel.id);

    const currentPage = get(currentPageState);
    const perPage = parseInt(jblsData.perPage, 10);
    const startIndex = (currentPage - 1) * perPage;
    const endIndex = startIndex + perPage;

    let jobList = get(allJobsState);

    if (searchQuery) {
      // Make string comparisons case-insensitive by converting to lowercase
      jobList = jobList.filter((job) => (job.title).toLowerCase().includes(searchQuery.toLocaleLowerCase()));

      const filteredJobs = jobList.slice(startIndex, endIndex);
      const totalPages = Math.ceil(jobList.length / perPage);
      const totalJobs = jobList.length;
      
      // Early return since search cancels filtration.
      return {
        filteredJobs,
        totalPages,
        totalJobs,
      }
    }

    if (locationFiltersIds.length) {
      // Include the job if its ID is included in the locationFilterIds
      jobList = jobList.filter(job => job.location && locationFiltersIds.includes(job.location.id));
    }

    if (categoryFiltersIds.length) {
      // Include the job if its ID is included in the categoryFilterIds
      jobList = jobList.filter(job => job.category && categoryFiltersIds.includes(job.category.id));
    }

    if (typeFiltersIds.length) {
      // Include the job if its ID is included in the typeFilterIds
      jobList = jobList.filter(job => job.type && typeFiltersIds.includes(job.type.id));
    }

    if (experienceLevelFiltersIds.length) {
      // Include the job if its ID is included in the experienceLevelFiltersIds
      jobList = jobList.filter(job => job.experience_level && experienceLevelFiltersIds.includes(job.experience_level.id));
    }

    const filteredJobs = jobList.slice(startIndex, endIndex);
    const totalPages = Math.ceil(jobList.length / perPage);
    const totalJobs = jobList.length;
    
    // Return paginated filtered job list and total pages 
    return {
      filteredJobs,
      totalPages,
      totalJobs,
    }
  },
})

export {
  allJobsState,
  allLocationsState,
  allCategoriesState,
  allTypesState,
  allExperienceLevelsState,
  searchQueryState,
  locationFiltersState,
  categoryFiltersState,
  typeFiltersState,
  experienceLevelFiltersState,
  currentPageState,
  viewState,
  filteredJobsState
};

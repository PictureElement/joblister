import { useEffect } from 'react';
import JobList from '../components/JobList';
import Search from '../components/Search';
import SelectMulti from '../components/SelectMulti';
import Pagination from '../components/Pagination';
import { useRecoilValue, useRecoilState, useSetRecoilState } from 'recoil';
import {
  allLocationsState,
  locationFiltersState,
  allCategoriesState,
  categoryFiltersState,
  allTypesState,
  typeFiltersState,
  allExperienceLevelsState,
  experienceLevelFiltersState,
  currentPageState,
  searchQueryState,
  filteredJobsState 
} from '../recoil-state';
import { useNavigate } from 'react-router-dom';

function Multiple() {
  /**
   * State variables
   * - Use useRecoilValue() when a component intends to read state without writing to it.
   * - Use useRecoilState() when a component intends to read and write state.
   * - Use useSetRecoilState() when a component intends to write to state without reading it.
   */
  const allLocations = useRecoilValue(allLocationsState);
  const [locationFilters, setLocationFilters] = useRecoilState(locationFiltersState);
  const allCategories = useRecoilValue(allCategoriesState);
  const [categoryFilters, setCategoryFilters] = useRecoilState(categoryFiltersState);
  const allTypes = useRecoilValue(allTypesState);
  const [typeFilters, setTypeFilters] = useRecoilState(typeFiltersState);
  const allExperienceLevels = useRecoilValue(allExperienceLevelsState);
  const [experienceLevelFilters, setExperienceLevelFilters] = useRecoilState(experienceLevelFiltersState);
  const setSearchQuery = useSetRecoilState(searchQueryState);
  const setCurrentPage = useSetRecoilState(currentPageState);
  const { totalJobs } = useRecoilValue(filteredJobsState);

  const navigate = useNavigate();

  const handleFilterChange = (filterState, setFilterState, actionType) => {
    // Clear search
    setSearchQuery('');
    // Reset current page
    setCurrentPage(1);
    // Update the URL
    navigate('');
  
    if (actionType.action === 'clear') {
      // Clear filters
      setFilterState([]);
    }
  
    if (actionType.action === 'select-option') {
      setFilterState([...filterState, actionType.option]);
    }
  
    if (actionType.action === 'remove-value') {
      // Make a shallow copy of the array
      let updatedFilters = [...filterState];
      const index = filterState.indexOf(actionType.removedValue);
      // Remove filter
      updatedFilters.splice(index, 1);
      // Set state
      setFilterState(updatedFilters);
    }
  }

  const handleLocationChange = (_, actionType) => {
    handleFilterChange(locationFilters, setLocationFilters, actionType);
  }
  
  const handleCategoryChange = (_, actionType) => {
    handleFilterChange(categoryFilters, setCategoryFilters, actionType);
  }

  const handleTypeChange = (_, actionType) => {
    handleFilterChange(typeFilters, setTypeFilters, actionType);
  }

  const handleExperienceLevelChange = (_, actionType) => {
    handleFilterChange(experienceLevelFilters, setExperienceLevelFilters, actionType);
  }

  const handleClearAll = () => {
    // Clear search
    setSearchQuery('');
    // Clear filters
    setLocationFilters([]);
    setCategoryFilters([]);
    setTypeFilters([]);
    setExperienceLevelFilters([]);
    // Reset current page
    setCurrentPage(1);
    // Update the URL
    navigate('');
    
  }

  // Scroll to the top of the page when the component is mounted
  useEffect(() => {
    window.scrollTo(0, 0)
  }, [])
  
  return (
    <div className="jbls-multiple">
      <div className="jbls-multiple__search">
        <Search />
      </div>
      <div className="jbls-multiple__filters">
        <SelectMulti
          value={categoryFilters}
          placeholder="--Category--"
          handleChange={handleCategoryChange}
          options={allCategories}
        />
        <SelectMulti
          value={locationFilters}
          placeholder="--Location--"
          handleChange={handleLocationChange}
          options={allLocations}
        />
        <SelectMulti
          value={typeFilters}
          placeholder="--Type--"
          handleChange={handleTypeChange}
          options={allTypes}
        />
        <SelectMulti
          value={experienceLevelFilters}
          placeholder="--Experience--"
          handleChange={handleExperienceLevelChange}
          options={allExperienceLevels}
        />
      </div>
      <div className="jbls-multiple__count-clear">
        <div className="jbls-multiple__count jbls-text-size-h4"><strong>{totalJobs}</strong> jobs found</div>
        <button onClick={handleClearAll} className="jbls-multiple__clear jbls-text-size-h4">Clear all</button>
      </div>
      <div className="jbls-multiple__pagination jbls-multiple__pagination_top">
        <Pagination />
      </div>
      <div className="jbls-multiple__header jbls-clearfix">
        <span className="jbls-text-size-small">Job Title</span>
        <span className="jbls-text-size-small">Category</span>
        <span className="jbls-text-size-small">Location</span>
        <span className="jbls-text-size-small">Experience</span>
      </div>
      <div className="jbls-multiple__list">
        <JobList />
      </div>
      <div className="jbls-multiple__pagination jbls-multiple__pagination_bottom">
        <Pagination />
      </div>
    </div>
  )
}

export default Multiple;

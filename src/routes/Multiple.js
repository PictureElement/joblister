import { useEffect, useState, useRef } from 'react';
import JobList from '../components/JobList';
import JobListAlternative from '../components/JobListAlternative';
import Search from '../components/Search';
import SelectMulti from '../components/SelectMulti';
import Pagination from '../components/Pagination';
import { useRecoilValue, useRecoilState } from 'recoil';
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
import { useNavigate, useLocation } from 'react-router-dom';
import { ReactComponent as ListIcon } from '../icons/list.svg';
import { ReactComponent as GridIcon } from '../icons/grid.svg';

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
  const [searchQuery, setSearchQuery] = useRecoilState(searchQueryState);
  const [currentPage, setCurrentPage] = useRecoilState(currentPageState);
  const { totalPages, totalJobs } = useRecoilValue(filteredJobsState);
  const [view, setView] = useState('list');

  const navigate = useNavigate();
  const location = useLocation();
  
  const isInitialLoad = useRef(true);
  const isUpdatingState = useRef(false);
  const isUpdatingURL = useRef(false);

  const handleFilterChange = (filterState, setFilterState, actionType) => {
    // Clear search
    setSearchQuery('');
    // Reset current page
    setCurrentPage(1);
  
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
  }

  const findFilterByName = (allFilters, names) => {
    return names.map(name => allFilters.find(filter => filter.name === name)).filter(Boolean);
  };
  
  const updateStateFromURL = () => {
    // console.log('Update state from URL');
    const params = new URLSearchParams(location.search);

    const locationParam = params.getAll('location');
    const categoryParam = params.getAll('category');
    const typeParam = params.getAll('type');
    const experienceParam = params.getAll('experience');
    const pageParam = Number(params.get('page'));
    const queryParam = params.get('q');

    setLocationFilters(findFilterByName(allLocations, locationParam));
    setCategoryFilters(findFilterByName(allCategories, categoryParam));
    setTypeFilters(findFilterByName(allTypes, typeParam));
    setExperienceLevelFilters(findFilterByName(allExperienceLevels, experienceParam));

    if (!isNaN(pageParam) && pageParam > 0 && pageParam <= totalPages) {
      setCurrentPage(pageParam);
    }
    setSearchQuery(queryParam || '');
  };

  const updateURLFromState = () => {
    // console.log('Update URL from state');
    const params = new URLSearchParams();

    if (currentPage > 1) params.append('page', currentPage);
    if (searchQuery) params.append('q', searchQuery);
    locationFilters.forEach(filter => params.append('location', filter.name));
    categoryFilters.forEach(filter => params.append('category', filter.name));
    typeFilters.forEach(filter => params.append('type', filter.name));
    experienceLevelFilters.forEach(filter => params.append('experience', filter.name));

    navigate('?' + params.toString(), { replace: true });
  };

  // Update state from URL when the URL changes
  useEffect(() => {
    if (isUpdatingURL.current) {
      isUpdatingURL.current = false;
      return;
    }
    isUpdatingState.current = true;
    updateStateFromURL();
  }, [location.search]);

  // Update URL when the state changes
  useEffect(() => {
    if (isInitialLoad.current) {
      isInitialLoad.current = false;
      return;
    }
    if (isUpdatingState.current) {
      isUpdatingState.current = false;
      return;
    }
    isUpdatingURL.current = true;
    updateURLFromState();
  }, [locationFilters, categoryFilters, typeFilters, experienceLevelFilters, currentPage]);

  return (
    <div className="jbls-multiple">
      <div className="jbls-multiple__search">
        <Search />
      </div>
      <div className="jbls-multiple__divider">
        <span>OR</span>
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
      <div className="jbls-multiple__count-controls">
        <div className="jbls-multiple__count jbls-text-size-h4"><strong>{totalJobs}</strong> jobs found</div>
        <div className="jbls-multiple__controls">
          <button
            className={`jbls-multiple__toggle ${view === 'list' ? 'jbls-multiple__toggle_active' : ''}`}
            onClick={() => setView('list')}
            aria-label="List View"
          >
            <ListIcon />
          </button>
          <button 
            className={`jbls-multiple__toggle ${view === 'grid' ? 'jbls-multiple__toggle_active' : ''}`}
            onClick={() => setView('grid')}
            aria-label="Grid View"
          >
            <GridIcon />
          </button>
          <button onClick={handleClearAll} className="jbls-multiple__clear jbls-text-size-h4">Clear all</button>
        </div>
      </div>
      <div className="jbls-multiple__pagination jbls-multiple__pagination_top">
        <Pagination />
      </div>
      {view === 'list' &&
        <div className="jbls-multiple__header jbls-clearfix">
          <span className="jbls-text-size-small">Job Title</span>
          <span className="jbls-text-size-small">Category</span>
          <span className="jbls-text-size-small">Location</span>
          <span className="jbls-text-size-small">Type</span>
          <span className="jbls-text-size-small">Experience</span>
        </div>
      }
      <div className="jbls-multiple__list">
        {view === 'list' ? <JobList /> : <JobListAlternative />}
      </div>
      <div className="jbls-multiple__pagination jbls-multiple__pagination_bottom">
        <Pagination />
      </div>
    </div>
  )
}

export default Multiple;

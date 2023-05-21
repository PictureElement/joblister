import JobList from '../components/JobList';
import Search from '../components/Search';
import SelectMulti from '../components/SelectMulti';
import { useRecoilValue, useRecoilState, useSetRecoilState } from 'recoil';
import { allLocationsState, locationFiltersState, allCategoriesState, categoryFiltersState, searchQueryState } from '../recoil-state';

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
  const setSearchQuery = useSetRecoilState(searchQueryState);

  function handleLocationChange(_, actionType) {
    // Clear search
    setSearchQuery('');

    if (actionType.action === 'clear') {
      // Clear location filters
      setLocationFilters([]);
    }

    if (actionType.action === 'select-option') {
      setLocationFilters([...locationFilters, actionType.option]);
    }

    if (actionType.action === 'remove-value') {
      // Make a shallow copy of the array
      let updatedLocationFilters = [...locationFilters];
      const index = locationFilters.indexOf(actionType.removedValue);
      // Remove filter
      updatedLocationFilters.splice(index, 1);
      // Set state
      setLocationFilters(updatedLocationFilters);
    }
  }

  function handleCategoryChange(_, actionType) {
    // Clear search
    setSearchQuery('');

    if (actionType.action === 'clear') {
      // Clear category filters
      setCategoryFilters([]);
    }

    if (actionType.action === 'select-option') {
      setCategoryFilters([...categoryFilters, actionType.option]);
    }

    if (actionType.action === 'remove-value') {
      // Make a shallow copy of the array
      let updatedCategoryFilters = [...categoryFilters];
      const index = categoryFilters.indexOf(actionType.removedValue);
      // Remove filter
      updatedCategoryFilters.splice(index, 1);
      // Set state
      setCategoryFilters(updatedCategoryFilters);
    }
  }
  
  return (
    <div className="jl-multiple">
      <div className="jl-multiple__one">
        <Search />
      </div>
      <div className="jl-multiple__two">
        <SelectMulti
          value={locationFilters}
          placeholder="--Location--"
          handleChange={handleLocationChange}
          options={allLocations} 
        />
        <SelectMulti
          value={categoryFilters}
          placeholder="--Category--"
          handleChange={handleCategoryChange}
          options={allCategories} 
        />
      </div>
      <div className="jl-multiple__three">
        <JobList />
      </div>
    </div>
  )
}

export default Multiple;
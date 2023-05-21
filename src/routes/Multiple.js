import JobList from '../components/JobList';
import Search from '../components/Search';
import SelectMulti from '../components/SelectMulti';
import { useRecoilValue, useRecoilState, useSetRecoilState } from 'recoil';
import { allLocationsState, locationFiltersState, allCategoriesState, categoryFiltersState, allTypesState, typeFiltersState, searchQueryState } from '../recoil-state';

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
  const setSearchQuery = useSetRecoilState(searchQueryState);

  function handleFilterChange(filterState, setFilterState, actionType) {
    // Clear search
    setSearchQuery('');
  
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
        <SelectMulti
          value={typeFilters}
          placeholder="--Type--"
          handleChange={handleTypeChange}
          options={allTypes} 
        />
      </div>
      <div className="jl-multiple__three">
        <JobList />
      </div>
    </div>
  )
}

export default Multiple;
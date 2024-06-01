import { ReactComponent as SearchIcon } from '../icons/search.svg';
import { useRecoilState, useSetRecoilState } from 'recoil';
import {
  searchQueryState,
  locationFiltersState,
  categoryFiltersState,
  typeFiltersState,
  experienceLevelFiltersState,
  currentPageState 
} from '../recoil-state';


function Search() {
  /**
   * State variables
   * - Use useSetRecoilState() when a component intends to write to state without reading it.
   * - Use useRecoilState() when a component intends to read and write state.
   */
  const setLocationFilters = useSetRecoilState(locationFiltersState);
  const setCategoryFilters = useSetRecoilState(categoryFiltersState);
  const setTypeFilters = useSetRecoilState(typeFiltersState);
  const setExperienceLevelFilters = useSetRecoilState(experienceLevelFiltersState);
  const setCurrentPage = useSetRecoilState(currentPageState);
  const [searchQuery, setSearchQuery] = useRecoilState(searchQueryState);

  const handleChange = (e) => {
    // Clear all filters
    setLocationFilters([]);
    setCategoryFilters([]);
    setTypeFilters([]);
    setExperienceLevelFilters([]);
    // Reset current page
    setCurrentPage(1);
    // Update search query
    setSearchQuery(e.target.value);
  }

  return (
    <div className="jbls-search">
      <div className="jbls-search__label">
        <div className="jbls-visually-hidden">Search for jobs by keyword</div>
        <SearchIcon />
        <input
          autoFocus
          autoComplete="off"
          value={searchQuery}
          aria-label="Search for jobs by keyword"
          placeholder="Search for jobs by keyword"
          className="jbls-search__input"
          type="search"
          onChange={handleChange}
        />
      </div>
    </div>
  )
}

export default Search;

import { useRecoilState, useSetRecoilState } from 'recoil';
import { searchQueryState } from '../recoil-state';

function Search() {
  /**
   * State variables
   * - Use useRecoilState() when a component intends to read and write state.
   */
  const [searchQuery, setSearchQuery] = useRecoilState(searchQueryState);

  function handleChange(e) {
    setSearchQuery(e.target.value);
  }

  return (
    <div className="jl-search">
      <label htmlFor="jlSearchInput" className="sr-only">Search for jobs by title or keyword</label>
      <div className="jl-search__input-wrapper">
        <input
          value={searchQuery}
          id="jlSearchInput"
          aria-label="Search for jobs by title or keyword"
          placeholder="Search for jobs by title or keyword"
          className="jl-search__input"
          type="search"
          onChange={handleChange}
        />
      </div>
    </div>
  )
}

export default Search;
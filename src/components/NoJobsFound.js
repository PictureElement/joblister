import React from 'react';
import { useSetRecoilState, useRecoilState } from 'recoil';
import {
  locationFiltersState,
  categoryFiltersState,
  typeFiltersState,
  experienceLevelFiltersState,
  currentPageState,
  searchQueryState
} from '../recoil-state';

function NoJobsFound() {
  /**
   * State variables
   * - Use useSetRecoilState() when a component intends to write to state without reading it.
   * - Use useRecoilState() when a component intends to read and write state.
   */
  const [searchQuery, setSearchQuery] = useRecoilState(searchQueryState);
  const setLocationFilters = useSetRecoilState(locationFiltersState);
  const setCategoryFilters = useSetRecoilState(categoryFiltersState);
  const setTypeFilters = useSetRecoilState(typeFiltersState);
  const setExperienceLevelFilters = useSetRecoilState(experienceLevelFiltersState);
  const setCurrentPage = useSetRecoilState(currentPageState);

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

  return (
    <div className="jbls-no-jobs-found">
      <div className="jbls-no-jobs-found__emoji">(&gt;_&lt;)</div>
      {searchQuery.length > 0
        ? (
          <div className="jbls-no-jobs-found__text jbls-text-size-h3">No jobs found for “{searchQuery}”</div>
        ) : (
          <>
            <div className="jbls-no-jobs-found__text jbls-text-size-h3">No jobs found matching your filtering criteria.</div>
            <button onClick={handleClearAll} className="jbls-no-jobs-found__clear jbls-text-size-h4">Clear your filters and try again</button>
          </>
        )
      }
    </div>
  )
}

export default NoJobsFound;

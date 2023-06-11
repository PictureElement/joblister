import { currentPageState, filteredJobsState } from '../recoil-state';
import { useRecoilState, useRecoilValue } from 'recoil';
import { ReactComponent as PreviousIcon } from '../icons/previous.svg';
import { ReactComponent as NextIcon } from '../icons/next.svg';

function Pagination() {
  /**
   * State variables
   * - Use useRecoilState() when a component intends to read and write state.
   * - Use useRecoilValue() when a component intends to read state without writing to it.
   */
  const [currentPage, setCurrentPage] = useRecoilState(currentPageState);
  const {filteredJobs, totalPages} = useRecoilValue(filteredJobsState);
  const visiblePages = 3;

  const handlePageChange = (page) => {
    setCurrentPage(page);
  };

  const generatePagination = () => {
    let pagination = [];
  
    // Calculate the start and end of the pagination range
    let start = Math.max(1, currentPage - Math.floor(visiblePages / 2));
    let end = Math.min(start + visiblePages - 1, totalPages);
  
    // Adjust the start if the end is at the total pages limit
    start = Math.max(1, end - visiblePages + 1);
  
    // Add the ellipsis before the start if necessary
    if (start > 1) {
      pagination.push(1);
      if (start > 2) {
        pagination.push('...');
      }
    }
  
    // Add the page numbers within the range
    for (let page = start; page <= end; page++) {
      pagination.push(page);
    }
  
    // Add the ellipsis after the end if necessary
    if (end < totalPages) {
      if (end < totalPages - 1) {
        pagination.push('...');
      }
      pagination.push(totalPages);
    }
    
    // Map over array of page numbers and return an array of buttons
    return pagination.map((page, index) => {
      if (page === '...') {
        return (
          <button
            key={index}
            className="jl-pagination__control jl-pagination__control_ellipsis"
            disabled
            aria-label="Page ..."
            aria-disabled="true"
          >
            {page}
          </button>
        );
      } else {
        return (
          <button
            key={index}
            className={page === currentPage ? 'jl-pagination__control jl-pagination__control_active' : 'jl-pagination__control'}
            onClick={() => handlePageChange(page)}
            aria-label={`Page ${page}`}
          >
            {page}
          </button>
        );
      }
    });
  };

  // Check if filteredJobs array is empty, and return null to hide the pagination component
  if (filteredJobs.length === 0) {
    return null;
  }

  return (
    <div className="jl-pagination">
      <button
        className="jl-pagination__control jl-pagination__arrow jl-pagination__arrow_prev"
        disabled={currentPage === 1}
        onClick={() => handlePageChange(currentPage - 1)}
        aria-label="Previous page"
      >
        <PreviousIcon />
      </button>
      <div className="jl-pagination__numbers">
        {generatePagination()}
        <div className="jl-pagination__fraction">{currentPage}/{totalPages}</div>
      </div>
      <button
        className="jl-pagination__control jl-pagination__arrow jl-pagination__arrow_next"
        disabled={currentPage === totalPages}
        onClick={() => handlePageChange(currentPage + 1)}
        aria-label="Next page"
      >
        <NextIcon />
      </button>
    </div>
  )
}

export default Pagination;
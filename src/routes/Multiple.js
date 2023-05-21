import JobList from '../components/JobList';
import Search from '../components/Search';

function Multiple() {
  return (
    <div className="jl-multiple">
      <div className="jl-multiple__one">
        <Search />
      </div>
      <div className="jl-multiple__two">
        <JobList />
      </div>
    </div>
  )
}

export default Multiple;
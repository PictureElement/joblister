import { useRecoilValue } from 'recoil';
import { filteredJobsState } from '../recoil-state';
import JobItem from "./JobItem";

function JobList() {
  /**
   * State variables
   * - Use useRecoilValue() when a component intends to read state without writing to it.
   */
  const filteredJobs = useRecoilValue(filteredJobsState);

  const jobItems = filteredJobs.map(job =>
    <JobItem
      key={job.id}
      id={job.id}
      modifiedGMT={job.modified_gmt}
      title={job.title}
      content={job.content}
      location={job.location}
      category={job.category}
      type={job.type}
      experienceLevel={job.experience_level}
    />
  );

  return (
    <>
      {filteredJobs.length > 0
        ?
          <ul className="jl-job-list">
            {jobItems}
          </ul>
        :
          <div>No jobs found matching your filtering criteria.</div>
      }
    </>
  )
}

export default JobList;
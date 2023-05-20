import { useParams } from 'react-router-dom';
import { useRecoilValue } from 'recoil';
import { allJobsState } from '../recoil-state';
import DOMPurify from 'dompurify';

function Single() {
  /**
   * State variables
   * - Use useRecoilValue() when a component intends to read state without writing to it.
   */
  const allJobs = useRecoilValue(allJobsState);

  // Get the :idDashSlug parameter from the URL.
  const { idDashSlug} = useParams();

  // Extract the job id.
  const id = parseInt(idDashSlug.split('-').shift());

  // Find the job 
  const job = allJobs.find((job) => job.id == id);

  // Job details
  const title = { __html: DOMPurify.sanitize(job.title) };
  const content = { __html: DOMPurify.sanitize(job.content) };

  return (
    <div className="jl-single">
      <h1 className="jl-single__title" dangerouslySetInnerHTML={ title }></h1>
      <div className="jl-single__content" dangerouslySetInnerHTML={ content }></div>
    </div>
  )
}

export default Single;
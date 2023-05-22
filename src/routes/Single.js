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
      <div className="jl-single__left">
        <div className="jl-single__header">
          <h1 className="jl-single__title jl-text-size-h1" dangerouslySetInnerHTML={ title }></h1>
        </div>
        <div className="jl-single__content" dangerouslySetInnerHTML={ content }></div>
      </div>
      <div className="jl-single__right">
        Sidebar
      </div>
    </div>
  )
}

export default Single;
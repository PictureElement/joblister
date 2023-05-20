import { useParams } from 'react-router-dom';
import { useRecoilValue } from 'recoil';
import { allJobsState } from '../recoil-state';

function Single() {

  // Get the :idDashSlug parameter from the URL.
  const { idDashSlug} = useParams();

  // Extract the job id.
  const id = parseInt(idDashSlug.split('-').shift());

  /**
   * State variables
   * - Use useRecoilValue() when a component intends to read state without writing to it.
   */
  const allJobs = useRecoilValue(allJobsState);

  const job = allJobs.find((job) => job.id == id);

  return (
    <div>
      {job.title}
    </div>
  )
}

export default Single;
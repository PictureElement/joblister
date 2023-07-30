import { useParams } from 'react-router-dom';
import { useRecoilValue } from 'recoil';
import { Link } from 'react-router-dom';
import { allJobsState } from '../recoil-state';
import DOMPurify from 'dompurify';
import { calculateTimeAgo } from '../utils';
import { ReactComponent as BackIcon } from '../icons/back.svg';
import Form from '../components/form';
import {
  EmailShareButton,
  FacebookShareButton,
  LinkedinShareButton,
  TwitterShareButton,
  EmailIcon,
  FacebookIcon,
  LinkedinIcon,
  TwitterIcon
} from "react-share";

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
  const updatedTimeAgo = calculateTimeAgo(job.modified_gmt);
  const location = job.location.name;
  const category = job.category.name;
  const type = job.type.name;
  const experienceLevel = job.experience_level.name;
  
  const shareUrl = window.location.href;

  // Smoothly scroll to the application form
  function scrollToForm() {
    document.querySelector('.jl-form').scrollIntoView({ behavior: 'smooth' });
  };
  
  return (
    <div className="jl-single">
      <div className="jl-single__header">
        <div className="jl-single__header-left">
          { title.__html ?
            <h1 className="jl-single__title jl-text-size-h1" dangerouslySetInnerHTML={ title }></h1>
            :
            <h1 className="jl-single__title jl-text-size-h1">(no title)</h1>
          } 
          <div className="jl-single__subtitle jl-text-size-small">
            Job ID: {id} | Updated {updatedTimeAgo}
          </div>
        </div>
        <div className="jl-single__header-right">
          <button onClick={scrollToForm} className="jl-single__apply">Apply</button>
        </div>
      </div>
      <div className="jl-single__body">
        <div className="jl-single__body-left">
          { content.__html ?
            <div className="jl-single__content" dangerouslySetInnerHTML={ content }></div>
            :
            <div className="jl-single__content">—</div>
          }
        </div>
        <div className="jl-single__body-right">
          <div className="jl-job-details">
            <h2 className="jl-job-details__title jl-text-size-h2">Job details</h2>
            <div className="jl-job-details__category">
              <h3 className="jl-text-size-p">Location</h3>
              <div className="jl-text-size-p">{location ? location : '—'}</div>
            </div>
            <div className="jl-job-details__category">
              <h3 className="jl-text-size-p">Category</h3>
              <div className="jl-text-size-p">{category ? category : '—'}</div>
            </div>
            <div className="jl-job-details__category">
              <h3 className="jl-text-size-p">Type</h3>
              <div className="jl-text-size-p">{type ? type : '—'}</div>
            </div>
            <div className="jl-job-details__category">
              <h3 className="jl-text-size-p">Experience</h3>
              <div className="jl-text-size-p">{experienceLevel ? experienceLevel : '—'}</div>
            </div>
          </div>
          <div className="jl-share">
            <h2 className="jl-share__title jl-text-size-h2">Share this job</h2>
            <div className="jl-share__container">
              <FacebookShareButton url={shareUrl}>
                <FacebookIcon size={32} />
              </FacebookShareButton>
              <LinkedinShareButton url={shareUrl}>
                <LinkedinIcon size={32} />
              </LinkedinShareButton>
              <TwitterShareButton url={shareUrl}>
                <TwitterIcon size={32} />
              </TwitterShareButton>
              <EmailShareButton url={shareUrl}>
                <EmailIcon size={32} />
              </EmailShareButton>
            </div>
          </div>
        </div>
      </div>
      <Form />
      <Link to="/" className="jl-single__back-to-listing jl-text-size-h4">
        <BackIcon /> Back to listing
      </Link>  
    </div>
  )
}

export default Single;
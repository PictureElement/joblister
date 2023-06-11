import { useParams } from 'react-router-dom';
import { useRecoilValue } from 'recoil';
import { Link } from 'react-router-dom';
import { allJobsState } from '../recoil-state';
import DOMPurify from 'dompurify';
import { calculateTimeAgo } from '../utils';
import { ReactComponent as BackIcon } from '../icons/back.svg';

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

  return (
    <div className="jl-single">
      <div className="jl-single__header">
        <div className="jl-single__header-left">
          <h1 className="jl-single__title jl-text-size-h1" dangerouslySetInnerHTML={ title }></h1>
          <div className="jl-single__subtitle jl-text-size-small">
            Job ID: {id} | Updated {updatedTimeAgo}
          </div>
        </div>
        <div className="jl-single__header-right">
          <a href="#apply" className="jl-single__apply">Apply</a>
        </div>
      </div>
      <div className="jl-single__body">
        <div className="jl-single__body-left">
          <div className="jl-single__content" dangerouslySetInnerHTML={ content }></div>
        </div>
        <div className="jl-single__body-right">
          <hr className="jl-mobile-only" />
          <div className="jl-single__widget">
            <h2 className="jl-single__widget-title jl-text-size-h2">Job details</h2>
            <div className="jl-single__widget-item-category">
              <h3 className="jl-text-size-p">Location</h3>
              <div className="jl-text-size-p">{location ? location : 'N/A'}</div>
            </div>
            <div className="jl-single__widget-item-category">
              <h3 className="jl-text-size-p">Category</h3>
              <div className="jl-text-size-p">{category ? category : 'N/A'}</div>
            </div>
            <div className="jl-single__widget-item-category">
              <h3 className="jl-text-size-p">Type</h3>
              <div className="jl-text-size-p">{type ? type : 'N/A'}</div>
            </div>
            <div className="jl-single__widget-item-category">
              <h3 className="jl-text-size-p">Experience</h3>
              <div className="jl-text-size-p">{experienceLevel ? experienceLevel : 'N/A'}</div>
            </div>
          </div>
          <hr />
          <div className="jl-single__widget">
            <h2 className="jl-single__widget-title jl-text-size-h2">Share this job</h2>
            <div className="jl-single__widget-item-social">
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
      <hr className="jl-mobile-only" />
      <div className="jl-single__footer">
        <Link to="/" className="jl-single__back-to-listing jl-text-size-h4">
          <BackIcon /> Back to listing
        </Link>
      </div>
    </div>
  )
}

export default Single;
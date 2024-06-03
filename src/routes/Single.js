import { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { useRecoilValue } from 'recoil';
import { allJobsState } from '../recoil-state';
import slugify from 'react-slugify';
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
  XIcon
} from 'react-share';

function sanitizeToPlainText(html) {
  return DOMPurify.sanitize(html, { ALLOWED_TAGS: [], ALLOWED_ATTR: [] });
}

function Single() {
  /**
   * State variables
   * - Use useRecoilValue() when a component intends to read state without writing to it.
   */
  const allJobs = useRecoilValue(allJobsState);
  const [job, setJob] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  const navigate = useNavigate();
  // Get the :idDashSlug parameter from the URL.
  const { idDashSlug } = useParams();

  useEffect(() => {
    // Scroll to the top of the page.
    window.scrollTo(0, 0);

    // Extract the job id and slug from the URL parameter.
    const [idPart, ...slugParts] = idDashSlug.split('-');
    const id = parseInt(idPart);
    const slug = slugParts.join('-');

    // Validate the job ID
    if (isNaN(id)) {
      setError('Invalid job ID.');
      setLoading(false);
      return;
    }

    // Find the job with the matching ID and slug
    const foundJob = allJobs.find((job) => job.id == id && slugify(job.title) === slug);
    
    if (!foundJob) {
      setError('Job not found.');
    } else {
      setJob(foundJob);
    }

    setLoading(false);
  }, [idDashSlug, allJobs]);

  // Smoothly scroll to the application form
  const handleScrollToForm = () => {
    document.querySelector('.jbls-form').scrollIntoView({ behavior: 'smooth' });
  };

  if (loading) {
    return <div>Loading...</div>;
  }

  if (error) {
    return <div>{error}</div>;
  }

  // Job details
  const title = job.title ? sanitizeToPlainText(job.title) : '(no title)';
  const content = job.content
    ? { __html: DOMPurify.sanitize(job.content, { ALLOWED_ATTR: ['target', 'href', 'rel'] }) }
    : { __html: '—' };
  const updatedTimeAgo = calculateTimeAgo(job.modified_gmt);
  const location = job.location?.name;
  const category = job.category?.name;
  const type = job.type?.name;
  const experienceLevel = job.experience_level?.name;
  const shareUrl = window.location.href;
  
  return (
    <div className="jbls-single">
      <div className="jbls-single__header">
        <div className="jbls-single__header-left">
          <h1 className="jbls-single__title jbls-text-size-h1">{title}</h1>
          <div className="jbls-single__subtitle jbls-text-size-small">
            Job ID: {job.id} | Updated {updatedTimeAgo}
          </div>
        </div>
        <div className="jbls-single__header-right">
          <button onClick={handleScrollToForm} className="jbls-single__apply">Apply</button>
        </div>
      </div>
      <div className="jbls-single__body">
        <div className="jbls-single__body-left">
          {content.__html ?
            <div className="jbls-single__content" dangerouslySetInnerHTML={content}></div>
            :
            <div className="jbls-single__content">—</div>
          }
        </div>
        <div className="jbls-single__body-right">
          <div className="jbls-job-details">
            <h2 className="jbls-job-details__title jbls-text-size-h2">Job details</h2>
            <div className="jbls-job-details__category">
              <h3 className="jbls-text-size-p">Location</h3>
              <div className="jbls-text-size-p">{location ? location : '—'}</div>
            </div>
            <div className="jbls-job-details__category">
              <h3 className="jbls-text-size-p">Category</h3>
              <div className="jbls-text-size-p">{category ? category : '—'}</div>
            </div>
            <div className="jbls-job-details__category">
              <h3 className="jbls-text-size-p">Type</h3>
              <div className="jbls-text-size-p">{type ? type : '—'}</div>
            </div>
            <div className="jbls-job-details__category">
              <h3 className="jbls-text-size-p">Experience</h3>
              <div className="jbls-text-size-p">{experienceLevel ? experienceLevel : '—'}</div>
            </div>
          </div>
          <div className="jbls-share">
            <h2 className="jbls-share__title jbls-text-size-h2">Share this job</h2>
            <div className="jbls-share__container">
              <FacebookShareButton url={shareUrl}>
                <FacebookIcon size={32} />
              </FacebookShareButton>
              <LinkedinShareButton url={shareUrl}>
                <LinkedinIcon size={32} />
              </LinkedinShareButton>
              <TwitterShareButton url={shareUrl}>
                <XIcon size={32} />
              </TwitterShareButton>
              <EmailShareButton url={shareUrl}>
                <EmailIcon size={32} />
              </EmailShareButton>
            </div>
          </div>
        </div>
      </div>
      <Form />
      <button
        onClick={() => navigate(-1)}
        className="jbls-single__back-to-listing jbls-text-size-h4"
      >
        <BackIcon /> Back to jobs
      </button>
    </div>
  )
}

export default Single;

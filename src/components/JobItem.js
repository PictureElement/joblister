import { Link } from 'react-router-dom';
import DOMPurify from 'dompurify';
import slugify from 'react-slugify';
import { calculateTimeAgo } from '../utils';
import { ReactComponent as LocationIcon } from '../icons/location.svg';

function sanitizeToPlainText(html) {
  return DOMPurify.sanitize(html, { ALLOWED_TAGS: [], ALLOWED_ATTR: [] });
}

function JobItem(props) {
  // Props
  const id = props.id;
  const updatedTimeAgo = calculateTimeAgo(props.modifiedGmt);
  const title = sanitizeToPlainText(props.title);
  const slug = slugify(props.title);
  const idDashSlug = `${id}-${slug}`;
  const location = props.location;
  const category = props.category;
  const experienceLevel = props.experienceLevel;

  return (
    <li className="jbls-job-item">
      <Link to={`${idDashSlug}`} className="jbls-job-item__link">
        <div className="jbls-job-item__table">
          <div className="jbls-job-item__row">
            <div className="jbls-job-item__job">
              <div className="jbls-job-item__title jbls-text-size-h3">{title ? title : '(no title)'}</div>
              <div className="jbls-job-item__subtitle jbls-text-size-small">
                Job ID: {id} | Updated {updatedTimeAgo}
              </div>
            </div>
            <div className="jbls-job-item__category"><div className="jbls-text-size-h4">{category ? category : '—'}</div></div>
            <div className="jbls-job-item__location">
              <LocationIcon />
              <div className="jbls-text-size-h4">{location ? location : '—'}</div>
            </div>
            <div className="jbls-job-item__type"><div className="jbls-text-size-h4">{experienceLevel ? experienceLevel : '—'}</div></div>
          </div>
        </div>
      </Link>
    </li>
  )
}

export default JobItem;

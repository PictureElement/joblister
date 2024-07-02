import { Link } from 'react-router-dom';
import DOMPurify from 'dompurify';
import slugify from 'react-slugify';
import { calculateTimeAgo } from '../utils';
import { ReactComponent as LocationIcon } from '../icons/location.svg';
import { ReactComponent as SchoolIcon } from '../icons/school.svg';
import { ReactComponent as ScheduleIcon } from '../icons/schedule.svg';
import { ReactComponent as StacksIcon } from '../icons/stacks.svg';

function sanitizeToPlainText(html) {
  return DOMPurify.sanitize(html, { ALLOWED_TAGS: [], ALLOWED_ATTR: [] });
}

function JobItemAlternative(props) {
  // Props
  const id = props.id;
  const updatedTimeAgo = calculateTimeAgo(props.modifiedGmt);
  const title = sanitizeToPlainText(props.title);
  const slug = slugify(props.title);
  const idDashSlug = `${id}-${slug}`;
  const location = props.location;
  const category = props.category;
  const type = props.type;
  const experienceLevel = props.experienceLevel;

  return (
    <li className="jbls-job-item-alternative">
      <Link to={`${idDashSlug}`} className="jbls-job-item-alternative__link">
        <div className="jbls-job-item-alternative__row">
          <div className="jbls-job-item-alternative__job">
            <div className="jbls-job-item-alternative__title jbls-text-size-h3">{title ? title : '(no title)'}</div>
            <div className="jbls-job-item-alternative__subtitle jbls-text-size-small">
              Job ID: {id} | Updated {updatedTimeAgo}
            </div>
          </div>
          <div className="jbls-job-item-alternative__category">
            <StacksIcon />
            <div className="jbls-text-size-h4">{category ? category : '—'}</div>
          </div>
          <div className="jbls-job-item-alternative__location">
            <LocationIcon />
            <div className="jbls-text-size-h4">{location ? location : '—'}</div>
          </div>
          <div className="jbls-job-item-alternative__type">
            <ScheduleIcon />
            <div className="jbls-text-size-h4">{type ? type : '—'}</div>
          </div>
          <div className="jbls-job-item-alternative__experience">
            <SchoolIcon />
            <div className="jbls-text-size-h4">{experienceLevel ? experienceLevel : '—'}</div></div>
        </div>
      </Link>
    </li>
  )
}

export default JobItemAlternative;

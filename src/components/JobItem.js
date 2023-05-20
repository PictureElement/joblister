import { ReactComponent as LocationIcon } from '../icons/location.svg';
import { Link } from 'react-router-dom';
import DOMPurify from 'dompurify';
import moment from 'moment-timezone';
import slugify from 'react-slugify';

const calculateTimeAgo = (modifiedGmt) => {
  const clientTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
  // Create a moment object representing the time the job was last modified in UTC.
  const modifiedUtc = moment.utc(modifiedGmt);
  // Convert the moment object to the client's timezone.
  const modifiedInClientTimezone = modifiedUtc.tz(clientTimezone);
  // Return the duration between the current time and the modified time in human-readable format (e.g. 2 days ago, 10 minutes ago)
  return modifiedInClientTimezone.fromNow();
};

function JobItem(props) {

  const id = props.id;
  const updatedTimeAgo = calculateTimeAgo(props.modifiedGmt);
  const title = { __html: DOMPurify.sanitize(props.title) };
  const slug = slugify(props.title);
  const location = props.location;
  const category = props.category;
  const experienceLevel = props.experienceLevel;
  
  return (
    <li className="jl-job-item">
      <Link to={`/${id}-${slug}`} className="jl-job-item__link">
        <div className="jl-job-item__table">
          <div className="jl-job-item__row">
            <div className="jl-job-item__job">
              <div className="jl-job-item__title" dangerouslySetInnerHTML={ title }></div>
              <div className="jl-job-item__subtitle">
                Job ID: {id} | Updated {updatedTimeAgo}
              </div>
            </div>
            <div className="jl-job-item__category">{category}</div>
            <div className="jl-job-item__location"><LocationIcon style={{ verticalAlign: 'middle' }} /> <span style={{ verticalAlign: 'middle' }}>{location}</span></div>
            <div className="jl-job-item__type">{experienceLevel}</div>
          </div>
        </div>
      </Link>
    </li>
  )
}

export default JobItem;
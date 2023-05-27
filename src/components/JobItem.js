import { ReactComponent as LocationIcon } from '../icons/location.svg';
import { Link } from 'react-router-dom';
import DOMPurify from 'dompurify';
import slugify from 'react-slugify';
import { calculateTimeAgo } from '../utils';

function JobItem(props) {
  // Props
  const id = props.id;
  const updatedTimeAgo = calculateTimeAgo(props.modifiedGmt);
  const title = { __html: DOMPurify.sanitize(props.title) };
  const slug = slugify(props.title);
  const idDashSlug = `${id}-${slug}`;
  const location = props.location;
  const category = props.category;
  const experienceLevel = props.experienceLevel;

  return (
    <li className="jl-job-item">
      <Link to={`${idDashSlug}`} className="jl-job-item__link">
        <div className="jl-job-item__table">
          <div className="jl-job-item__row">
            <div className="jl-job-item__job">
              <div className="jl-job-item__title jl-text-size-h3" dangerouslySetInnerHTML={ title }></div>
              <div className="jl-job-item__subtitle jl-text-size-small">
                Job ID: {id} | Updated {updatedTimeAgo}
              </div>
            </div>
            <div className="jl-job-item__category"><div className="jl-text-size-h4">{category}</div></div>
            <div className="jl-job-item__location"><div className="jl-text-size-h4">{location}</div></div>
            <div className="jl-job-item__type"><div className="jl-text-size-h4">{experienceLevel}</div></div>
          </div>
        </div>
      </Link>
    </li>
  )
}

export default JobItem;
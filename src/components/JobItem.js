import { ReactComponent as LocationIcon } from '../icons/location.svg';

function JobItem() {
  return (
    <li className="jl-job-item">
      <a className="jl-job-item__link" href="#">
        <div className="jl-job-item__table">
          <div className="jl-job-item__row">
            <div className="jl-job-item__job">
              <div className="jl-job-item__title">Data Center Hardware Specialist</div>
              <div className="jl-job-item__subtitle">
                Job ID: 454233 | Updated on: <span className="jl-job-item__updated">4/21/2023</span>
              </div>
            </div>
            <div className="jl-job-item__category">Hardware Development</div>
            <div className="jl-job-item__location"><LocationIcon style={{ verticalAlign: 'middle' }} /> <span style={{ verticalAlign: 'middle' }}>Remote</span></div>
            <div className="jl-job-item__type">Entry Level</div>
          </div>
        </div>
      </a>
    </li>
  )
}

export default JobItem;
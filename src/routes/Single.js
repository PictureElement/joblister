import { useParams } from 'react-router-dom';

function Single() {
  // Get the id and slug parameters from the URL.
  const { id, slug } = useParams();

  return (
    <div>
      <div>Job ID: {id}</div>
      <div>Slug: {slug}</div>
    </div>
  )
}

export default Single;
import { useParams } from 'react-router-dom';

function Single() {

  // Get the id and slug parameters from the URL.
  const { idDashSlug} = useParams();

  return (
    <div>
      <div>id-slug: {idDashSlug}</div>
    </div>
  )
}

export default Single;
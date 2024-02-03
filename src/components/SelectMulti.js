import Select from 'react-select';

function SelectMulti(props) {
  return (
    <Select
      value={props.value}
      placeholder={props.placeholder}
      isMulti
      onChange={props.handleChange}
      options={props.options}
      getOptionValue={(option) =>`${option['id']}`}
      getOptionLabel={(option) => `${option['name']}`}
      className="jbls-select"
      classNamePrefix="jbls-select"
    />
  )
}

export default SelectMulti;

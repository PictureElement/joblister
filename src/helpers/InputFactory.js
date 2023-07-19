import Input from "../components/Input";

// InputFactory dynamically creates input field components based on input type
// This improves code organization and separation of concerns
function InputFactory(props) {

  const { type, ...remainingProps } = props;

  switch (type) {
    case 'text':
      return <Input type="text" {...remainingProps} />;
    case 'email':
      return <Input type="email" {...remainingProps} />;
    case 'file':
      return <Input type="file" {...remainingProps} />;
    // Add cases for other input types as needed
    default:
      throw new Error(`Invalid input type: ${type}`);
  }
}

export default InputFactory;
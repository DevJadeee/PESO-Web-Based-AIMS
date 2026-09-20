export function FormSection({ title, children }) {
  return (
    <fieldset>
      <legend>{title}</legend>
      {children}
    </fieldset>
  )
}

export function FormField({ label, select, options = [], ...props }) {
  return (
    <label className="field">
      <span>{label}</span>
      {select ? (
        <select {...props}>
          {options.map((option) => (
            <option key={option}>{option}</option>
          ))}
        </select>
      ) : (
        <input {...props} />
      )}
    </label>
  )
}

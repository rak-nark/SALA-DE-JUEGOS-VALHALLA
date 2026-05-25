export const AuthInput = ({
  label,
  icon,
  type = "text",
  name,
  value,
  placeholder,
  onChange,
  rightElement,
  disabled = false,
}) => {
  const inputId = `auth-${name}`;

  return (
    <div className="space-y-2">
      <label
        className="ml-1 block font-label text-xs uppercase tracking-widest text-secondary"
        htmlFor={inputId}
      >
        {label}
      </label>
      <div className="neon-border-focus relative overflow-hidden rounded-lg border border-outline-variant/30 transition-all duration-300">
        {icon && (
          <span className="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">
            {icon}
          </span>
        )}
        <input
          id={inputId}
          className={`w-full rounded-lg border-none bg-surface-container-low py-4 text-on-surface outline-none transition-all placeholder:text-outline-variant/60 focus:ring-0 ${
            icon ? "pl-12" : "pl-4"
          } ${rightElement ? "pr-12" : "pr-4"}`}
          type={type}
          name={name}
          value={value}
          aria-label={label || name}
          placeholder={placeholder}
          onChange={onChange}
          disabled={disabled}
        />
        {rightElement}
      </div>
    </div>
  );
};

const SQL_INJECTION_PATTERN =
  /(\bunion\b|\bdrop\b|\binsert\b|\bdelete\b|\bupdate\b|\bselect\b|--|;|\/\*|\*\/|\bxp_\b)/i;

const CONTROL_CHARS_PATTERN = /[\u0000-\u001F\u007F]/g;

const normalizeText = (value) =>
  String(value ?? "")
    .replace(CONTROL_CHARS_PATTERN, "")
    .trim();

export const sanitizeLoginForm = ({ email, password }) => {
  const normalizedEmail = normalizeText(email).toLowerCase();
  const normalizedPassword = String(password ?? "");

  if (SQL_INJECTION_PATTERN.test(normalizedEmail)) {
    return { error: "El correo contiene caracteres no permitidos." };
  }

  return {
    email: normalizedEmail,
    password: normalizedPassword,
  };
};

export const sanitizeRegisterForm = ({
  firstName,
  lastName,
  email,
  password,
}) => {
  const normalizedFirstName = normalizeText(firstName);
  const normalizedLastName = normalizeText(lastName);
  const normalizedEmail = normalizeText(email).toLowerCase();
  const normalizedPassword = String(password ?? "");

  if (
    SQL_INJECTION_PATTERN.test(normalizedFirstName) ||
    SQL_INJECTION_PATTERN.test(normalizedLastName) ||
    SQL_INJECTION_PATTERN.test(normalizedEmail)
  ) {
    return { error: "Los datos contienen caracteres no permitidos." };
  }

  return {
    firstName: normalizedFirstName,
    lastName: normalizedLastName,
    email: normalizedEmail,
    password: normalizedPassword,
  };
};

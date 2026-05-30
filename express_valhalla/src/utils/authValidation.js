const { body } = require("express-validator");

const namePattern = /^[A-Za-zÀ-ÿÑñ'\-\s]+$/;

const registerValidation = [
  body("nombreCliente")
    .trim()
    .notEmpty()
    .withMessage("El nombre es obligatorio")
    .isLength({ min: 2, max: 60 })
    .withMessage("El nombre debe tener entre 2 y 60 caracteres")
    .matches(namePattern)
    .withMessage("El nombre contiene caracteres no permitidos"),
  body("apellidoCliente")
    .trim()
    .notEmpty()
    .withMessage("El apellido es obligatorio")
    .isLength({ min: 2, max: 60 })
    .withMessage("El apellido debe tener entre 2 y 60 caracteres")
    .matches(namePattern)
    .withMessage("El apellido contiene caracteres no permitidos"),
  body("correoCliente")
    .trim()
    .normalizeEmail()
    .isEmail()
    .withMessage("Correo inválido")
    .isLength({ max: 120 })
    .withMessage("El correo es demasiado largo"),
  body("contrasenaCliente")
    .isLength({ min: 8, max: 128 })
    .withMessage("Mínimo 8 caracteres")
    .custom((value) => !/[\u0000]/.test(value))
    .withMessage("La contraseña contiene caracteres no permitidos"),
];

const loginValidation = [
  body("correoCliente")
    .trim()
    .normalizeEmail()
    .isEmail()
    .withMessage("Correo inválido")
    .isLength({ max: 120 })
    .withMessage("El correo es demasiado largo"),
  body("contrasenaCliente")
    .notEmpty()
    .withMessage("La contraseña es obligatoria")
    .isLength({ max: 128 })
    .withMessage("La contraseña es demasiado larga")
    .custom((value) => !/[\u0000]/.test(value))
    .withMessage("La contraseña contiene caracteres no permitidos"),
];

module.exports = {
  loginValidation,
  registerValidation,
};

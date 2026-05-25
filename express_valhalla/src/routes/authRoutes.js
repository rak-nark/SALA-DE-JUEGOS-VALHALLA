const express = require("express");
const router = express.Router();
const { body } = require("express-validator");
const authController = require("../controllers/authController");

// Validaciones
const registerValidation = [
  body("nombreCliente")
    .notEmpty()
    .withMessage("El nombre es obligatorio")
    .isLength({ min: 2 }),
  body("apellidoCliente")
    .notEmpty()
    .withMessage("El apellido es obligatorio")
    .isLength({ min: 2 }),
  body("correoCliente").isEmail().withMessage("Correo inválido"),
  body("contrasenaCliente")
    .isLength({ min: 8 })
    .withMessage("Mínimo 8 caracteres"),
];
const loginValidation = [
  body("correoCliente").isEmail(),
  body("contrasenaCliente").notEmpty(),
];

router.get("/cliente", authController.index);
router.get("/cliente/:id", authController.show);
router.post("/register", registerValidation, authController.register);
router.post("/login", loginValidation, authController.login);
router.put("/cliente/:id", authController.update);
router.delete("/cliente/:id", authController.destroy);
router.get("/logout", authController.logout);

module.exports = router;

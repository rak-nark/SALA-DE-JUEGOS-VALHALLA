const express = require("express");
const router = express.Router();
const authController = require("../controllers/authController");
const {
  loginValidation,
  registerValidation,
} = require("../utils/authValidation");

router.get("/cliente", authController.index);
router.get("/cliente/:id", authController.show);
router.post("/register", registerValidation, authController.register);
router.post("/login", loginValidation, authController.login);
router.put("/cliente/:id", authController.update);
router.delete("/cliente/:id", authController.destroy);
router.get("/logout", authController.logout);

module.exports = router;

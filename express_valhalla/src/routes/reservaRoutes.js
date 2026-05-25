const express = require("express");
const router = express.Router();
const { misReservas } = require("../controllers/reservaController");

router.get("/mis-reservas", misReservas);

module.exports = router;

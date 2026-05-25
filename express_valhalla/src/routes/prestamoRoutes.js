const express = require("express");
const router = express.Router();
const prestamoController = require("../controllers/prestamoController");

router.get("/reserva", prestamoController.index);
router.get("/reserva/:idPrestamo", prestamoController.show);
router.post("/reserva", prestamoController.store);
router.put("/reserva/:idPrestamo", prestamoController.update);
router.delete("/reserva/:idPrestamo", prestamoController.destroy);

module.exports = router;

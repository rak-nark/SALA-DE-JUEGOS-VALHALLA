const express = require("express");
const router = express.Router();
const Consola = require("../models/Consola");

router.get("/", async (req, res) => {
  const consolas = await Consola.getAll();
  res.json(consolas);
});
router.put("/:id/estado", async (req, res) => {
  const { estado } = req.body;
  await Consola.updateEstado(req.params.id, estado);
  res.json({ message: "Estado actualizado" });
});

module.exports = router;

const Prestamo = require("../models/Prestamo");

// GET /mis-reservas?clienteId=xxx (porque sin auth, recibimos el id por query)
const misReservas = async (req, res) => {
  const clienteId = req.query.clienteId;
  if (!clienteId) {
    return res
      .status(400)
      .json({ error: "Se requiere clienteId", status: 400 });
  }
  try {
    const reservas = await Prestamo.getByCliente(clienteId);
    res.json(reservas);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};

module.exports = { misReservas };

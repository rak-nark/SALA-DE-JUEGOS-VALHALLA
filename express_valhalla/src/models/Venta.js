const db = require("../config/db");

const Venta = {
  getAll: async () => {
    const [rows] = await db.query("SELECT * FROM venta");
    return rows;
  },
  getById: async (id) => {
    const [rows] = await db.query("SELECT * FROM venta WHERE id = ?", [id]);
    return rows[0];
  },
  create: async (data) => {
    const { id, fecha, monto, id_prestamo } = data;
    const [result] = await db.query(
      "INSERT INTO venta (id, fecha, monto, id_prestamo) VALUES (?, ?, ?, ?)",
      [id, fecha, monto, id_prestamo],
    );
    return { id, fecha, monto, id_prestamo };
  },
  update: async (id, data) => {
    const { fecha, monto, id_prestamo } = data;
    await db.query(
      "UPDATE venta SET fecha = ?, monto = ?, id_prestamo = ? WHERE id = ?",
      [fecha, monto, id_prestamo, id],
    );
    return Venta.getById(id);
  },
  delete: async (id) => {
    const [result] = await db.query("DELETE FROM venta WHERE id = ?", [id]);
    return result.affectedRows > 0;
  },
  // Reportes
  obtenerVentasDiarias: async (fecha) => {
    const [rows] = await db.query("SELECT * FROM venta WHERE DATE(fecha) = ?", [
      fecha,
    ]);
    return rows;
  },
  obtenerVentasMensuales: async (mes, anio) => {
    const [rows] = await db.query(
      "SELECT * FROM venta WHERE MONTH(fecha) = ? AND YEAR(fecha) = ?",
      [mes, anio],
    );
    return rows;
  },
  obtenerVentasSemestrales: async (semestre, anio) => {
    const meses = semestre === 1 ? [1, 6] : [7, 12];
    const [rows] = await db.query(
      "SELECT * FROM venta WHERE MONTH(fecha) BETWEEN ? AND ? AND YEAR(fecha) = ?",
      [meses[0], meses[1], anio],
    );
    return rows;
  },
  obtenerVentasAnuales: async (anio) => {
    const [rows] = await db.query("SELECT * FROM venta WHERE YEAR(fecha) = ?", [
      anio,
    ]);
    return rows;
  },
};

module.exports = Venta;

const db = require("../config/db");

const Consola = {
  getAll: async () => {
    const [rows] = await db.query("SELECT * FROM consola");
    return rows;
  },
  getById: async (id) => {
    const [rows] = await db.query("SELECT * FROM consola WHERE id = ?", [id]);
    return rows[0];
  },
  updateEstado: async (id, estado) => {
    const [result] = await db.query(
      "UPDATE consola SET estado = ? WHERE id = ?",
      [estado, id],
    );
    return result.affectedRows > 0;
  },
  searchByTipo: async (busqueda) => {
    const [rows] = await db.query("SELECT * FROM consola WHERE tipo LIKE ?", [
      `%${busqueda}%`,
    ]);
    return rows;
  },
};

module.exports = Consola;

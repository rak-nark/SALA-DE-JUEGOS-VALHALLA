const db = require("../config/db");

const Mantenimiento = {
  getAllPaginated: async (pagina = 1, porPagina = 10) => {
    const offset = (pagina - 1) * porPagina;
    const [rows] = await db.query(
      `SELECT * FROM mantenimiento 
             ORDER BY 
               CASE estado
                 WHEN 'en_proceso' THEN 1
                 WHEN 'pendiente' THEN 2
                 WHEN 'completado' THEN 3
                 ELSE 4
               END,
               fecha_programada ASC
             LIMIT ?, ?`,
      [offset, porPagina],
    );
    return rows;
  },
  count: async () => {
    const [rows] = await db.query(
      "SELECT COUNT(*) as total FROM mantenimiento",
    );
    return rows[0].total;
  },
  getById: async (id) => {
    const [rows] = await db.query("SELECT * FROM mantenimiento WHERE id = ?", [
      id,
    ]);
    return rows[0];
  },
  create: async (data) => {
    const { tipo, descripcion, id_consola, fecha_programada } = data;
    const [result] = await db.query(
      "INSERT INTO mantenimiento (tipo, descripcion, id_consola, fecha_programada) VALUES (?, ?, ?, ?)",
      [tipo, descripcion, id_consola, fecha_programada],
    );
    return { id: result.insertId, ...data };
  },
  update: async (id, data) => {
    const { tipo, descripcion, id_consola, fecha_programada } = data;
    await db.query(
      "UPDATE mantenimiento SET tipo = ?, descripcion = ?, id_consola = ?, fecha_programada = ? WHERE id = ?",
      [tipo, descripcion, id_consola, fecha_programada, id],
    );
    return Mantenimiento.getById(id);
  },
  cambiarEstado: async (id, accion) => {
    let query;
    if (accion === "iniciar") {
      query = `UPDATE mantenimiento SET estado = 'en_proceso', fecha_inicio = NOW() WHERE id = ? AND estado = 'pendiente'`;
    } else if (accion === "completar") {
      query = `UPDATE mantenimiento SET estado = 'completado', fecha_fin = NOW() WHERE id = ? AND estado = 'en_proceso'`;
    } else if (accion === "cancelar") {
      query = `UPDATE mantenimiento SET estado = 'cancelado', fecha_fin = NOW() WHERE id = ? AND estado IN ('pendiente', 'en_proceso')`;
    } else {
      return false;
    }
    const [result] = await db.query(query, [id]);
    return result.affectedRows > 0;
  },
  delete: async (id) => {
    const [result] = await db.query("DELETE FROM mantenimiento WHERE id = ?", [
      id,
    ]);
    return result.affectedRows > 0;
  },
};

module.exports = Mantenimiento;

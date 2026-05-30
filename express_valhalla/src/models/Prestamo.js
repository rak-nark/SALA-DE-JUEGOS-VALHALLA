const db = require("../config/db");
const moment = require("moment");

const Prestamo = {
  // Obtener todos
  getAll: async () => {
    const [rows] = await db.query("SELECT * FROM prestamo");
    return rows;
  },
  // Obtener por ID
  getById: async (id) => {
    const [rows] = await db.query(
      "SELECT * FROM prestamo WHERE idPrestamo = ?",
      [id],
    );
    return rows[0];
  },
  // Obtener reservas de un cliente
  getByCliente: async (idCliente) => {
    const [rows] = await db.query(
      "SELECT * FROM prestamo WHERE id_cliente = ?",
      [idCliente],
    );
    return rows;
  },
  // Estadísticas de reservas de un cliente
  getStatsByCliente: async (idCliente) => {
    const [rows] = await db.query(
      `SELECT
         COUNT(*) AS totalReservations,
         COALESCE(SUM(tiempodeuso), 0) AS totalMinutes
       FROM prestamo
       WHERE id_cliente = ?`,
      [idCliente],
    );

    const result = rows[0] || { totalReservations: 0, totalMinutes: 0 };

    return {
      totalReservations: Number(result.totalReservations) || 0,
      totalMinutes: Number(result.totalMinutes) || 0,
    };
  },
  // Contar reservas de un cliente en una fecha específica
  countByClienteAndFecha: async (idCliente, fecha) => {
    const [rows] = await db.query(
      "SELECT COUNT(*) as count FROM prestamo WHERE id_cliente = ? AND fecha = ?",
      [idCliente, fecha],
    );
    return rows[0].count;
  },
  // Verificar conflicto de horario en una consola
  checkConflicto: async (
    fecha,
    idConsola,
    horaInicio,
    minutosUso,
    excludeId = null,
  ) => {
    const horaFin = moment(horaInicio, "HH:mm")
      .add(minutosUso, "minutes")
      .format("HH:mm:ss");
    let query = `
            SELECT * FROM prestamo 
            WHERE fecha = ? AND id_consola = ? 
            AND ( 
                (hora < ? AND ADDTIME(hora, SEC_TO_TIME(tiempodeuso * 60)) > ?)
            )
        `;
    const params = [fecha, idConsola, horaFin, horaInicio];
    if (excludeId) {
      query += " AND idPrestamo != ?";
      params.push(excludeId);
    }
    const [rows] = await db.query(query, params);
    return rows.length > 0;
  },
  repairAutoIncrement: async () => {
    try {
      const [rows] = await db.query(
        "SELECT COALESCE(MAX(idPrestamo), 0) + 1 AS nextId FROM prestamo",
      );
      const nextId = Number(rows[0].nextId);
      if (Number.isInteger(nextId) && nextId > 0) {
        await db.query(`ALTER TABLE prestamo AUTO_INCREMENT = ${nextId}`);
        console.log(`✅ AUTO_INCREMENT reparado en prestamo → ${nextId}`);
      }
    } catch (error) {
      console.error("Error reparando AUTO_INCREMENT:", error.message);
    }
  },
  // Crear reserva
  create: async (data) => {
    const { fecha, hora, tiempodeuso, reserva, id_cliente, id_consola } = data;
    const [result] = await db.query(
      `INSERT INTO prestamo (fecha, hora, tiempodeuso, reserva, id_cliente, id_consola) 
       VALUES (?, ?, ?, ?, ?, ?)`,
      [fecha, hora, tiempodeuso, reserva, id_cliente, id_consola],
    );
    return {
      idPrestamo: result.insertId, // ← El ID real generado por MySQL
      fecha,
      hora,
      tiempodeuso,
      reserva,
      id_cliente,
      id_consola,
    };
  },
  // Actualizar reserva
  update: async (idPrestamo, data) => {
    const { fecha, hora, tiempodeuso, reserva, id_cliente, id_consola } = data;
    await db.query(
      "UPDATE prestamo SET fecha = ?, hora = ?, tiempodeuso = ?, reserva = ?, id_cliente = ?, id_consola = ? WHERE idPrestamo = ?",
      [fecha, hora, tiempodeuso, reserva, id_cliente, id_consola, idPrestamo],
    );
    return Prestamo.getById(idPrestamo);
  },
  // Eliminar reserva (y venta asociada)
  delete: async (idPrestamo) => {
    const connection = await db.getConnection();
    await connection.beginTransaction();
    try {
      // Eliminar venta relacionada
      await connection.query("DELETE FROM venta WHERE id_prestamo = ?", [
        idPrestamo,
      ]);
      // Eliminar préstamo
      const [result] = await connection.query(
        "DELETE FROM prestamo WHERE idPrestamo = ?",
        [idPrestamo],
      );
      await connection.commit();
      return result.affectedRows > 0;
    } catch (error) {
      await connection.rollback();
      throw error;
    } finally {
      connection.release();
    }
  },
};

module.exports = Prestamo;

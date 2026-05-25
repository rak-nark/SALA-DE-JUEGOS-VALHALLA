const db = require("../config/db");
const bcrypt = require("bcryptjs");

const Cliente = {
    // Obtener todos
    getAll: async () => {
        const [rows] = await db.query(
            "SELECT idCliente, nombreCliente, apellidoCliente, correoCliente, rol FROM cliente",
        );
        return rows;
    },
    // Obtener por ID
    getById: async (id) => {
        const [rows] = await db.query(
            "SELECT idCliente, nombreCliente, apellidoCliente, correoCliente, rol FROM cliente WHERE idCliente = ?",
            [id],
        );
        return rows[0];
    },
    // Obtener por correo (incluye contraseña para login)
    getByEmail: async (email) => {
        const [rows] = await db.query(
            "SELECT * FROM cliente WHERE correoCliente = ?",
            [email],
        );
        return rows[0];
    },
    // Crear cliente
    create: async (data) => {
        const {
            nombreCliente,
            apellidoCliente,
            correoCliente,
            contrasenaCliente,
            rol = "usuario",
        } = data;
        const hashedPassword = await bcrypt.hash(contrasenaCliente, 10);
        const [result] = await db.query(
            "INSERT INTO cliente (nombreCliente, apellidoCliente, correoCliente, contrasenaCliente, rol) VALUES (?, ?, ?, ?, ?)",
            [nombreCliente, apellidoCliente, correoCliente, hashedPassword, rol],
        );
        return {
            idCliente: result.insertId,
            nombreCliente,
            apellidoCliente,
            correoCliente,
            rol,
        };
    },
    // Actualizar cliente (solo campos enviados)
    update: async (id, data) => {
        const fields = [];
        const values = [];
        if (data.nombreCliente) {
            fields.push("nombreCliente = ?");
            values.push(data.nombreCliente);
        }
        if (data.apellidoCliente) {
            fields.push("apellidoCliente = ?");
            values.push(data.apellidoCliente);
        }
        if (data.correoCliente) {
            fields.push("correoCliente = ?");
            values.push(data.correoCliente);
        }
        if (data.contrasenaCliente) {
            const hashed = await bcrypt.hash(data.contrasenaCliente, 10);
            fields.push("contrasenaCliente = ?");
            values.push(hashed);
        }
        if (data.rol) {
            fields.push("rol = ?");
            values.push(data.rol);
        }
        if (fields.length === 0) return null;
        values.push(id);
        await db.query(
            `UPDATE cliente SET ${fields.join(", ")} WHERE idCliente = ?`,
            values,
        );
        return Cliente.getById(id);
    },
    // Eliminar cliente (lógica completa: verificar reservas futuras, eliminar futuras, desvincular pasadas, borrar cliente)
    deleteWithChecks: async (idCliente) => {
        const hoy = new Date().toISOString().slice(0, 10);
        // 1. Verificar si tiene reservas pendientes (fecha >= hoy)
        const [pendientes] = await db.query(
            "SELECT COUNT(*) as count FROM prestamo WHERE id_cliente = ? AND fecha >= ?",
            [idCliente, hoy],
        );
        if (pendientes[0].count > 0) {
            throw new Error(
                "No puedes eliminar tu cuenta porque tienes reservas pendientes.",
            );
        }
        // 2. Eliminar reservas futuras (por si acaso)
        await db.query("DELETE FROM prestamo WHERE id_cliente = ? AND fecha >= ?", [
            idCliente,
            hoy,
        ]);
        // 3. Desvincular reservas pasadas (asignar id_cliente = 50)
        await db.query(
            "UPDATE prestamo SET id_cliente = 50 WHERE id_cliente = ? AND fecha < ?",
            [idCliente, hoy],
        );
        // 4. Eliminar el cliente
        const [result] = await db.query("DELETE FROM cliente WHERE idCliente = ?", [
            idCliente,
        ]);
        return result.affectedRows > 0;
    },
};

module.exports = Cliente;

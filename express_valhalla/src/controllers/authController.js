const Cliente = require("../models/Cliente");
const bcrypt = require("bcryptjs");
const { validationResult } = require("express-validator");

const isBcryptHash = (value) =>
  typeof value === "string" && /^\$2[aby]\$\d{2}\$.{53}$/.test(value);

// Obtener todos los clientes (GET /cliente)
const index = async (req, res) => {
  try {
    const clientes = await Cliente.getAll();
    if (clientes.length === 0) {
      return res
        .status(404)
        .json({ message: "No hay clientes registrados", status: 404 });
    }
    res.json(clientes);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};

// Obtener un cliente por ID (GET /cliente/:id)
const show = async (req, res) => {
  const { id } = req.params;
  try {
    const cliente = await Cliente.getById(id);
    if (!cliente) {
      return res.status(404).json({ message: "Cliente no encontrado" });
    }

    res.json({
      cliente: {
        idCliente: cliente.idCliente,
        nombreCliente: cliente.nombreCliente,
        apellidoCliente: cliente.apellidoCliente,
        correoCliente: cliente.correoCliente,
      },
    });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};

// Registrar nuevo cliente (POST /register)
const register = async (req, res) => {
  const errors = validationResult(req);
  if (!errors.isEmpty()) {
    return res.status(400).json({ errors: errors.array() });
  }
  try {
    const { nombreCliente, apellidoCliente, correoCliente, contrasenaCliente } =
      req.body;
    // Verificar si ya existe
    const existe = await Cliente.getByEmail(correoCliente);
    if (existe) {
      return res.status(400).json({ message: "El correo ya está registrado" });
    }
    const nuevoCliente = await Cliente.create({
      nombreCliente,
      apellidoCliente,
      correoCliente,
      contrasenaCliente,
    });
    // Como no usamos JWT aún, devolvemos el cliente creado y un token simulado
    res.status(201).json({
      data: nuevoCliente,
      access_token: "temp_token_sin_jwt",
      token_type: "Bearer",
    });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};

// Login (POST /login)
const login = async (req, res) => {
  const errors = validationResult(req);
  if (!errors.isEmpty()) {
    return res.status(400).json({
      message: "Error en validación",
      errors: errors.array(),
      status: 400,
    });
  }
  try {
    const { correoCliente, contrasenaCliente } = req.body;
    const cliente = await Cliente.getByEmail(correoCliente);
    if (!cliente) {
      return res
        .status(404)
        .json({ message: "Correo electrónico no encontrado", status: 404 });
    }
    const storedPassword =
      cliente.contrasenaCliente || cliente.contrasena || cliente.password || "";

    if (!storedPassword) {
      return res.status(500).json({
        message: "La cuenta no tiene una contraseña válida configurada.",
        status: 500,
      });
    }

    const passwordValida = isBcryptHash(storedPassword)
      ? await bcrypt.compare(contrasenaCliente, storedPassword)
      : contrasenaCliente === storedPassword;

    if (!passwordValida) {
      return res
        .status(401)
        .json({ message: "Contraseña incorrecta", status: 401 });
    }
    // Enviamos datos del cliente (sin contraseña) y un token simulado
    res.json({
      cliente: {
        idCliente: cliente.idCliente,
        nombreCliente: cliente.nombreCliente,
        apellidoCliente: cliente.apellidoCliente,
        correoCliente: cliente.correoCliente,
      },
      token: "temp_token_sin_jwt",
      status: 200,
    });
  } catch (error) {
    console.error("Login error:", error);
    res.status(500).json({
      message: "Error interno al iniciar sesión",
      error: error.message,
      status: 500,
    });
  }
};

// Actualizar cliente (PUT /cliente/:id)
const update = async (req, res) => {
  const { id } = req.params;
  try {
    const clienteExistente = await Cliente.getById(id);
    if (!clienteExistente) {
      return res.status(404).json({ message: "Cliente no encontrado" });
    }
    const updated = await Cliente.update(id, req.body);
    res.json({ data: updated, message: "Cliente actualizado correctamente" });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};

// Eliminar cliente (DELETE /cliente/:id)
const destroy = async (req, res) => {
  const { id } = req.params;
  try {
    const clienteExistente = await Cliente.getById(id);
    if (!clienteExistente) {
      return res.status(404).json({ message: "Cliente no encontrado" });
    }
    await Cliente.deleteWithChecks(id);
    res.json({
      message:
        "Tu cuenta ha sido eliminada. Tus reservas pasadas se conservarán para fines de historial.",
    });
  } catch (error) {
    if (error.message.includes("No puedes eliminar")) {
      return res.status(409).json({ message: error.message });
    }
    res.status(500).json({ error: error.message });
  }
};

// Logout (sin JWT, solo responde OK)
const logout = (req, res) => {
  res.json({ message: "Logged out successfully" });
};

module.exports = { index, show, register, login, update, destroy, logout };

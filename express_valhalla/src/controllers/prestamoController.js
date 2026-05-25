const Prestamo = require("../models/Prestamo");
const Consola = require("../models/Consola");
const moment = require("moment");

const isValidDateFormat = (value) => /^\d{4}-\d{2}-\d{2}$/.test(value);
const isValidHourFormat = (value) =>
  /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/.test(value);
const toInteger = (value) => Number(value);

const validatePrestamoPayload = (
  payload,
  { requireReserva = true, requireCliente = true, requireConsole = true } = {},
) => {
  const errors = [];
  const { fecha, hora, tiempodeuso, reserva, id_cliente, id_consola } = payload;

  if (!fecha || !isValidDateFormat(fecha)) {
    errors.push({
      msg: "El campo fecha es obligatorio y debe tener formato YYYY-MM-DD.",
    });
  }

  if (!hora || !isValidHourFormat(hora)) {
    errors.push({
      msg: "El campo hora es obligatorio y debe tener formato HH:mm.",
    });
  }

  if (
    tiempodeuso === undefined ||
    tiempodeuso === null ||
    tiempodeuso === "" ||
    !Number.isInteger(toInteger(tiempodeuso)) ||
    toInteger(tiempodeuso) < 30
  ) {
    errors.push({
      msg: "El campo tiempodeuso es obligatorio y debe ser un entero mínimo de 30.",
    });
  }

  if (
    requireReserva &&
    (reserva === undefined || reserva === null || reserva === "")
  ) {
    errors.push({ msg: "El campo reserva es obligatorio." });
  }

  if (
    requireCliente &&
    (id_cliente === undefined ||
      id_cliente === null ||
      id_cliente === "" ||
      !Number.isInteger(toInteger(id_cliente)))
  ) {
    errors.push({
      msg: "El campo id_cliente es obligatorio y debe ser un entero.",
    });
  }

  if (
    requireConsole &&
    (id_consola === undefined ||
      id_consola === null ||
      id_consola === "" ||
      !Number.isInteger(toInteger(id_consola)))
  ) {
    errors.push({
      msg: "El campo id_consola es obligatorio y debe ser un entero.",
    });
  }

  if (errors.length > 0) {
    return errors;
  }

  const fechaReserva = moment(fecha, "YYYY-MM-DD", true);
  const hoy = moment().startOf("day");
  const maxFecha = hoy.clone().add(2, "days");

  if (!fechaReserva.isValid()) {
    errors.push({ msg: "El campo fecha debe ser una fecha válida." });
  } else if (fechaReserva.isBefore(hoy) || fechaReserva.isAfter(maxFecha)) {
    errors.push({
      msg: "Las reservas solo pueden realizarse desde hoy hasta un máximo de dos días después.",
    });
  }

  const horaReserva = moment(hora, "HH:mm", true);
  const inicioHorario = moment("10:00", "HH:mm");
  const finHorario = moment("20:00", "HH:mm");

  if (!horaReserva.isValid()) {
    errors.push({
      msg: "El campo hora debe ser una hora válida en formato HH:mm.",
    });
  } else {
    if (
      horaReserva.isBefore(inicioHorario) ||
      horaReserva.isSameOrAfter(finHorario)
    ) {
      errors.push({
        msg: "Las reservas solo están permitidas entre las 10:00 am y las 8:00 pm.",
      });
    }

    if (horaReserva.minutes() % 30 !== 0) {
      errors.push({
        msg: "Las reservas solo se pueden realizar en intervalos de 30 minutos.",
      });
    }
  }

  return errors;
};

// GET /reserva - obtener todas las reservas
const index = async (req, res) => {
  try {
    const prestamos = await Prestamo.getAll();
    if (prestamos.length === 0) {
      return res
        .status(404)
        .json({ message: "No hay prestamos registrados", status: 200 });
    }
    res.json(prestamos);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};

// GET /reserva/:idPrestamo
const show = async (req, res) => {
  const { idPrestamo } = req.params;
  try {
    const prestamo = await Prestamo.getById(idPrestamo);
    if (!prestamo) {
      return res
        .status(404)
        .json({ message: "Préstamo No Existe", status: 404 });
    }
    res.json({ Prestamo: prestamo, Status: 200 });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};

// POST /reserva
const store = async (req, res) => {
  const errors = validatePrestamoPayload(req.body);
  if (errors.length > 0) {
    return res.status(400).json({
      message: "Error en validación de datos",
      errors,
      status: 400,
    });
  }
  try {
    const { fecha, hora, tiempodeuso, reserva, id_cliente, id_consola } =
      req.body;

    const reservasDelDia = await Prestamo.countByClienteAndFecha(
      id_cliente,
      fecha,
    );
    if (reservasDelDia >= 2) {
      return res.status(422).json({
        message: "Solo puedes realizar un máximo de 2 reservas por día.",
        status: 422,
      });
    }

    const consola = await Consola.getById(id_consola);
    if (!consola || consola.estado !== "disponible") {
      return res.status(422).json({
        message: "La consola seleccionada no está disponible para reservas.",
        status: 422,
      });
    }

    const horaInicio = moment(hora, "HH:mm");
    const conflicto = await Prestamo.checkConflicto(
      fecha,
      id_consola,
      horaInicio.format("HH:mm"),
      tiempodeuso,
    );
    if (conflicto) {
      return res.status(422).json({
        message: "La consola ya está reservada en ese horario.",
        status: 422,
      });
    }

    // IMPORTANTE: NO generar idPrestamo manualmente
    const nuevo = await Prestamo.create({
      fecha,
      hora,
      tiempodeuso,
      reserva,
      id_cliente,
      id_consola,
    });

    res.status(201).json({ prestamo: nuevo, status: 201 });
  } catch (error) {
    console.error("Error en POST /reserva:", error);
    res.status(500).json({ error: error.message });
  }
};

// PUT /reserva/:idPrestamo
const update = async (req, res) => {
  const { idPrestamo } = req.params;
  const errors = validatePrestamoPayload(req.body, {
    requireReserva: false,
    requireCliente: false,
    requireConsole: true,
  });
  if (errors.length > 0) {
    return res.status(400).json({
      message: "Error en validación de datos",
      error: errors,
      status: 400,
    });
  }
  try {
    const prestamoExistente = await Prestamo.getById(idPrestamo);
    if (!prestamoExistente) {
      return res
        .status(404)
        .json({ message: "Préstamo no encontrado", status: 404 });
    }
    const { fecha, hora, tiempodeuso, reserva, id_cliente, id_consola } =
      req.body;

    const consola = await Consola.getById(id_consola);
    if (!consola) {
      return res.status(422).json({
        message: "La consola seleccionada no existe.",
        status: 422,
      });
    }

    const horaInicio = moment(hora, "HH:mm");
    const conflicto = await Prestamo.checkConflicto(
      fecha,
      id_consola,
      horaInicio.format("HH:mm"),
      tiempodeuso,
      idPrestamo,
    );
    if (conflicto) {
      return res.status(422).json({
        message: "La consola ya está reservada en ese horario.",
        status: 422,
      });
    }

    const nextReserva = reserva ?? prestamoExistente.reserva;
    const nextIdCliente = id_cliente ?? prestamoExistente.id_cliente;

    const actualizado = await Prestamo.update(idPrestamo, {
      fecha,
      hora,
      tiempodeuso,
      reserva: nextReserva,
      id_cliente: nextIdCliente,
      id_consola,
    });
    res.json({
      message: "Préstamo modificado correctamente",
      prestamo: actualizado,
      status: 200,
    });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};

// DELETE /reserva/:idPrestamo
const destroy = async (req, res) => {
  const { idPrestamo } = req.params;
  try {
    const prestamo = await Prestamo.getById(idPrestamo);
    if (!prestamo) {
      return res
        .status(404)
        .json({ message: "Prestamo no encontrado", status: 404 });
    }
    const hoy = moment().startOf("day");
    const fechaReserva = moment(prestamo.fecha, "YYYY-MM-DD");
    if (fechaReserva.isBefore(hoy)) {
      return res.status(409).json({
        message:
          "No se puede eliminar esta reserva porque pertenece al historial.",
        status: 409,
      });
    }
    await Prestamo.delete(idPrestamo);
    res.json({ message: "Prestamo eliminado", status: 200 });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};

module.exports = { index, show, store, update, destroy };

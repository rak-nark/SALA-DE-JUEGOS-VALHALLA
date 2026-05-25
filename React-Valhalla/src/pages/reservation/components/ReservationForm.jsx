import { useMemo, useState } from "react";
import { authService } from "../../../services/authService";
import { reservationService } from "../../../services/reservationService";
import {
  buildTimeSlots,
  consoleOptions,
  getDateRange,
  usageTimeOptions,
} from "../reservationData";

export const ReservationForm = ({
  mode = "create",
  reservation = null,
  onSuccess,
  onCancel,
}) => {
  const { today, limitDate } = useMemo(() => getDateRange(), []);
  const timeSlots = useMemo(() => buildTimeSlots(), []);
  const [form, setForm] = useState(() => {
    const currentClienteId = authService.getCurrentClienteId();

    return {
      fecha: reservation?.fecha
        ? String(reservation.fecha).slice(0, 10)
        : today,
      hora: reservation?.hora || "",
      tiempodeuso: Number(reservation?.tiempodeuso) || 60,
      reserva:
        typeof reservation?.reserva === "boolean"
          ? reservation.reserva
          : reservation == null
            ? true
            : Number(reservation?.reserva) === 1,
      id_cliente: Number(reservation?.id_cliente) || currentClienteId || "",
      id_consola: Number(reservation?.id_consola) || consoleOptions[0].id,
    };
  });
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");

  const isEditing = mode === "edit";

  const updateReservationField = (event) => {
    const { name, value } = event.target;
    const parsedValue = name === "id_consola" ? Number(value) : value;

    setError("");
    setSuccess("");
    setForm((currentForm) => ({ ...currentForm, [name]: parsedValue }));
  };

  const selectUsageTime = (duration) => {
    setError("");
    setSuccess("");
    setForm((currentForm) => ({ ...currentForm, tiempodeuso: duration }));
  };

  const submitReservation = async (event) => {
    event.preventDefault();

    const currentClienteId = authService.getCurrentClienteId();
    if (!currentClienteId) {
      setError("Debes iniciar sesión para crear un préstamo.");
      return;
    }

    setLoading(true);
    setError("");
    setSuccess("");

    try {
      const reservationId = reservation?.idPrestamo;
      const payload = {
        fecha: form.fecha,
        hora: form.hora,
        tiempodeuso: Number(form.tiempodeuso),
        reserva: 1,
        id_cliente: Number(currentClienteId),
        id_consola: Number(form.id_consola),
      };

      const response = isEditing
        ? await reservationService.updateReservation(reservationId, payload)
        : await reservationService.createReservation(payload);

      const successMessage = isEditing
        ? "Préstamo actualizado correctamente."
        : response?.message || "Préstamo creado correctamente.";

      setSuccess(successMessage);

      if (isEditing) {
        onSuccess?.(response?.data || response?.reservation || response);
        onCancel?.();
        return;
      }

      setForm((currentForm) => ({
        ...currentForm,
        hora: "",
        tiempodeuso: 60,
      }));
    } catch (createError) {
      setError(
        createError.message ||
          (isEditing
            ? "No se pudo actualizar el préstamo."
            : "No se pudo crear el préstamo."),
      );
    } finally {
      setLoading(false);
    }
  };

  return (
    <section className="glass-panel relative overflow-hidden rounded-xl p-6 md:p-8">
      <div className="absolute -right-24 -top-24 size-48 rounded-full bg-secondary/10 blur-3xl transition-all" />

      <h2 className="mb-8 flex items-center gap-2 font-display text-3xl font-semibold text-secondary">
        <span
          className="material-symbols-outlined"
          style={{ fontVariationSettings: "'FILL' 1" }}
        >
          add_circle
        </span>
        {isEditing ? "Editar préstamo" : "Agregar préstamo"}
      </h2>

      <form className="relative space-y-6" onSubmit={submitReservation}>
        {error && (
          <div className="rounded-lg border border-error/30 bg-error-container/20 px-4 py-3 text-sm text-error">
            {error}
          </div>
        )}

        {success && (
          <div className="rounded-lg border border-secondary/30 bg-secondary/10 px-4 py-3 text-sm text-secondary">
            {success}
          </div>
        )}

        <ReservationSelect
          label="Selecciona consola"
          name="id_consola"
          value={form.id_consola}
          onChange={updateReservationField}
          options={consoleOptions.map((consoleItem) => ({
            value: consoleItem.id,
            label: consoleItem.displayName,
          }))}
        />

        <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
          <ReservationInput
            label="Fecha"
            name="fecha"
            type="date"
            value={form.fecha}
            min={today}
            max={limitDate}
            onChange={updateReservationField}
          />
          <ReservationSelect
            label="Hora inicio"
            name="hora"
            value={form.hora}
            onChange={updateReservationField}
            options={timeSlots}
            placeholder="Selecciona hora"
          />
        </div>

        <div className="space-y-2">
          <span className="block px-1 font-label text-xs uppercase tracking-widest text-on-surface-variant">
            Tiempo de uso
          </span>
          <div className="grid grid-cols-2 gap-2 sm:grid-cols-5">
            {usageTimeOptions.map((time) => {
              const isSelected = form.tiempodeuso === time.value;

              return (
                <button
                  key={time.value}
                  className={`rounded-lg border py-3 font-bold transition-all active:scale-95 ${
                    isSelected
                      ? "border-secondary bg-secondary text-on-secondary"
                      : "border-outline-variant text-on-surface hover:border-secondary hover:text-secondary"
                  }`}
                  type="button"
                  onClick={() => selectUsageTime(time.value)}
                >
                  {time.label}
                </button>
              );
            })}
          </div>
        </div>

        <input
          type="hidden"
          name="id_cliente"
          value={form.id_cliente}
          readOnly
        />
        <input
          type="hidden"
          name="reserva"
          value={String(form.reserva)}
          readOnly
        />

        <button
          className="btn-glow flex w-full items-center justify-center gap-2 rounded-lg bg-linear-to-r from-primary-container to-secondary py-4 text-lg font-black uppercase tracking-normal text-on-secondary transition-all active:scale-95 disabled:cursor-not-allowed disabled:opacity-60"
          disabled={loading}
        >
          <span className="material-symbols-outlined">bolt</span>
          {loading
            ? "Guardando…"
            : isEditing
              ? "Guardar cambios"
              : "Guardar reserva"}
        </button>

        {isEditing && onCancel && (
          <button
            className="mt-3 flex w-full items-center justify-center gap-2 rounded-lg border border-outline-variant/30 px-6 py-4 font-bold text-on-surface-variant transition-all hover:bg-surface-container-low"
            type="button"
            onClick={onCancel}
            disabled={loading}
          >
            Cancelar
          </button>
        )}
      </form>
    </section>
  );
};

const ReservationInput = ({ label, name, type, value, onChange, min, max }) => (
  <div className="space-y-2">
    <label
      className="px-1 font-label text-xs uppercase tracking-widest text-on-surface-variant"
      htmlFor={`reservation-${name}`}
    >
      {label}
    </label>
    <div className="reservation-field rounded-lg border border-outline-variant bg-surface-container-low transition-all">
      <input
        id={`reservation-${name}`}
        className="w-full border-none bg-transparent px-4 py-3 text-on-surface outline-none scheme-dark focus:ring-0"
        type={type}
        name={name}
        value={value}
        min={min}
        max={max}
        onChange={onChange}
      />
    </div>
  </div>
);

const ReservationSelect = ({
  label,
  name,
  value,
  onChange,
  options,
  placeholder,
}) => (
  <div className="space-y-2">
    <label
      className="px-1 font-label text-xs uppercase tracking-widest text-on-surface-variant"
      htmlFor={`reservation-${name}`}
    >
      {label}
    </label>
    <div className="reservation-field relative rounded-lg border border-outline-variant bg-surface-container-low transition-all">
      <select
        id={`reservation-${name}`}
        className="w-full appearance-none border-none bg-transparent px-4 py-3 text-on-surface outline-none scheme-dark focus:ring-0"
        name={name}
        value={value}
        onChange={onChange}
      >
        {placeholder && <option value="">{placeholder}</option>}
        {options.map((option) => (
          <option key={option.value} value={option.value}>
            {option.label}
          </option>
        ))}
      </select>
      <span className="material-symbols-outlined pointer-events-none absolute right-4 top-3 text-on-surface-variant">
        expand_more
      </span>
    </div>
  </div>
);

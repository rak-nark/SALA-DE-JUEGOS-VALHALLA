import {
  formatDate,
  formatHour12,
  getConsoleDisplayName,
  getUsageTimeLabel,
  isUpcomingBooking,
} from "../myBookingsData";

export const BookingRow = ({ booking, showActions, onEdit, onDelete }) => {
  const isUpcoming = isUpcomingBooking(booking);
  const gridColumnsClass = showActions ? "md:grid-cols-5" : "md:grid-cols-4";

  return (
    <article
      className={`glass-card relative overflow-hidden rounded-xl px-6 py-6 transition-all duration-300 hover:bg-surface-container-high md:grid md:items-center md:px-8 ${gridColumnsClass} ${
        isUpcoming
          ? ""
          : "opacity-70 grayscale hover:opacity-100 hover:grayscale-0"
      }`}
    >
      <div className="absolute left-0 top-0 h-full w-1 bg-secondary opacity-0 transition-opacity group-hover:opacity-100" />

      <Cell label="Fecha">
        <span className="material-symbols-outlined text-secondary">
          calendar_today
        </span>
        <span className="font-bold">{formatDate(booking.fecha)}</span>
      </Cell>

      <Cell label="Hora">
        <span className="material-symbols-outlined text-secondary">
          schedule
        </span>
        <span>{formatHour12(booking.hora)}</span>
      </Cell>

      <Cell label="Tiempo">
        <span className="rounded-full bg-surface-container-highest px-3 py-1 font-label text-sm text-on-surface">
          {getUsageTimeLabel(booking.tiempodeuso)}
        </span>
      </Cell>

      <Cell label="Consola">
        <span className="material-symbols-outlined text-secondary">
          sports_esports
        </span>
        <span className="font-bold">
          {getConsoleDisplayName(booking.id_consola)}
        </span>
      </Cell>

      {showActions && (
        <div className="mt-4 flex gap-3 md:mt-0 md:justify-end">
          <button
            className="rounded-lg border border-secondary/30 px-4 py-2 font-bold text-secondary transition-colors hover:bg-secondary hover:text-on-secondary"
            type="button"
            onClick={() => onEdit?.(booking)}
          >
            Editar
          </button>
          <button
            className="rounded-lg border border-error/30 px-4 py-2 font-bold text-error transition-colors hover:bg-error-container hover:text-on-error"
            type="button"
            onClick={() => onDelete?.(booking)}
          >
            Eliminar
          </button>
        </div>
      )}
    </article>
  );
};

const Cell = ({ label, children }) => (
  <div className="mb-4 flex flex-col md:mb-0 md:block">
    <span className="mb-1 font-label text-xs uppercase text-secondary md:hidden">
      {label}
    </span>
    <div className="flex items-center gap-3 text-on-surface">{children}</div>
  </div>
);

import { BookingRow } from "./BookingRow";

export const BookingsList = ({
  bookings,
  showHistory,
  onEditBooking,
  onDeleteBooking,
}) => {
  const gridColumnsClass = showHistory ? "md:grid-cols-4" : "md:grid-cols-5";

  return (
    <section className="min-w-0">
      <div
        className={`hidden rounded-t-xl border-b border-outline-variant/30 bg-surface-container-low px-8 py-4 font-label text-xs uppercase tracking-widest text-secondary ${gridColumnsClass} md:grid`}
      >
        <div>Fecha</div>
        <div>Hora</div>
        <div>Tiempo</div>
        <div>Consola</div>
        {!showHistory && <div className="text-right">Acciones</div>}
      </div>

      <div className="space-y-4">
        {bookings.length > 0 ? (
          bookings.map((booking) => (
            <BookingRow
              key={booking.idPrestamo}
              booking={booking}
              showActions={!showHistory}
              onEdit={onEditBooking}
              onDelete={onDeleteBooking}
            />
          ))
        ) : (
          <div className="glass-card rounded-xl px-8 py-10 text-center text-on-surface-variant">
            No hay reservas para mostrar en esta vista.
          </div>
        )}
      </div>
    </section>
  );
};

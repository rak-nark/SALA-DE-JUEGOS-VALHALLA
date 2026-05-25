import { useEffect, useState } from "react";
import { Footer } from "../../layout/Footer";
import { Header } from "../../layout/Header";
import { BookingsList } from "./components/BookingsList";
import { PointsZone } from "./components/PointsZone";
import { ReservationForm } from "../reservation/components/ReservationForm";
import { authService } from "../../services/authService";
import { reservationService } from "../../services/reservationService";

export const MyBookings = () => {
  const [reservas, setReservas] = useState([]);
  const [reservasFiltradas, setReservasFiltradas] = useState([]);
  const [mostrarHistorialCompleto, setMostrarHistorialCompleto] =
    useState(false);
  const [selectedBooking, setSelectedBooking] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  const ordenarReservas = (reservasAOrdenar) => {
    return [...reservasAOrdenar].sort((a, b) => {
      const fechaA = new Date(a.fecha).getTime();
      const fechaB = new Date(b.fecha).getTime();

      if (fechaA !== fechaB) {
        return fechaA - fechaB;
      }

      return String(a.hora).localeCompare(String(b.hora));
    });
  };

  const getFechaKey = (fecha) => {
    if (!fecha) return "";

    if (fecha instanceof Date) {
      return Number.isNaN(fecha.getTime())
        ? ""
        : fecha.toISOString().split("T")[0];
    }

    return String(fecha).slice(0, 10);
  };

  const filtrarReservasPendientes = (reservasBase) => {
    const hoy = new Date().toISOString().split("T")[0];
    const pendientes = reservasBase.filter((reserva) => {
      const fechaReserva = getFechaKey(reserva.fecha);

      return fechaReserva >= hoy;
    });

    setReservasFiltradas(pendientes);
    setMostrarHistorialCompleto(false);
  };

  const mostrarHistorial = (reservasBase) => {
    setReservasFiltradas(reservasBase);
    setMostrarHistorialCompleto(true);
  };

  const alternarVista = () => {
    if (mostrarHistorialCompleto) {
      filtrarReservasPendientes(reservas);
      return;
    }

    mostrarHistorial(reservas);
  };

  const loadBookings = async () => {
    const currentClienteId = authService.getCurrentClienteId();

    if (!currentClienteId) {
      setError("Debes iniciar sesión para ver tus reservas.");
      setLoading(false);
      return;
    }

    setLoading(true);
    setError("");

    try {
      const reservations =
        await reservationService.getMyReservations(currentClienteId);
      const sortedReservations = ordenarReservas(
        Array.isArray(reservations) ? reservations : [],
      );

      setReservas(sortedReservations);
      filtrarReservasPendientes(sortedReservations);
    } catch (loadError) {
      setError(loadError.message || "No se pudieron cargar tus reservas.");
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    loadBookings();
  }, []);

  const openEditModal = (booking) => {
    setSelectedBooking(booking);
  };

  const closeEditModal = () => {
    setSelectedBooking(null);
  };

  const handleBookingUpdated = async () => {
    await loadBookings();
    setSelectedBooking(null);
  };

  return (
    <>
      <Header />
      <main className="mx-auto min-h-screen max-w-container-max-width px-margin-mobile pb-16 pt-32 md:px-margin-desktop">
        <div className="mb-12 flex flex-col items-start justify-between gap-6 md:flex-row md:items-end">
          <div>
            <h1 className="mb-2 font-display text-4xl font-semibold text-on-background md:text-5xl">
              Mis reservas
            </h1>
            <p className="max-w-xl text-lg leading-7 text-on-surface-variant">
              Gestiona tus próximas sesiones de juego y revisa tu historial de
              actividad.
            </p>
          </div>

          <button
            className="neon-glow-hover group flex items-center gap-2 rounded-xl bg-secondary px-8 py-4 font-bold text-on-secondary transition-all"
            type="button"
            onClick={alternarVista}
          >
            <span className="material-symbols-outlined">pending_actions</span>
            {mostrarHistorialCompleto
              ? "Ver pendientes"
              : "Ver historial completo"}
            <span className="material-symbols-outlined transition-transform group-hover:translate-x-1">
              arrow_forward
            </span>
          </button>
        </div>

        <div className="space-y-8">
          {error ? (
            <div className="glass-card rounded-xl px-8 py-10 text-center text-error">
              {error}
            </div>
          ) : loading ? (
            <div className="glass-card rounded-xl px-8 py-10 text-center text-on-surface-variant">
              Cargando reservas…
            </div>
          ) : (
            <BookingsList
              bookings={reservasFiltradas}
              showHistory={mostrarHistorialCompleto}
              onEditBooking={openEditModal}
            />
          )}
          <PointsZone />
        </div>
      </main>

      {selectedBooking && (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/70 px-4 py-8">
          <div className="relative max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-2xl">
            <button
              className="absolute right-4 top-4 z-10 rounded-full bg-surface-container p-2 text-on-surface transition-colors hover:bg-surface-container-high"
              type="button"
              onClick={closeEditModal}
              aria-label="Cerrar modal"
            >
              <span className="material-symbols-outlined">close</span>
            </button>
            <ReservationForm
              mode="edit"
              reservation={selectedBooking}
              onSuccess={handleBookingUpdated}
              onCancel={closeEditModal}
            />
          </div>
        </div>
      )}

      <Footer />
    </>
  );
};

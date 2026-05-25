const API_BASE_URL =
  import.meta.env.VITE_API_URL || "http://localhost:3000/api";

export const reservationService = {
  async getMyReservations(clienteId) {
    const response = await fetch(
      `${API_BASE_URL}/mis-reservas?clienteId=${encodeURIComponent(clienteId)}`,
    );

    const data = await response.json();

    if (!response.ok) {
      const errorMessage =
        data?.error || data?.message || "No se pudieron cargar las reservas";
      throw new Error(errorMessage);
    }

    return data;
  },

  async createReservation(payload) {
    const response = await fetch(`${API_BASE_URL}/reserva`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(payload),
    });

    const data = await response.json();

    if (!response.ok) {
      const errorMessage =
        data?.message ||
        data?.error ||
        data?.errors?.map((error) => error.msg).join(", ") ||
        "No se pudo crear la reserva";

      throw new Error(errorMessage);
    }

    return data;
  },

  async updateReservation(idPrestamo, payload) {
    const response = await fetch(`${API_BASE_URL}/reserva/${idPrestamo}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(payload),
    });

    const data = await response.json();

    if (!response.ok) {
      const errorMessage =
        data?.message ||
        data?.error ||
        data?.errors?.map((error) => error.msg).join(", ") ||
        "No se pudo actualizar la reserva";

      throw new Error(errorMessage);
    }

    return data;
  },
};

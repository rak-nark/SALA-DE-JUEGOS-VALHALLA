const API_BASE_URL =
  import.meta.env.VITE_API_URL || "http://localhost:3000/api";
const CLIENTE_STORAGE_KEY = "cliente:v1";
const LEGACY_CLIENTE_STORAGE_KEY = "cliente";
const AUTH_CHANGE_EVENT = "auth:changed";

const notifyAuthChange = () => {
  window.dispatchEvent(new Event(AUTH_CHANGE_EVENT));
};

export const authService = {
  async login(correoCliente, contrasenaCliente) {
    try {
      const response = await fetch(`${API_BASE_URL}/login`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ correoCliente, contrasenaCliente }),
      });

      const rawBody = await response.text();
      let data = {};

      try {
        data = rawBody ? JSON.parse(rawBody) : {};
      } catch {
        data = {};
      }

      if (!response.ok) {
        const fallbackText = rawBody?.trim() || "Error en la solicitud";
        const errorMsg =
          data.message ||
          data.error ||
          `Error ${response.status}: ${fallbackText}`;
        throw new Error(errorMsg);
      }

      // Verificar estructura esperada
      if (!data.cliente || !data.token) {
        throw new Error("Respuesta del servidor inválida");
      }

      localStorage.setItem(CLIENTE_STORAGE_KEY, JSON.stringify(data.cliente));
      localStorage.setItem("token", data.token);
      notifyAuthChange();
      return data;
    } catch (error) {
      console.error("Login error:", error);
      throw error;
    }
  },
  async register(userData) {
    try {
      const response = await fetch(`${API_BASE_URL}/register`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          nombreCliente: userData.nombreCliente,
          apellidoCliente: userData.apellidoCliente,
          correoCliente: userData.correoCliente,
          contrasenaCliente: userData.contrasenaCliente,
        }),
      });

      const data = await response.json();

      if (!response.ok) {
        let errorMsg = "Error en el registro";
        if (data?.message) {
          errorMsg = data.message;
        } else if (Array.isArray(data?.errors)) {
          errorMsg = data.errors.map((error) => error.msg).join(", ");
        }
        throw new Error(errorMsg);
      }

      // data contiene { data: { ... }, access_token, token_type }
      // No guardamos automáticamente la sesión; redirigimos al login.
      return data;
    } catch (error) {
      console.error("Register error:", error);
      throw error;
    }
  },

  async getClientById(id) {
    try {
      const response = await fetch(`${API_BASE_URL}/cliente/${id}`);
      const data = await response.json();

      if (!response.ok) {
        throw new Error(
          data?.message || data?.error || "No se pudo obtener el cliente",
        );
      }

      return data.cliente;
    } catch (error) {
      console.error("Get client error:", error);
      throw error;
    }
  },

  async updateClient(id, userData) {
    try {
      const response = await fetch(`${API_BASE_URL}/cliente/${id}`, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(userData),
      });

      const data = await response.json();

      if (!response.ok) {
        const errorMessage =
          data?.message || data?.error || "Error al actualizar el perfil";
        throw new Error(errorMessage);
      }

      const currentCliente = this.getCurrentCliente();
      const updatedCliente = {
        ...(currentCliente || {}),
        ...(data?.data || {}),
        ...userData,
      };
      localStorage.setItem(CLIENTE_STORAGE_KEY, JSON.stringify(updatedCliente));

      return data;
    } catch (error) {
      console.error("Update client error:", error);
      throw error;
    }
  },

  logout() {
    localStorage.removeItem(CLIENTE_STORAGE_KEY);
    localStorage.removeItem(LEGACY_CLIENTE_STORAGE_KEY);
    localStorage.removeItem("token");
    notifyAuthChange();
  },

  getCurrentCliente() {
    const currentCliente = localStorage.getItem(CLIENTE_STORAGE_KEY);
    if (currentCliente) {
      try {
        return JSON.parse(currentCliente);
      } catch {
        return null;
      }
    }

    const legacyCliente = localStorage.getItem(LEGACY_CLIENTE_STORAGE_KEY);
    if (!legacyCliente) {
      return null;
    }

    try {
      const parsedLegacyCliente = JSON.parse(legacyCliente);
      localStorage.setItem(
        CLIENTE_STORAGE_KEY,
        JSON.stringify(parsedLegacyCliente),
      );
      localStorage.removeItem(LEGACY_CLIENTE_STORAGE_KEY);
      return parsedLegacyCliente;
    } catch {
      return null;
    }
  },

  getCurrentClienteId() {
    const cliente = this.getCurrentCliente();
    return cliente?.idCliente ?? null;
  },

  getToken() {
    return localStorage.getItem("token");
  },

  isAuthenticated() {
    return !!this.getToken();
  },
};

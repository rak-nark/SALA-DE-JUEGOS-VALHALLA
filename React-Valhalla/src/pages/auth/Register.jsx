import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { AuthInput } from "./components/AuthInput";
import { AuthShell } from "./components/AuthShell";
import { authService } from "../../services/authService"; // Reutilizamos authService, pero añadiremos register

export const Register = () => {
  const navigate = useNavigate();
  const [showPassword, setShowPassword] = useState(false);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");
  const [form, setForm] = useState({
    firstName: "",
    lastName: "",
    email: "",
    password: "",
  });

  const updateRegisterField = (event) => {
    const { name, value } = event.target;
    setForm((currentForm) => ({ ...currentForm, [name]: value }));
    setError(""); // Limpiar error al escribir
  };

  const submitRegistration = async (event) => {
    event.preventDefault();
    setError("");
    setLoading(true);

    try {
      // Llamar al servicio de registro (lo añadiremos en authService)
      await authService.register({
        nombreCliente: form.firstName,
        apellidoCliente: form.lastName,
        correoCliente: form.email,
        contrasenaCliente: form.password,
      });
      // Registro exitoso, redirigir al login (o directamente loguear)
      navigate("/login");
    } catch (err) {
      setError(err.message || "Error al registrar usuario");
    } finally {
      setLoading(false);
    }
  };

  return (
    <AuthShell>
      <div className="mb-8 text-center">
        <h1 className="mb-2 font-display text-5xl font-semibold tracking-normal text-on-surface">
          Únete a la arena
        </h1>
        <p className="text-on-surface-variant">
          Crea tu perfil de Valhalla y empieza a jugar.
        </p>
      </div>

      {error && (
        <div className="mb-4 rounded-lg bg-error-container/20 p-3 text-center text-error">
          {error}
        </div>
      )}

      <form className="space-y-5" onSubmit={submitRegistration}>
        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <AuthInput
            label="Nombre"
            name="firstName"
            value={form.firstName}
            placeholder="Ej. Alex"
            onChange={updateRegisterField}
            disabled={loading}
          />
          <AuthInput
            label="Apellido"
            name="lastName"
            value={form.lastName}
            placeholder="Ej. Morgan"
            onChange={updateRegisterField}
            disabled={loading}
          />
        </div>

        <AuthInput
          label="Correo electrónico"
          icon="mail"
          type="email"
          name="email"
          value={form.email}
          placeholder="tu@email.com"
          onChange={updateRegisterField}
          disabled={loading}
        />

        <AuthInput
          label="Contraseña"
          icon="lock"
          type={showPassword ? "text" : "password"}
          name="password"
          value={form.password}
          placeholder="••••••••"
          onChange={updateRegisterField}
          disabled={loading}
          rightElement={
            <button
              className="absolute right-4 top-1/2 -translate-y-1/2 text-outline-variant transition-colors hover:text-secondary"
              type="button"
              aria-label={
                showPassword ? "Ocultar contraseña" : "Mostrar contraseña"
              }
              onClick={() => setShowPassword((current) => !current)}
            >
              <span className="material-symbols-outlined">
                {showPassword ? "visibility_off" : "visibility"}
              </span>
            </button>
          }
        />

        <button
          type="submit"
          disabled={loading}
          className="flex w-full items-center justify-center gap-2 rounded-lg bg-linear-to-r from-primary-container to-secondary py-4 text-2xl font-bold text-on-secondary transition-all duration-300 hover:scale-[1.02] hover:shadow-[0_0_20px_-2px_rgba(44,245,44,0.4)] active:scale-95 disabled:opacity-50"
        >
          {loading ? "Registrando…" : "Crear cuenta"}
          {!loading && (
            <span className="material-symbols-outlined">arrow_forward</span>
          )}
        </button>
      </form>

      <div className="pt-8 text-center">
        <p className="text-on-surface-variant">
          ¿Ya tienes cuenta?{" "}
          <Link
            className="font-bold text-secondary transition-all hover:underline"
            to="/login"
          >
            Inicia sesión
          </Link>
        </p>
      </div>

      <div className="mt-8 flex items-center justify-center gap-4 opacity-50">
        <div className="h-px w-12 bg-outline-variant" />
        <p className="font-label text-xs uppercase tracking-[4px] text-outline">
          Power Your Game
        </p>
        <div className="h-px w-12 bg-outline-variant" />
      </div>
    </AuthShell>
  );
};

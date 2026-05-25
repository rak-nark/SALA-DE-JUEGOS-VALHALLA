import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { AuthInput } from "./components/AuthInput";
import { AuthShell } from "./components/AuthShell";
import { authService } from "../../services/authService";

export const Login = () => {
  const navigate = useNavigate();
  const [showPassword, setShowPassword] = useState(false);
  const [form, setForm] = useState({
    email: "",
    password: "",
  });
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);

  const updateLoginField = (event) => {
    const { name, value } = event.target;
    setForm((currentForm) => ({ ...currentForm, [name]: value }));
    setError(""); // Limpiar error al escribir
  };

  const submitLogin = async (event) => {
    event.preventDefault();
    setError("");
    setLoading(true);

    try {
      // Llamada al servicio de autenticación
      // El servicio ya mapea email -> correoCliente y password -> contrasenaCliente
      const data = await authService.login(form.email, form.password);
      console.log("Login exitoso:", data);
      // Redirigir al dashboard o página principal
      navigate("/");
    } catch (err) {
      setError(err.message || "Credenciales incorrectas");
    } finally {
      setLoading(false);
    }
  };

  return (
    <AuthShell>
      <div className="mb-8 text-center">
        <h1 className="mb-2 font-display text-5xl font-semibold tracking-normal text-on-surface">
          Bienvenido
        </h1>
        <p className="text-on-surface-variant">
          Inicia sesión para continuar tu aventura.
        </p>
      </div>

      {error && (
        <div className="mb-4 rounded-lg bg-error-container/20 p-3 text-center text-error">
          {error}
        </div>
      )}

      <form className="space-y-6" onSubmit={submitLogin}>
        <AuthInput
          label="Correo electrónico"
          icon="mail"
          type="email"
          name="email"
          value={form.email}
          placeholder="usuario@valhalla.com"
          onChange={updateLoginField}
          disabled={loading}
        />

        <AuthInput
          label="Contraseña"
          icon="lock"
          type={showPassword ? "text" : "password"}
          name="password"
          value={form.password}
          placeholder="••••••••"
          onChange={updateLoginField}
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
          className="flex w-full items-center justify-center gap-2 rounded-lg bg-linear-to-r from-primary-container to-secondary py-4 font-bold uppercase tracking-widest text-on-primary-fixed shadow-lg transition-all duration-300 hover:scale-[1.02] active:scale-95 disabled:opacity-50"
          disabled={loading}
        >
          {loading ? "Iniciando…" : "Iniciar sesión"}
          {!loading && (
            <span className="material-symbols-outlined">arrow_forward</span>
          )}
        </button>
      </form>

      <div className="mt-10 border-t border-outline-variant/20 pt-8 text-center">
        <p className="text-on-surface-variant">
          ¿Aún no tienes cuenta?{" "}
          <Link
            className="font-bold text-secondary transition-all hover:underline"
            to="/register"
          >
            Regístrate gratis
          </Link>
        </p>
      </div>
    </AuthShell>
  );
};

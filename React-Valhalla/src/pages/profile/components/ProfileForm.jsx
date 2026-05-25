import { useEffect, useReducer } from "react";
import { authService } from "../../../services/authService";

const initialForm = {
  nombreCliente: "",
  apellidoCliente: "",
  correoCliente: "",
};

const initialState = {
  form: initialForm,
  loading: true,
  saving: false,
  error: "",
  success: "",
};

const profileFormReducer = (state, action) => {
  switch (action.type) {
    case "LOAD_PROFILE":
      return {
        ...state,
        loading: false,
        form: action.payload,
      };
    case "SET_LOADING":
      return {
        ...state,
        loading: action.payload,
      };
    case "SET_FIELD":
      return {
        ...state,
        error: "",
        success: "",
        form: {
          ...state.form,
          [action.payload.name]: action.payload.value,
        },
      };
    case "START_SAVING":
      return {
        ...state,
        saving: true,
        error: "",
        success: "",
      };
    case "SET_ERROR":
      return {
        ...state,
        error: action.payload,
      };
    case "SET_SUCCESS":
      return {
        ...state,
        success: action.payload,
      };
    case "END_SAVING":
      return {
        ...state,
        saving: false,
      };
    default:
      return state;
  }
};

export const ProfileForm = ({ profile, onProfileUpdated }) => {
  const [state, dispatch] = useReducer(profileFormReducer, initialState);
  const { form, loading, saving, error, success } = state;

  useEffect(() => {
    if (!profile) {
      dispatch({ type: "SET_LOADING", payload: false });
      return;
    }

    dispatch({
      type: "LOAD_PROFILE",
      payload: {
        nombreCliente: profile.nombreCliente || "",
        apellidoCliente: profile.apellidoCliente || "",
        correoCliente: profile.correoCliente || "",
      },
    });
  }, [profile]);

  const updateProfileField = (event) => {
    const { name, value } = event.target;
    dispatch({ type: "SET_FIELD", payload: { name, value } });
  };

  const saveProfileChanges = async (event) => {
    event.preventDefault();

    const currentCliente = authService.getCurrentCliente();
    if (!currentCliente?.idCliente) {
      dispatch({
        type: "SET_ERROR",
        payload: "No se pudo identificar el usuario autenticado.",
      });
      return;
    }

    dispatch({ type: "START_SAVING" });

    try {
      await authService.updateClient(currentCliente.idCliente, {
        nombreCliente: form.nombreCliente,
        apellidoCliente: form.apellidoCliente,
        correoCliente: form.correoCliente,
      });

      onProfileUpdated?.({
        ...currentCliente,
        ...form,
      });
      dispatch({
        type: "SET_SUCCESS",
        payload: "Datos actualizados correctamente.",
      });
    } catch (saveError) {
      dispatch({
        type: "SET_ERROR",
        payload: saveError.message || "Error al actualizar los datos.",
      });
    } finally {
      dispatch({ type: "END_SAVING" });
    }
  };

  return (
    <section className="glass-card rounded-xl p-6 transition-all duration-300 focus-within:shadow-[0_0_20px_-5px_rgba(44,245,44,0.1)] md:col-span-8 md:p-8">
      <div className="mb-8 flex items-center gap-3">
        <span className="material-symbols-outlined text-secondary">person</span>
        <h2 className="font-display text-3xl font-semibold">
          Información personal
        </h2>
      </div>

      <form className="space-y-6" onSubmit={saveProfileChanges}>
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

        {loading && (
          <div className="rounded-lg border border-outline-variant/30 bg-surface-container-low px-4 py-3 text-sm text-on-surface-variant">
            Cargando perfil…
          </div>
        )}

        <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
          <ProfileInput
            label="Nombre"
            name="nombreCliente"
            value={form.nombreCliente}
            onChange={updateProfileField}
            disabled={loading || saving}
          />
          <ProfileInput
            label="Apellido"
            name="apellidoCliente"
            value={form.apellidoCliente}
            onChange={updateProfileField}
            disabled={loading || saving}
          />
        </div>

        <ProfileInput
          label="Correo electrónico"
          name="correoCliente"
          type="email"
          value={form.correoCliente}
          onChange={updateProfileField}
          disabled={loading || saving}
        />

        <div className="flex flex-col items-center justify-between gap-4 pt-6 md:flex-row">
          <button
            className="xbox-gradient neon-glow-hover w-full rounded-lg px-12 py-4 text-lg font-bold text-on-secondary transition-all duration-300 md:w-auto"
            type="submit"
            disabled={loading || saving}
          >
            {saving ? "Guardando…" : "Guardar cambios"}
          </button>
          <button
            className="flex w-full items-center justify-center gap-2 rounded-lg border border-error/30 bg-error-container/20 px-6 py-4 font-bold text-error transition-all duration-300 hover:bg-error-container hover:text-on-error md:w-auto"
            type="button"
            disabled={loading || saving}
          >
            <span className="material-symbols-outlined text-sm">
              delete_forever
            </span>
            Eliminar cuenta
          </button>
        </div>
      </form>
    </section>
  );
};

const ProfileInput = ({
  label,
  name,
  type = "text",
  value,
  onChange,
  disabled = false,
}) => (
  <div className="space-y-2">
    <label
      className="block font-label text-xs text-on-surface-variant"
      htmlFor={`profile-${name}`}
    >
      {label}
    </label>
    <input
      id={`profile-${name}`}
      className="w-full rounded-lg border border-outline-variant/30 bg-surface-container px-4 py-3 text-on-surface outline-none transition-all focus:border-secondary focus:ring-1 focus:ring-secondary"
      type={type}
      name={name}
      value={value}
      onChange={onChange}
      disabled={disabled}
    />
  </div>
);

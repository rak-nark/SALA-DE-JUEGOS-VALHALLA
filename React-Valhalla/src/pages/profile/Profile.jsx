import { useEffect, useState } from "react";

import { Footer } from "../../layout/Footer";
import { Header } from "../../layout/Header";
import { authService } from "../../services/authService";
import { ProfileForm } from "./components/ProfileForm";
import { ProfileHero } from "./components/ProfileHero";
import { ProfileStats } from "./components/ProfileStats";
import { profileData } from "./profileData";

const buildProfileState = (currentCliente = null) => ({
  ...profileData,
  username:
    [currentCliente?.nombreCliente, currentCliente?.apellidoCliente]
      .filter(Boolean)
      .join(" ")
      .trim() ||
    currentCliente?.correoCliente ||
    profileData.username,
  form: {
    nombreCliente:
      currentCliente?.nombreCliente ?? profileData.form?.firstName ?? "",
    apellidoCliente:
      currentCliente?.apellidoCliente ?? profileData.form?.lastName ?? "",
    correoCliente:
      currentCliente?.correoCliente ?? profileData.form?.email ?? "",
  },
});

export const Profile = () => {
  const [profile, setProfile] = useState(() =>
    buildProfileState(authService.getCurrentCliente()),
  );
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");

  useEffect(() => {
    const loadProfile = async () => {
      const currentCliente = authService.getCurrentCliente();

      if (!currentCliente?.idCliente) {
        setError("No se encontró una sesión válida.");
        return;
      }

      try {
        const latestClient = await authService.getClientById(
          currentCliente.idCliente,
        );
        setProfile(buildProfileState(latestClient ?? currentCliente));
      } catch (loadError) {
        setError(loadError.message || "No se pudo cargar tu perfil.");
      } finally {
        setLoading(false);
      }
    };

    loadProfile();
  }, []);

  const handleProfileUpdated = (updatedClient) => {
    setProfile(buildProfileState(updatedClient));
  };

  return (
    <>
      <Header />
      <main className="mx-auto min-h-screen max-w-container-max-width px-margin-mobile pb-24 pt-32 md:px-margin-desktop">
        {error && (
          <div className="mb-8 rounded-xl border border-error/30 bg-error-container/20 px-6 py-4 text-error">
            {error}
          </div>
        )}

        {loading ? (
          <div className="mb-8 rounded-xl border border-outline-variant/30 bg-surface-container-low px-6 py-4 text-on-surface-variant">
            Cargando perfil…
          </div>
        ) : (
          <ProfileHero profile={profile} />
        )}

        <div className="grid grid-cols-1 gap-gutter md:grid-cols-12">
          <ProfileForm
            profile={profile.form}
            onProfileUpdated={handleProfileUpdated}
          />
          <ProfileStats stats={profile.stats} />
        </div>
      </main>
      <Footer />
    </>
  );
};

import { useEffect, useState } from "react";

import { Footer } from "../../layout/Footer";
import { Header } from "../../layout/Header";
import { authService } from "../../services/authService";
import { ProfileForm } from "./components/ProfileForm";
import { ProfileHero } from "./components/ProfileHero";
import { ProfileStats } from "./components/ProfileStats";
import { profileData } from "./profileData";

const buildProfileState = (
  currentCliente = null,
  stats = profileData.stats,
) => ({
  ...profileData,
  username:
    [currentCliente?.nombreCliente, currentCliente?.apellidoCliente]
      .filter(Boolean)
      .join(" ")
      .trim() ||
    currentCliente?.correoCliente ||
    profileData.username,
  profileIcon:
    currentCliente?.profileIcon ||
    authService.getProfileIcon(currentCliente?.idCliente) ||
    profileData.profileIcon ||
    "",
  form: {
    nombreCliente:
      currentCliente?.nombreCliente ?? profileData.form?.firstName ?? "",
    apellidoCliente:
      currentCliente?.apellidoCliente ?? profileData.form?.lastName ?? "",
    correoCliente:
      currentCliente?.correoCliente ?? profileData.form?.email ?? "",
  },
  stats: stats || profileData.stats,
});

export const Profile = () => {
  const [profile, setProfile] = useState(() =>
    buildProfileState(authService.getCurrentCliente()),
  );
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");

  const buildProfileStats = (stats = null) => ({
    totalReservations: Number(stats?.totalReservations) || 0,
    playedHours:
      stats?.playedHours ||
      `${Math.floor((Number(stats?.totalMinutes) || 0) / 60)}h`,
  });

  useEffect(() => {
    const loadProfile = async () => {
      const currentCliente = authService.getCurrentCliente();

      if (!currentCliente?.idCliente) {
        setError("No se encontró una sesión válida.");
        return;
      }

      try {
        const [latestClient, latestStats] = await Promise.all([
          authService.getClientById(currentCliente.idCliente),
          authService.getClientStatsById(currentCliente.idCliente),
        ]);
        setProfile(
          buildProfileState(
            {
              ...currentCliente,
              ...latestClient,
              profileIcon:
                authService.getProfileIcon(currentCliente.idCliente) ||
                currentCliente.profileIcon ||
                latestClient?.profileIcon ||
                "",
            },
            buildProfileStats(latestStats),
          ),
        );
      } catch (loadError) {
        setError(loadError.message || "No se pudo cargar tu perfil.");
      } finally {
        setLoading(false);
      }
    };

    loadProfile();
  }, []);

  const handleProfileUpdated = (updatedClient) => {
    setProfile((currentProfile) =>
      buildProfileState(updatedClient, currentProfile.stats),
    );
  };

  const handleProfileIconChange = (profileIcon) => {
    const currentCliente = authService.getCurrentCliente();

    if (!currentCliente?.idCliente) {
      return;
    }

    authService.setProfileIcon(profileIcon);
    setProfile((currentProfile) => ({
      ...currentProfile,
      profileIcon,
    }));
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
          <ProfileHero
            profile={profile}
            onProfileIconChange={handleProfileIconChange}
          />
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

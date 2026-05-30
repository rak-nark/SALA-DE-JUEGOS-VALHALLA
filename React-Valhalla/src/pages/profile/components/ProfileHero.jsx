import { ProfileIcon } from "./ProfileIcon";

export const ProfileHero = ({ profile, onProfileIconChange }) => {
  return (
    <header className="mb-12 flex flex-col items-center gap-8 md:flex-row">
      <ProfileIcon
        username={profile.username}
        value={profile.profileIcon}
        onChange={onProfileIconChange}
      />

      <div className="text-center md:text-left">
        <h1 className="mb-2 font-display text-4xl font-semibold text-on-surface md:text-5xl">
          {profile.username}
        </h1>
        <p className="flex items-center justify-center gap-2 text-lg text-secondary md:justify-start">
          <span className="material-symbols-outlined text-base">verified</span>
          {profile.membership}
        </p>
      </div>
    </header>
  );
};

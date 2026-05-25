export const ProfileHero = ({ profile }) => {
  return (
    <header className="mb-12 flex flex-col items-center gap-8 md:flex-row">
      <div className="group relative">
        <div className="size-32 overflow-hidden rounded-full border-4 border-secondary/50 bg-surface-container p-1 shadow-[0_0_20px_rgba(118,255,100,0.2)] md:size-40">
          <img
            alt={`Avatar de ${profile.username}`}
            className="h-full w-full rounded-full object-cover grayscale transition-all duration-500 hover:grayscale-0"
            src={profile.avatar}
          />
        </div>
        <button
          className="absolute bottom-2 right-2 rounded-full bg-secondary p-2 text-on-secondary shadow-lg transition-transform hover:scale-110 active:scale-95"
          type="button"
          aria-label="Editar avatar"
        >
          <span
            className="material-symbols-outlined"
            style={{ fontVariationSettings: "'FILL' 1" }}
          >
            edit
          </span>
        </button>
      </div>

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
  )
}

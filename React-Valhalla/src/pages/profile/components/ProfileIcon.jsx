import { useMemo, useState } from "react";

const profileIcons = [
  { id: "icon-1", src: "../../../../public/Profiles/Icon_Profile_1.webp", alt: "Icono de perfil 1" },
  { id: "icon-2", src: "../../../../public/Profiles/Icon_Profile_2.webp", alt: "Icono de perfil 2" },
  { id: "icon-3", src: "../../../../public/Profiles/Icon_Profile_3.webp", alt: "Icono de perfil 3" },
  { id: "icon-4", src: "../../../../public/Profiles/Icon_Profile_4.webp", alt: "Icono de perfil 4" },
  { id: "icon-5", src: "../../../../public/Profiles/Icon_Profile_5.webp", alt: "Icono de perfil 5" },
];

export const ProfileIcon = ({ username, value, onChange }) => {
  const [isOpen, setIsOpen] = useState(false);

  const selectedIcon = useMemo(
    () => profileIcons.find((icon) => icon.src === value) || null,
    [value],
  );

  const applyIcon = (nextValue) => {
    onChange?.(nextValue);
    setIsOpen(false);
  };

  return (
    <>
      <div className="group relative">
        <div className="size-32 overflow-hidden rounded-full border-4 border-secondary/50 bg-surface-container p-1 shadow-[0_0_20px_rgba(118,255,100,0.2)] md:size-40">
          {selectedIcon ? (
            <img
              alt={`Avatar de ${username}`}
              className="h-full w-full rounded-full object-cover"
              src={selectedIcon.src}
            />
          ) : (
            <div className="flex h-full w-full items-center justify-center rounded-full bg-secondary/5 text-secondary">
              <span
                className="material-symbols-outlined text-6xl md:text-17x1"
                style={{ fontVariationSettings: "'FILL' 1" }}
              >
                person
              </span>
            </div>
          )}
        </div>

        <button
          className="absolute bottom-2 right-2 rounded-full bg-secondary p-2 text-on-secondary shadow-lg transition-transform hover:scale-110 active:scale-95"
          type="button"
          aria-label="Editar avatar"
          onClick={() => setIsOpen(true)}
        >
          <span
            className="material-symbols-outlined"
            style={{ fontVariationSettings: "'FILL' 1" }}
          >
            edit
          </span>
        </button>
      </div>

      {isOpen && (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/70 px-4 py-8">
          <div className="w-full max-w-3xl rounded-2xl border border-outline-variant/20 bg-background p-6 shadow-2xl md:p-8">
            <div className="mb-6 flex items-start justify-between gap-4">
              <div>
                <h3 className="font-display text-3xl font-semibold text-on-surface">
                  Elige tu icono
                </h3>
                <p className="mt-1 text-sm text-on-surface-variant">
                  Selecciona una de las opciones circulares para tu perfil.
                </p>
              </div>

              <button
                className="rounded-full border border-outline-variant/30 p-2 text-on-surface transition-colors hover:bg-surface-container-high"
                type="button"
                aria-label="Cerrar selector de avatar"
                onClick={() => setIsOpen(false)}
              >
                <span className="material-symbols-outlined">close</span>
              </button>
            </div>

            <div className="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
              {profileIcons.map((icon) => {
                const isSelected = value === icon.src;

                return (
                  <button
                    key={icon.id}
                    className={`group flex flex-col items-center gap-3 rounded-2xl border p-4 transition-all hover:-translate-y-1 hover:border-secondary/70 hover:bg-surface-container-high ${
                      isSelected
                        ? "border-secondary bg-secondary/10"
                        : "border-outline-variant/20 bg-surface-container-low"
                    }`}
                    type="button"
                    onClick={() => applyIcon(icon.src)}
                  >
                    <div className="size-24 overflow-hidden rounded-full border-2 border-secondary/30 bg-surface-container shadow-[0_0_12px_rgba(118,255,100,0.12)]">
                      <img
                        alt={icon.alt}
                        className="h-full w-full rounded-full object-cover"
                        src={icon.src}
                      />
                    </div>
                    <span className="text-sm font-medium text-on-surface-variant group-hover:text-on-surface">
                      {icon.alt}
                    </span>
                  </button>
                );
              })}
            </div>

            <div className="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-between">
              <button
                className="rounded-xl border border-outline-variant/30 px-5 py-3 font-bold text-on-surface transition-all hover:bg-surface-container-high"
                type="button"
                onClick={() => applyIcon("")}
              >
                Usar icono predeterminado
              </button>

              <button
                className="rounded-xl bg-secondary px-5 py-3 font-bold text-on-secondary transition-all hover:scale-[1.02] active:scale-95"
                type="button"
                onClick={() => setIsOpen(false)}
              >
                Cerrar
              </button>
            </div>
          </div>
        </div>
      )}
    </>
  );
};
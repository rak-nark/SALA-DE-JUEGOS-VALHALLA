import { benefits } from "../homeData";

const benefitsImage =
  "https://lh3.googleusercontent.com/aida-public/AB6AXuBJ4H2T2cyrbwVHwZ2QIwNqqG23xouAshHtqJIrFbzeB0deJ1yFGhnOk1Kp46ci5aDXroePu1xQVIHZUosPZodP-q8r8YzIo0dIbZ4cwO6M7aSt6lmyKkV_neE7KWqQPgNRRuVYFrZAJaEGcb7Dx19WUq2pNfifBVNXI8CSV6gNJ9DtraVao311V6wmsZ280MRVC_eYedCA9Me-QfoQ4vIz4e0aIaR-GQM9e0y5rEX8RoKOyq5ZJiwLvVHqLDrCm0I47ZJZr7a7PpbT";

export const BenefitsSection = () => {
  return (
    <section className="mx-auto max-w-container-max-width px-margin-mobile py-24 md:px-margin-desktop">
      <div className="grid grid-cols-1 items-center gap-16 lg:grid-cols-2">
        <div className="relative">
          <img
            className="relative z-10 rounded-3xl border border-white/5 shadow-2xl"
            src={benefitsImage}
            alt="Persona jugando con un control moderno en una sala gamer iluminada en verde."
          />

          <div className="glass-panel absolute -bottom-6 right-2 z-20 rounded-2xl border-secondary/20 p-5 md:-right-6 md:p-6 neon-glow">
            <div className="flex items-center gap-4">
              <div className="flex size-12 items-center justify-center rounded-full bg-secondary/20">
                <span className="material-symbols-outlined text-secondary">
                  flash_on
                </span>
              </div>
              <div>
                <p className="font-bold text-white">Acceso instantáneo</p>
                <p className="text-sm text-on-surface-variant">
                  Sin tiempos de espera
                </p>
              </div>
            </div>
          </div>
        </div>

        <div>
          <h2 className="mb-8 font-display text-4xl font-semibold md:text-5xl">
            ¿Por qué reservar en sala de juegos Valhalla?
          </h2>

          <div className="space-y-8">
            {benefits.map((benefit) => (
              <article key={benefit.title} className="group flex gap-6">
                <div className="flex size-14 shrink-0 items-center justify-center rounded-xl border border-outline-variant bg-surface-container-high transition-colors group-hover:border-secondary">
                  <span className="material-symbols-outlined text-3xl text-secondary">
                    {benefit.icon}
                  </span>
                </div>
                <div>
                  <h4 className="mb-2 text-xl font-semibold">
                    {benefit.title}
                  </h4>
                  <p className="text-on-surface-variant">
                    {benefit.description}
                  </p>
                </div>
              </article>
            ))}
          </div>

          <button
            className="mt-12 rounded-xl bg-primary-container px-10 py-4 font-bold text-white transition-all hover:scale-105 active:scale-95 neon-glow"
            type="button"
          >
            Empieza tu aventura hoy
          </button>
        </div>
      </div>
    </section>
  );
};

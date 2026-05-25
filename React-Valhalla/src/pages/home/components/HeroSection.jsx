const heroImage =
  "https://lh3.googleusercontent.com/aida-public/AB6AXuCRLuT5N9nAPvaXA8XwcxrV_GGxNHIKLHqdbId2da-j-BQzf2yEhPj82WfVc1xPYukdlVuWXWNzcPjvnJyD8ZCPb9xrFWZmar_EEOAATq_Zxp8VqEZ9ACPTh6ivOdlA8UkycapuBZJs9mySn3azTH_PnqpQE9AZKR8u6j3TSBdJ5cbstjsjLRSno-v--Y17kFmer8w6lIchb52s9-ZbTHVn239BOp1rGkv25pN_F5wVg8w2cgz4z7_ts8dPEZekyggbfrZcg6imNVvL";

export const HeroSection = () => {
  return (
    <section id="home" className="relative h-217.5 w-full overflow-hidden">
      <div className="absolute inset-0 z-0">
        <img
          className="h-full w-full object-cover opacity-60"
          src={heroImage}
          alt="Sala gamer de alta gama con luces verdes, monitor y silla profesional."
        />
        <div className="hero-gradient absolute inset-0" />
      </div>

      <div className="relative z-10 flex h-full flex-col items-center justify-center px-margin-mobile text-center md:px-margin-desktop">
        <span className="mb-4 rounded-full border border-secondary/30 bg-secondary/10 px-4 py-1 font-label text-xs uppercase tracking-widest text-secondary">
          Estrenos exclusivos
        </span>

        <h1 className="mb-6 max-w-4xl font-display text-[40px] font-semibold leading-tight md:text-7xl md:leading-[1.1]">
          ¡Bienvenidos a <span className="text-secondary">Valhalla</span>!
        </h1>

        <p className="mb-10 max-w-2xl text-lg leading-7 text-on-surface-variant">
          Tu destino definitivo para videojuegos y entretenimiento. Vive la
          potencia de la nueva generación con el mejor catálogo de títulos.
        </p>

        <div className="flex flex-col gap-4 sm:flex-row">
          <button
            className="group flex items-center justify-center gap-2 rounded-xl bg-primary-container px-8 py-4 text-lg font-bold text-white transition-transform hover:scale-105 active:scale-95 neon-glow"
            type="button"
          >
            Reserva tu consola ahora
            <span className="material-symbols-outlined transition-transform group-hover:translate-x-1">
              arrow_forward
            </span>
          </button>
          <button
            className="rounded-xl border border-secondary px-8 py-4 text-lg font-bold text-secondary transition-colors hover:bg-secondary/10 active:scale-95"
            type="button"
          >
            Explorar más
          </button>
        </div>
      </div>
    </section>
  );
};

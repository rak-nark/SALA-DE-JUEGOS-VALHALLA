import { useNavigate } from "react-router-dom";
import { authService } from "../../../services/authService";
import { consoles } from "../homeData";

export const ConsoleSection = () => {
  const navigate = useNavigate();

  const handleReserveClick = () => {
    navigate(authService.isAuthenticated() ? "/reservation" : "/login");
  };

  return (
    <section className="mx-auto max-w-container-max-width px-margin-mobile py-24 md:px-margin-desktop">
      <div className="mb-12 flex items-end justify-between">
        <div>
          <h2 className="mb-2 font-display text-4xl font-semibold md:text-5xl">
            Nuestras consolas
          </h2>
          <p className="text-on-surface-variant">
            Hardware de última generación listo para ti.
          </p>
        </div>
        <div className="mx-12 hidden h-0.5 grow bg-linear-to-r from-secondary/50 to-transparent md:block" />
      </div>

      <div className="grid grid-cols-1 gap-gutter sm:grid-cols-2 xl:grid-cols-4">
        {consoles.map((consoleItem) => (
          <article
            key={consoleItem.name}
            className="group relative overflow-hidden rounded-2xl border border-outline-variant/30 bg-surface-container-low transition-all duration-300 hover:border-secondary/50 neon-border-hover"
          >
            <div className="h-56 overflow-hidden">
              <img
                className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                src={consoleItem.image}
                alt={consoleItem.alt}
              />
            </div>

            <div className="p-5">
              <div className="mb-4 flex items-start justify-between gap-3">
                <h3 className="font-display text-2xl font-semibold">
                  {consoleItem.name}
                </h3>
              </div>
              <p className="mb-6 text-on-surface-variant">
                {consoleItem.description}
              </p>
              <button
                className="w-full rounded-lg border border-outline-variant py-3 font-bold transition-all group-hover:bg-secondary group-hover:text-black active:scale-95"
                type="button"
                onClick={handleReserveClick}
              >
                Reservar ahora
              </button>
            </div>
          </article>
        ))}
      </div>
    </section>
  );
};

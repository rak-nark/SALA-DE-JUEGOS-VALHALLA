import { pointsZone } from "../myBookingsData";

export const PointsZone = () => {
  return (
    <aside className="flex flex-col items-center gap-6 rounded-2xl border border-secondary/10 bg-surface-container-high p-6 text-center transition-colors hover:border-secondary/40 md:flex-row md:text-left">
      <div className="flex size-20 shrink-0 items-center justify-center rounded-full bg-secondary/10">
        <span
          className="material-symbols-outlined text-5xl text-secondary"
          style={{ fontVariationSettings: "'FILL' 1" }}
        >
          loyalty
        </span>
      </div>

      <div className="flex-1">
        <h3 className="mb-1 text-xl font-semibold">{pointsZone.title}</h3>
        <p className="font-display text-4xl font-bold text-secondary">
          {pointsZone.points.toLocaleString("es-CO")}
        </p>
        <p className="mt-2 text-sm text-on-surface-variant">
          {pointsZone.description}
        </p>
      </div>

      <button
        className="w-full rounded-lg bg-primary-container px-8 py-3 font-bold text-white transition-colors hover:bg-primary hover:text-on-secondary md:w-auto"
        type="button"
      >
        Canjear ahora
      </button>
    </aside>
  );
};

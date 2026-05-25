export const ProfileStats = ({ stats }) => {
  const items = [
    { label: 'Reservas totales', value: stats.totalReservations },
    { label: 'Horas jugadas', value: stats.playedHours },
  ]

  return (
    <aside className="space-y-gutter md:col-span-4">
      <section className="glass-card rounded-xl p-6 md:p-8">
        <h3 className="mb-6 font-display text-3xl font-semibold text-secondary">
          Estadísticas
        </h3>

        <div className="space-y-6">
          {items.map((item) => (
            <div key={item.label} className="flex items-center justify-between">
              <span className="text-on-surface-variant">{item.label}</span>
              <span className="font-bold text-on-surface">{item.value}</span>
            </div>
          ))}
        </div>
      </section>
    </aside>
  )
}

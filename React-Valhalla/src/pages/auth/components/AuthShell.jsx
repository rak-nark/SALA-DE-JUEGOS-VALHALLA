import { Link } from 'react-router-dom'

export const AuthShell = ({ children }) => {
  return (
    <main className="relative flex min-h-screen items-center justify-center overflow-hidden px-margin-mobile py-16">
      <div className="pointer-events-none absolute -left-20 top-1/4 size-96 rounded-full bg-primary/20 blur-[120px]" />
      <div className="pointer-events-none absolute -right-20 bottom-1/4 size-80 rounded-full bg-secondary/20 blur-[100px]" />

      <Link
        to="/"
        className="absolute left-margin-mobile top-6 z-20 font-display text-3xl font-black uppercase text-secondary md:left-margin-desktop"
      >
        Valhalla
      </Link>

      <div className="glass-card relative z-10 w-full max-w-115 rounded-xl p-8 shadow-2xl transition-all duration-500 hover:border-secondary/30 md:p-10">
        {children}
      </div>

      <div className="pointer-events-none absolute bottom-0 left-0 hidden h-75 w-full bg-linear-to-t from-secondary/20 to-transparent lg:block" />
    </main>
  )
}

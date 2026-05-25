import { Footer } from '../../layout/Footer'
import { Header } from '../../layout/Header'
import { ReservationForm } from './components/ReservationForm'

export const Reservation = () => {
  return (
    <>
      <Header />
      <main className="mx-auto min-h-screen w-full max-w-container-max-width px-margin-mobile pb-20 pt-32 md:px-margin-desktop">
        <div className="mx-auto mb-8 max-w-4xl text-center">
          <h1 className="font-display text-4xl font-semibold tracking-normal text-on-background md:text-5xl">
            Gestión de préstamos de consolas
          </h1>
          <p className="mx-auto mt-3 max-w-2xl text-lg leading-7 text-on-surface-variant">
            Reserva tu equipo, define tu tiempo de juego y prepárate para dominar la
            arena.
          </p>
        </div>

        <div className="mx-auto max-w-4xl">
          <ReservationForm />
        </div>
      </main>
      <Footer />
    </>
  )
}

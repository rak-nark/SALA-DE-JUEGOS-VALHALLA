import { Footer } from '../../layout/Footer'
import { Header } from '../../layout/Header'
import { BenefitsSection } from './components/BenefitsSection'
import { ConsoleSection } from './components/ConsoleSection'
import { GameGallery } from './components/GameGallery'
import { HeroSection } from './components/HeroSection'

export const Home = () => {
  return (
    <>
      <Header />
      <main className="pt-20">
        <HeroSection />
        <ConsoleSection />
        <GameGallery />
        <BenefitsSection />
      </main>
      <Footer />
    </>
  )
}

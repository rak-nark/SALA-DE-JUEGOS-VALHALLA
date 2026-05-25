const platformLinks = [
  { label: 'Política de privacidad', href: '/privacy' },
  { label: 'Términos del servicio', href: '/terms' },
  { label: 'Soporte', href: '/support' },
]
const communityLinks = [
  { label: 'Instagram', href: 'https://instagram.com' },
  { label: 'Discord', href: 'https://discord.com' },
  { label: 'Twitch', href: 'https://twitch.tv' },
]

export const Footer = () => {
  return (
    <footer className="w-full border-t border-outline-variant/30 bg-background py-16">
      <div className="mx-auto grid max-w-container-max-width grid-cols-1 gap-gutter px-margin-mobile md:grid-cols-3 md:px-margin-desktop">
        <div className="flex flex-col gap-6">
          <div className="font-display text-3xl font-black text-secondary">Valhalla</div>
          <p className="max-w-xs text-on-surface-variant">
            Elevando tu experiencia de juego a otro nivel con la mejor tecnología y los
            mejores títulos.
          </p>
          <div className="flex gap-4">
            <a
              className="flex size-10 items-center justify-center rounded-full bg-surface-container transition-colors hover:text-secondary"
              href="/"
              aria-label="Sitio web"
            >
              <span className="material-symbols-outlined">public</span>
            </a>
            <a
              className="flex size-10 items-center justify-center rounded-full bg-surface-container transition-colors hover:text-secondary"
              href="/support"
              aria-label="Chat"
            >
              <span className="material-symbols-outlined">chat_bubble</span>
            </a>
          </div>
        </div>

        <FooterColumn title="Plataforma" links={platformLinks} />
        <FooterColumn title="Comunidad" links={communityLinks} />
      </div>

      <div className="mt-16 text-center text-on-surface-variant">
        © 2026 Valhalla. Todos los derechos reservados.
      </div>
    </footer>
  )
}

const FooterColumn = ({ title, links }) => (
  <div className="flex flex-col gap-4">
    <h5 className="mb-2 text-lg font-semibold">{title}</h5>
    {links.map((link) => (
      <a
        key={link.label}
        className="text-on-surface-variant transition-colors hover:text-secondary"
        href={link.href}
      >
        {link.label}
      </a>
    ))}
  </div>
)

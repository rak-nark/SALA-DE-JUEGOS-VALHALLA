import { galleryImages } from '../homeData'

export const GameGallery = () => {
  const loopingImages = galleryImages.flatMap((item) => [
    { ...item, loopKey: `${item.id}-primary` },
    { ...item, loopKey: `${item.id}-duplicate` },
  ])

  return (
    <section className="overflow-hidden bg-surface-container-lowest py-24">
      <div className="mx-auto mb-12 max-w-container-max-width px-margin-mobile md:px-margin-desktop">
        <h2 className="text-center font-display text-4xl font-semibold md:text-5xl">
          Galería de juegos
        </h2>
        <div className="mx-auto mt-4 h-1 w-24 rounded-full bg-secondary" />
      </div>

      <div className="relative flex">
        <div className="animate-gallery-scroll gap-6 px-4">
          {loopingImages.map((item) => (
            <figure
              key={item.loopKey}
              className="glass-panel group h-100 w-75 shrink-0 overflow-hidden rounded-xl"
            >
              <img
                className="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                src={item.image}
                alt={item.alt}
              />
            </figure>
          ))}
        </div>
      </div>
    </section>
  )
}

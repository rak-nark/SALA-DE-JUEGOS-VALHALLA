import { useEffect, useState } from "react";
import { Link, NavLink, useNavigate } from "react-router-dom";
import { authService } from "../services/authService";
import { useAuthStatus } from "../hooks/useAuthStatus";

export const Header = () => {
  const navigate = useNavigate();
  const [isScrolled, setIsScrolled] = useState(false);
  const isAuthenticated = useAuthStatus();

  const navItems = [
    { label: "Home", path: "/" },
    ...(isAuthenticated ? [{ label: "Mi Perfil", path: "/profile" }] : []),
    { label: "Reservar Consola", path: "/reservation" },
    ...(isAuthenticated
      ? [{ label: "Mis Reservas", path: "/my-bookings" }]
      : []),
  ];

  const handleSessionButtonClick = () => {
    if (isAuthenticated) {
      authService.logout();
    }

    navigate("/login");
  };

  useEffect(() => {
    const handleScroll = () => setIsScrolled(window.scrollY > 50);

    handleScroll();
    window.addEventListener("scroll", handleScroll, { passive: true });

    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  return (
    <header
      className={`fixed top-0 z-50 w-full backdrop-blur-xl shadow-[0_0_15px_-2px_rgba(44,245,44,0.3)] transition-colors ${
        isScrolled ? "bg-background/90" : "bg-surface/10"
      }`}
    >
      <nav className="mx-auto flex w-full max-w-container-max-width items-center justify-between px-margin-mobile py-4 md:px-margin-desktop">
        <Link
          to="/"
          className="font-display text-3xl font-black uppercase tracking-normal text-secondary"
        >
          Valhalla
        </Link>

        <div className="hidden items-center gap-8 md:flex">
          {navItems.map((item) => (
            <NavLink
              key={item.label}
              to={item.path}
              className={({ isActive }) =>
                `text-base transition-colors duration-200 hover:text-secondary ${
                  isActive
                    ? "active-underline border-b-2 border-secondary pb-1 text-secondary"
                    : "text-on-surface"
                }`
              }
            >
              {item.label}
            </NavLink>
          ))}
        </div>

        <button
          className="rounded-lg bg-primary-container px-5 py-2 font-bold text-white transition-transform hover:scale-105 active:scale-95 md:px-6 neon-glow"
          type="button"
          onClick={handleSessionButtonClick}
        >
          {isAuthenticated ? "Cerrar sesión" : "Iniciar sesión"}
        </button>
      </nav>
    </header>
  );
};

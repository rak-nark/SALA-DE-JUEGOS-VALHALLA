import { useEffect } from "react";
import {
  BrowserRouter,
  Navigate,
  Route,
  Routes,
  useLocation,
} from "react-router-dom";
import { Login } from "../pages/auth/Login";
import { Register } from "../pages/auth/Register";
import { Home } from "../pages/home/Home";
import { MyBookings } from "../pages/myBookings/MyBookings";
import { Profile } from "../pages/profile/Profile";
import { Reservation } from "../pages/reservation/Reservation";
import { useAuthStatus } from "../hooks/useAuthStatus";

const ScrollToTop = () => {
  const { pathname } = useLocation();

  useEffect(() => {
    window.scrollTo({ top: 0, left: 0, behavior: "auto" });
  }, [pathname]);

  return null;
};

export const AppRouter = () => {
  const isAuthenticated = useAuthStatus();

  return (
    <BrowserRouter>
      <ScrollToTop />
      <Routes>
        <Route path="/" element={<Home />} />
        <Route
          path="/profile"
          element={
            isAuthenticated ? <Profile /> : <Navigate to="/login" replace />
          }
        />
        <Route path="/reservation" element={<Reservation />} />
        <Route
          path="/my-bookings"
          element={
            isAuthenticated ? <MyBookings /> : <Navigate to="/login" replace />
          }
        />
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route path="*" element={<Navigate to="/" replace />} />
      </Routes>
    </BrowserRouter>
  );
};

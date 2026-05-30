import { useEffect, useState } from "react";
import { authService } from "../services/authService";

export const useAuthStatus = () => {
  const [isAuthenticated, setIsAuthenticated] = useState(() =>
    authService.isAuthenticated(),
  );

  useEffect(() => {
    const handleAuthChange = () => {
      setIsAuthenticated(authService.isAuthenticated());
    };

    window.addEventListener("auth:changed", handleAuthChange);
    window.addEventListener("storage", handleAuthChange);

    return () => {
      window.removeEventListener("auth:changed", handleAuthChange);
      window.removeEventListener("storage", handleAuthChange);
    };
  }, []);

  return isAuthenticated;
};

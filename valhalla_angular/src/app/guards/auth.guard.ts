import { CanActivateFn } from '@angular/router';
import { inject } from '@angular/core';
import { AuthService } from '../services/auth.service';  // Asegúrate de que la ruta es correcta
import { Router } from '@angular/router';

export const authGuard: CanActivateFn = (route, state) => {
  const authService = inject(AuthService);
  const router = inject(Router);

  if (authService.isAuthenticated()) {
    return true; // Permitir acceso si el usuario está autenticado
  } else {
    // Redirigir al login y guardar la URL actual para redirigir después del login
    router.navigate(['/login'], { queryParams: { returnUrl: state.url } });
    return false;
  }
};


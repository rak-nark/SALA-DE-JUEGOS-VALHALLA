import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { Observable } from 'rxjs';
import { tap } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private apiUrl = 'http://127.0.0.1:8000/api';  // URL de la API Laravel

  constructor(private http: HttpClient, private router: Router) {}

  // Iniciar sesión
  login(credentials: any): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/login`, credentials).pipe(
      tap({
        next: (response) => {
          console.log('Respuesta del backend:', response); // 🔹 Depuración
          if (response.token && response.cliente && response.cliente.idCliente) {
            localStorage.setItem('token', response.token);
            localStorage.setItem('userId', response.cliente.idCliente); // 🔹 Guardar el userId
          } else {
            console.error('La respuesta del backend no tiene la estructura esperada:', response);
          }
        },
        error: (err) => {
          console.error('Error en la solicitud de login:', err);
        }
      })
    );
  }

  // Guardar token en localStorage
  setToken(token: string): void {
    localStorage.setItem('token', token);
  }

  // Obtener token
  getToken(): string | null {
    return localStorage.getItem('token');
  }

  // Obtener usuario autenticado
  getUser(): Observable<any> {
    return this.http.get(`${this.apiUrl}/user`, {
      headers: { Authorization: `Bearer ${this.getToken()}` }
    });
  }

  // Verificar si el usuario está autenticado
  isAuthenticated(): boolean {
    return !!this.getToken();
  }

  // Cerrar sesión
  logout(): void {
    localStorage.removeItem('token');
    localStorage.removeItem('userId'); // Eliminar el userId al cerrar sesión
    this.router.navigate(['/login']);
  }

  // Obtener el cliente autenticado desde el localStorage
  getClienteFromStorage(): any {
    const userId = localStorage.getItem('userId');
    if (userId) {
      return { id: userId }; // Devuelve un objeto con el ID del cliente
    }
    return null; // Si no hay userId, devuelve null
  }
}
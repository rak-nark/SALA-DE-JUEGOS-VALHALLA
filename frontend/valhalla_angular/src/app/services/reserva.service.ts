import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { AuthService } from './auth.service';

@Injectable({
  providedIn: 'root'
})
export class ReservaService {
  private apiUrl = 'https://refactored-space-tribble-7vv5ppv64wgjfrvjp-8000.app.github.dev/api';  // URL de la API Laravel

  constructor(private http: HttpClient, private authService: AuthService) {}

  // Obtener las reservas del usuario autenticado
  getMisReservas(): Observable<any> {
    const token = this.authService.getToken();
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });

    return this.http.get(`${this.apiUrl}/mis-reservas`, { headers });
  }

  // Editar una reserva
  editarReserva(idPrestamo: number, datosReserva: any): Observable<any> {
    const token = this.authService.getToken();
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });

    return this.http.put(`${this.apiUrl}/reserva/${idPrestamo}`, datosReserva, { headers });
  }

  // Eliminar una reserva
  eliminarReserva(idPrestamo: number): Observable<any> {
    const token = this.authService.getToken();
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });

    return this.http.delete(`${this.apiUrl}/reserva/${idPrestamo}`, { headers });
  }
}
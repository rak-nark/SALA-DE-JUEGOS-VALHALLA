import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { AuthService } from './auth.service';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ReservaService {
  private apiUrl = environment.apiUrl;  // URL de la API Laravel

  constructor(private http: HttpClient, private authService: AuthService) { }
  private getAuthHeaders() {
  const token = this.authService.getToken();
  return {
    headers: new HttpHeaders({
      Authorization: `Bearer ${token}`
    })
  };
}

  getReservas(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/reserva`, this.getAuthHeaders());
  }

  crearReserva(datos: any): Observable<any> {
    return this.http.post(`${this.apiUrl}/reserva`, datos, this.getAuthHeaders());
  }

  getReservaById(id: number): Observable<any> {
    return this.http.get(`${this.apiUrl}/reserva/${id}`, this.getAuthHeaders());
  }

  editarReserva(id: number, datos: any): Observable<any> {
    return this.http.put(`${this.apiUrl}/reserva/${id}`, datos, this.getAuthHeaders());
  }

  eliminarReserva(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/reserva/${id}`, this.getAuthHeaders());
  }

  getMisReservas(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/mis-reservas`, this.getAuthHeaders());
  }
}
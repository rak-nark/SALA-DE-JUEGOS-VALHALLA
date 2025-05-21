import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PrestamoService {
  private apiUrl = 'https://refactored-space-tribble-7vv5ppv64wgjfrvjp-8000.app.github.dev/api/reserva';  // URL del backend Laravel

  constructor(private http: HttpClient) {}

  // Obtener token almacenado
  private getAuthHeaders() {
    const token = localStorage.getItem('token');
    return {
      headers: new HttpHeaders({
        Authorization: `Bearer ${token}`
      })
    };
  }

  // Obtener todos los préstamos
  getPrestamos(): Observable<any[]> {
    return this.http.get<any[]>(this.apiUrl, this.getAuthHeaders());
  }

  // Obtener un préstamo por ID
  getPrestamoById(id: string): Observable<any> {
    return this.http.get(`${this.apiUrl}/${id}`, this.getAuthHeaders());
  }

  // Crear un nuevo préstamo
  createPrestamo(data: any): Observable<any> {
    return this.http.post(this.apiUrl, data, this.getAuthHeaders());
  }

  // Actualizar un préstamo
  updatePrestamo(id: string, data: any): Observable<any> {
    return this.http.put(`${this.apiUrl}/${id}`, data, this.getAuthHeaders());
  }

  // Eliminar un préstamo
  deletePrestamo(id: string): Observable<any> {
    return this.http.delete(`${this.apiUrl}/${id}`, this.getAuthHeaders());
  }
}


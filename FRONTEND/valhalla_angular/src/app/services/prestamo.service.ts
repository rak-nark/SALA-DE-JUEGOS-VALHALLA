import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment'; // Asegúrate de que la ruta sea correcta
@Injectable({
  providedIn: 'root'
})
export class PrestamoService {
private apiUrl = environment.apiUrl + '/reserva';  // URL de la API Laravel
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
  return this.http.get<any[]>(`${this.apiUrl}/prestamos`, this.getAuthHeaders());
  }

  // Obtener un préstamo por ID
  getPrestamosPorCliente(clienteId: string): Observable<any[]> {
  return this.http.get<any[]>(`${this.apiUrl}/prestamos/${clienteId}`, this.getAuthHeaders());
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


import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators, AbstractControl, FormBuilder } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';
import { ReservaService } from '../../services/reserva.service'; // 👈 Importa el service

@Component({
  selector: 'app-reserva',
  templateUrl: './reserva.component.html',
  styleUrls: ['./reserva.component.css']
})
export class ReservaComponent implements OnInit {

  intervalosDeTiempo: { value: string, label: string }[] = [];
  consolas = [
    { id: 1, nombre: 'Xbox 360 1' },
    { id: 2, nombre: 'Xbox 360 2' },
    { id: 3, nombre: 'Xbox 360 3' },
    { id: 4, nombre: 'Xbox 360 4' },
    { id: 5, nombre: 'Xbox 360 5' },
    { id: 6, nombre: 'Xbox 360 6' },
    { id: 7, nombre: 'Xbox 360 7' },
    { id: 8, nombre: 'Xbox 360 8' },
    { id: 9, nombre: 'Xbox One 1' },
    { id: 10, nombre: 'Xbox One 2' },
    { id: 11, nombre: 'Xbox One 3' },
    { id: 12, nombre: 'Xbox One 4' },
    { id: 13, nombre: 'Xbox One 5' }
  ];
  tiemposDisponibles = [
    { label: '30 minutos', value: 30 },
    { label: '1 hora', value: 60 },
    { label: '1 hora 30 minutos', value: 90 },
    { label: '2 horas', value: 120 },
    { label: '3 horas', value: 180 }
  ];

  form!: FormGroup;
  hoy: string = new Date().toISOString().split('T')[0]; // Fecha actual en formato YYYY-MM-DD
  dosDiasDespues: string = new Date(new Date().setDate(new Date().getDate() + 2)).toISOString().split('T')[0]; // Dos días después

  constructor(
    private router: Router,
    private authService: AuthService,
    private reservaService: ReservaService, // 👈 Inyecta el service
    private fb: FormBuilder
  ) {
    this.form = this.fb.group({
      fecha: [this.hoy, [Validators.required, this.validarFecha.bind(this)]],
      hora: ['', [Validators.required, Validators.pattern(/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/)]],
      tiempodeuso: [1, [Validators.required, Validators.min(1)]],
      reserva: [true],
      id_cliente: ['', Validators.required],
      id_consola: ['', Validators.required]
    });
  }

  ngOnInit(): void {
    this.generarIntervalosDeTiempo();

    // Obtener el ID del cliente autenticado desde el localStorage
    const userId = localStorage.getItem('userId');
    console.log('userId desde localStorage:', userId);
    if (userId) {
      this.form.patchValue({ id_cliente: userId });
    } else {
      alert('No se pudo obtener el ID del cliente. Por favor, inicie sesión nuevamente.');
      this.router.navigate(['/login']);
    }
  }

  generarIntervalosDeTiempo(): void {
    const start = 10; // 10 AM
    const end = 20;   // 8 PM

    for (let hour = start; hour <= end; hour++) {
      for (let minute = 0; minute < 60; minute += 30) {
        if (hour === end && minute > 0) break;

        const date = new Date();
        date.setHours(hour, minute);

        const value = date.toTimeString().slice(0, 5); // HH:MM
        const label = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        this.intervalosDeTiempo.push({ value, label });
      }
    }
  }

  validarFecha(control: AbstractControl): { [key: string]: boolean } | null {
    const fechaSeleccionada = new Date(control.value);
    const hoy = new Date(this.hoy);
    const dosDiasDespues = new Date(this.dosDiasDespues);
    if (fechaSeleccionada < hoy || fechaSeleccionada > dosDiasDespues) {
      return { fechaInvalida: true };
    }
    return null;
  }

  guardar() {
    if (this.form.valid) {
      const datos = this.form.value;
      this.reservaService.crearReserva(datos).subscribe({
        next: (respuesta: any) => {
          alert('¡Reserva exitosa!');
          this.router.navigate(['/home']);
        },
        error: (err) => {
          if (err.status === 400 && err.error?.error) {
            const errores = err.error.error;
            const mensajes = Object.values(errores).flat().join('\n');
            alert(mensajes);
          } else {
            const mensaje = err?.error?.message || 'Ocurrió un error al hacer la reserva.';
            alert(mensaje);
          }
        }
      });
    } else {
      this.mostrarErrores();
    }
  }

  mostrarErrores() {
    Object.keys(this.form.controls).forEach(field => {
      const control = this.form.get(field);
      if (control && control.invalid) {
        control.markAsTouched();
      }
    });
  }

  logout(): void {
    this.authService.logout();
  }
}

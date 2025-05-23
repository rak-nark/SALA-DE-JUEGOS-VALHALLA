import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.css']
})
export class SignupComponent implements OnInit {
  form!: FormGroup;

  constructor(
    private fb: FormBuilder,
    private authService: AuthService,
    private router: Router
  ) {}

  ngOnInit(): void {
    this.form = this.fb.group({
      nombreCliente: [
        '',
        [Validators.required, Validators.pattern(/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/)]
      ],
      apellidoCliente: [
        '',
        [Validators.required, Validators.pattern(/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/)]
      ],
      correoCliente: ['', [Validators.required, Validators.email]],
      contrasenaCliente: ['', [Validators.required, Validators.minLength(8)]]
    });
  }

  signup(): void {
    if (this.form.valid) {
      const datos = this.form.value;
      this.authService.register(datos).subscribe({
        next: () => {
          console.log('Usuario registrado con éxito');
          this.router.navigate(['/home']);
        },
        error: (error) => console.error('Error al registrar usuario:', error)
      });
    } else {
      console.error('El formulario no es válido.');
      this.form.markAllAsTouched();
    }
  }
}
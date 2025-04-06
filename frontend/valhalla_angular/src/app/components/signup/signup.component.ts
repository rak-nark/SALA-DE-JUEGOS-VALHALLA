import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.css']
})
export class SignupComponent implements OnInit {
  form!: FormGroup;
  constructor(private http: HttpClient, private router: Router) {}
  ngOnInit() {
    this.form = new FormGroup({
      nombreCliente: new FormControl('', Validators.required),
      apellidoCliente: new FormControl('', Validators.required),
      correoCliente: new FormControl('', [Validators.required, Validators.email]),
      contrasenaCliente: new FormControl('', [Validators.required, Validators.minLength(8)])
    });
  }
  signup() {
    if (this.form.valid) {
      const datos = this.form.value;
      this.http.post('http://127.0.0.1:8000/api/register', datos).subscribe({
        next: () => {
          console.log('Usuario registrado con éxito');
          this.router.navigate(['/home']);
        },
        error: (error) => console.error('Error al registrar usuario:', error)
      });
    } else {
      console.error('El formulario no es válido.');
    }
  }
}

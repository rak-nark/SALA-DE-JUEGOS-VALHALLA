import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms'; 
import { ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule, HTTP_INTERCEPTORS} from '@angular/common/http';  // Se agregó aquí
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HomeComponent } from './components/home/home.component';
import { LoginComponent } from './components/login/login.component';
import { PerfilComponent } from './components/perfil/perfil.component';
import { ReservaComponent } from './components/reserva/reserva.component';
import { SignupComponent } from './components/signup/signup.component';
import { MisReservasComponent } from './components/mis-reservas/mis-reservas.component';
import { AuthInterceptor } from './interceptors/auth.interceptor';


@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    LoginComponent,  // Se agregó aquí si no es standalone
    PerfilComponent,
    ReservaComponent,
    SignupComponent,
    MisReservasComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    ReactiveFormsModule,
    HttpClientModule,  // Se agregó aquí
    FormsModule,
  ],
  providers: [
    { provide: HTTP_INTERCEPTORS, useClass: AuthInterceptor, multi: true } // 🔹 Activa el interceptor
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }


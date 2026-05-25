import { BrowserRouter, Navigate, Route, Routes } from 'react-router-dom'
import { Login } from '../pages/auth/Login'
import { Register } from '../pages/auth/Register'
import { Home } from '../pages/home/Home'
import { MyBookings } from '../pages/myBookings/MyBookings'
import { Profile } from '../pages/profile/Profile'
import { Reservation } from '../pages/reservation/Reservation'

export const AppRouter = () => {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/profile" element={<Profile />} />
        <Route path="/reservation" element={<Reservation />} />
        <Route path="/my-bookings" element={<MyBookings />} />
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route path="*" element={<Navigate to="/" replace />} />
      </Routes>
    </BrowserRouter>
  )
}

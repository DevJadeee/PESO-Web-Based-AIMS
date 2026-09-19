import { api } from './api'

export const authService = {
  login: (credentials) => api.login(credentials),
  logout: () => api.logout(),
  isAuthenticated: () => sessionStorage.getItem('peso-admin') === 'true',
  markAuthenticated: () => sessionStorage.setItem('peso-admin', 'true'),
  clearSession: () => sessionStorage.removeItem('peso-admin'),
}

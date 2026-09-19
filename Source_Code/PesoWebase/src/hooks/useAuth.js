import { useState } from 'react'
import { authService } from '../services/authService'

export function useAuth() {
  const [authenticated, setAuthenticated] = useState(authService.isAuthenticated)
  const login = () => {
    authService.markAuthenticated()
    setAuthenticated(true)
  }
  const logout = () => {
    authService.clearSession()
    setAuthenticated(false)
  }
  return { authenticated, login, logout }
}

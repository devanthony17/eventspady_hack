import { createContext, useContext, useState, useCallback } from 'react'
import api from '../api/api'

const AuthContext = createContext(null)

export function AuthProvider({ children }) {
  const [user, setUser] = useState(() => {
    try {
      const stored = localStorage.getItem('user_data')
      return stored ? JSON.parse(stored) : null
    } catch {
      return null
    }
  })

  const [token, setToken] = useState(() => localStorage.getItem('user_token') || null)

  const login = useCallback(async (email, password) => {
    const res = await api.post('/user/login', { email, password })
    const { token: newToken, user: newUser } = res.data
    localStorage.setItem('user_token', newToken)
    localStorage.setItem('user_data', JSON.stringify(newUser))
    setToken(newToken)
    setUser(newUser)
    return res.data
  }, [])

  const register = useCallback(async (payload) => {
    const res = await api.post('/user/register', payload)
    return res.data
  }, [])

  const logout = useCallback(() => {
    localStorage.removeItem('user_token')
    localStorage.removeItem('user_data')
    setToken(null)
    setUser(null)
  }, [])

  const updateUser = useCallback((data) => {
    const updated = { ...user, ...data }
    localStorage.setItem('user_data', JSON.stringify(updated))
    setUser(updated)
  }, [user])

  return (
    <AuthContext.Provider value={{ user, token, isLoggedIn: !!token, login, logout, register, updateUser }}>
      {children}
    </AuthContext.Provider>
  )
}

export function useAuth() {
  const ctx = useContext(AuthContext)
  if (!ctx) throw new Error('useAuth must be used inside AuthProvider')
  return ctx
}

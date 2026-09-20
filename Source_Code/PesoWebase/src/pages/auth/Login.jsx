import { useState } from 'react'
import Icon from '../../components/common/Icon'
import { authService } from '../../services/authService'

export default function Login({ onLogin }) {
  const [showPassword, setShowPassword] = useState(false)
  const [error, setError] = useState('')
  const [loading, setLoading] = useState(false)
  // Principle 4 - Error Exception Handling: catches login failures, shows a friendly message, and resets loading state so a failed login does not crash the form.
  const submit = async (event) => {
    event.preventDefault()
    setError('')
    setLoading(true)
    const form = new FormData(event.currentTarget)
    try {
      const result = await authService.login({ email: form.get('email'), password: form.get('password') })
      onLogin(result.user)
    } catch {
      setError('The provided credentials do not match our records.')
    } finally {
      setLoading(false)
    }
  }
  return (
    <div className="login-page">
      <div className="login-blank">
        <div className="login-brand">
          <p className="login-kicker">YOUR NEXT OPPORTUNITY STARTS HERE</p>
          <div className="login-logo">
            <img src="/peso-logo.svg" alt="PESO Agoo logo" />
          </div>
          <p className="login-eyebrow">MUNICIPALITY OF AGOO, LA UNION</p>
          <h2>
            Public Employment
            <br />
            Service Office
          </h2>
          <p className="login-copy">
            Opening doors to local careers, practical programs, and a brighter working future.
          </p>
          <div className="login-accent">
            <span /> <span /> <span />
          </div>
        </div>
      </div>
      <div className="login-side">
        <form className="login-box" onSubmit={submit}>
          <div className="login-title">
            <h1>Welcome Back</h1>
            <p>Sign in to your PESO or employer account</p>
          </div>
          <p className="form-heading">Please enter your credentials to continue.</p>
          {error && <div className="form-error">{error}</div>}
          <label>Email Address</label>
          <div className="field-icon">
            <Icon>✉</Icon>
            <input
              name="email"
              type="email"
              placeholder="Enter your email"
              defaultValue="admin@pesoagoo.gov.ph"
              required
            />
          </div>
          <label>Password</label>
          <div className="field-icon">
            <Icon>•••</Icon>
            <input
              name="password"
              type={showPassword ? 'text' : 'password'}
              placeholder="Enter your password"
              defaultValue="password123"
              required
            />
            <button
              type="button"
              className="icon-button"
              onClick={() => setShowPassword(!showPassword)}
            >
              {showPassword ? '◉' : '◌'}
            </button>
          </div>
          <button className="login-button" disabled={loading}>
            {loading ? 'Signing In...' : 'Sign In'}
          </button>
          <div className="divider">
            <span>Protected access</span>
          </div>
          <p className="signup-link">
            New applicant? <a href="/applicant/account">Create an applicant account</a>
          </p>
          <p className="signup-link">
            Employer? <a href="/employer/account">Create an employer account</a>
          </p>
        </form>
      </div>
    </div>
  )
}

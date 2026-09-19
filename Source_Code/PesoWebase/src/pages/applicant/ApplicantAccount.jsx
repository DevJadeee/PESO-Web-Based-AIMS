import { useState } from 'react'
import ApplicantLayout from '../../layouts/ApplicantLayout'
import { api } from '../../services/api'

export default function ApplicantAccount({ onLogin }) {
  const [error, setError] = useState('')
  const [created, setCreated] = useState(false)

  // Defensive Programming: validates password confirmation before creating the applicant account.
  const submit = async (event) => {
    event.preventDefault()
    setError('')
    const form = new FormData(event.currentTarget)

    if (form.get('password') !== form.get('confirm_password')) {
      setError('Passwords do not match.')
      return
    }

    try {
      await api.applicant.register({
        name: form.get('name'),
        email: form.get('email'),
        password: form.get('password'),
      })
      setCreated(true)
    } catch {
      setError('This email may already be registered. Please try another email.')
    }
  }

  return (
    <ApplicantLayout>
      <section className="account-page">
        <span className="eyebrow">PESO JOBSEEKER ACCESS</span>
        <h2>Create your applicant account</h2>
        <p>
          Use your account to see approved jobs, apply securely, and track every update.
        </p>

        {created ? (
          <div className="form-success">
            <strong>Account created successfully.</strong>
            <p>You can now sign in through the PESO login page.</p>
            <button className="btn primary" onClick={onLogin}>
              Go to sign in
            </button>
          </div>
        ) : (
          <form className="account-form" onSubmit={submit}>
            {error && <div className="form-error">{error}</div>}

            <label>
              Full name
              <input name="name" required placeholder="Maria Santos" />
            </label>

            <label>
              Email address
              <input name="email" type="email" required placeholder="you@example.com" />
            </label>

            <label>
              Password
              <input name="password" type="password" minLength="8" required />
            </label>

            <label>
              Confirm password
              <input name="confirm_password" type="password" minLength="8" required />
            </label>

            <button className="btn primary" type="submit">
              Create applicant account
            </button>

            <button className="text-button" type="button" onClick={onLogin}>
              Already have an account? Sign in
            </button>
          </form>
        )}
      </section>
    </ApplicantLayout>
  )
}


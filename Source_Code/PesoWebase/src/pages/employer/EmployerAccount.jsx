import { useState } from 'react'
import ApplicantLayout from '../../layouts/ApplicantLayout'
import { api } from '../../services/api'

export default function EmployerAccount({ onLogin }) {
  const [error, setError] = useState('')
  const [created, setCreated] = useState(false)
  const submit = async (event) => {
    event.preventDefault()
    setError('')
    const form = new FormData(event.currentTarget)
    if (form.get('password') !== form.get('confirm_password')) {
      setError('Passwords do not match.')
      return
    }
    try {
      await api.employer.register({
        name: form.get('name'),
        email: form.get('email'),
        password: form.get('password'),
        contact_number: form.get('contact_number'),
      })
      setCreated(true)
    } catch {
      setError('This email may already be registered. Please try another email.')
    }
  }
  return (
    <ApplicantLayout>
      <section className="account-page">
        <span className="eyebrow">PESO EMPLOYER ACCESS</span>
        <h2>Create your employer account</h2>
        <p>Register your organization. PESO will evaluate and approve the account before you can post vacancies.</p>
        {created ? (
          <div className="form-success">
            <strong>Registration submitted for PESO review.</strong>
            <p>After approval, sign in to post and manage job vacancies.</p>
            <button className="btn primary" onClick={onLogin}>Go to sign in</button>
          </div>
        ) : (
          <form className="account-form" onSubmit={submit}>
            {error && <div className="form-error">{error}</div>}
            <label>Organization name<input name="name" required placeholder="Agoo Distribution Center" /></label>
            <label>Business email<input name="email" type="email" required placeholder="hr@company.com" /></label>
            <label>Contact number<input name="contact_number" required placeholder="09171234567" /></label>
            <label>Password<input name="password" type="password" minLength="8" required /></label>
            <label>Confirm password<input name="confirm_password" type="password" minLength="8" required /></label>
            <button className="btn primary" type="submit">Submit for PESO approval</button>
            <button className="text-button" type="button" onClick={onLogin}>Already have an account? Sign in</button>
          </form>
        )}
      </section>
    </ApplicantLayout>
  )
}

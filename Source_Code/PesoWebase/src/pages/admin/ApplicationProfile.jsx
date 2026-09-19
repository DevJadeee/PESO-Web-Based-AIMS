import { useEffect, useState } from 'react'
import { api } from '../../services/api'
import FullSubmissionDetails from '../../components/common/FullSubmissionDetails'

const statuses = ['Pending', 'Under Review', 'Approved', 'Completed', 'Rejected']
export default function ApplicationProfile({ id, edit = false }) {
  const [application, setApplication] = useState(null)
  const [form, setForm] = useState({})
  const [error, setError] = useState('')
  useEffect(() => {
    api.admin
      .application(id)
      .then((data) => {
        setApplication(data)
        setForm(data)
      })
      .catch(() => setError('Unable to load application.'))
  }, [id])
  if (!application)
    return <section className="panel form-panel">{error || 'Loading application...'}</section>
  const update = (event) => setForm({ ...form, [event.target.name]: event.target.value })
  const save = async (event) => {
    event.preventDefault()
    try {
      await api.admin.updateApplication(id, form)
      window.open(`/admin/applications/${id}`, '_self')
    } catch {
      setError('Unable to save application changes.')
    }
  }
  if (edit)
    return (
      <form className="panel form-panel profile-form" onSubmit={save}>
        <div className="panel-header">
          <h3>Edit Application</h3>
        </div>
        <label>
          Program
          <input value={`${application.program?.code} - ${application.program?.name}`} disabled />
        </label>
        <label>
          Status
          <select name="status" value={form.status || ''} onChange={update}>
            {statuses.map((status) => (
              <option key={status}>{status}</option>
            ))}
          </select>
        </label>
        {['purpose_or_position', 'place_or_agency', 'submission_date', 'remarks'].map((field) => (
          <label key={field}>
            {field.replaceAll('_', ' ')}
            <input name={field} value={form[field] || ''} onChange={update} />
          </label>
        ))}
        <TimePickerField value={form.time_in || ''} onChange={(value) => setForm({ ...form, time_in: value })} />
        {error && <div className="form-error">{error}</div>}
        <button className="btn primary">Save Changes</button>
      </form>
    )
  return (
    <section className="panel profile-view">
      <div className="panel-header">
        <div>
          <h3>{application.application_number}</h3>
          <small>
            {application.applicant?.full_name} • {application.applicant?.applicant_code}
          </small>
        </div>
        <div>
          <button
            className="btn secondary"
            onClick={() => window.open(`/admin/applications/${id}/edit`, '_self')}
          >
            Edit
          </button>
          <button
            className="btn secondary"
            onClick={() => window.open(`/admin/applications/${id}/print`, '_blank')}
          >
            Print
          </button>
        </div>
      </div>
      <div className="profile-grid">
        {[
          ['Applicant', application.applicant?.full_name],
          ['Program', `${application.program?.code} - ${application.program?.name}`],
          ['Purpose / Position', application.purpose_or_position],
          ['Place / Agency', application.place_or_agency],
          ['Time In', application.time_in],
          ['Status', application.status],
          ['Submission Date', application.submission_date],
          ['Remarks', application.remarks],
        ].map(([label, value]) => (
          <div key={label}>
            <small>{label}</small>
            <strong>{value || 'N/A'}</strong>
          </div>
        ))}
      </div>
      <FullSubmissionDetails applicant={application.applicant} />
    </section>
  )
}

function TimePickerField({ value, onChange }) {
  const [open, setOpen] = useState(false)
  const [hour, setHour] = useState('12')
  const [minute, setMinute] = useState('00')
  const [period, setPeriod] = useState('AM')
  const openPicker = () => {
    if (value) {
      const [hours, minutes] = value.split(':').map(Number)
      setHour(String(hours % 12 || 12).padStart(2, '0'))
      setMinute(String(minutes).padStart(2, '0'))
      setPeriod(hours >= 12 ? 'PM' : 'AM')
    }
    setOpen(true)
  }
  const saveTime = () => {
    let hours = Number(hour) % 12
    if (period === 'PM') hours += 12
    onChange(`${String(hours).padStart(2, '0')}:${minute}`)
    setOpen(false)
  }
  return (
    <>
      <label className="time-picker-field">
        Time In
        <button type="button" className="time-picker-button" onClick={openPicker}>
          <span>{value ? formatTime(value) : 'Choose time'}</span>
          <span className="time-picker-icon" aria-hidden="true">
            ◷
          </span>
        </button>
      </label>
      {open && (
        <div className="time-picker-backdrop" role="presentation" onMouseDown={() => setOpen(false)}>
          <div
            className="time-picker-dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="time-picker-title"
            onMouseDown={(event) => event.stopPropagation()}
          >
            <div className="time-picker-dialog-header">
              <span>Time In</span>
              <strong id="time-picker-title">{hour}:{minute} {period}</strong>
            </div>
            <div className="time-picker-controls">
              <select value={hour} onChange={(event) => setHour(event.target.value)} aria-label="Hour">
                {Array.from({ length: 12 }, (_, index) => {
                  const option = String(index + 1).padStart(2, '0')
                  return <option key={option}>{option}</option>
                })}
              </select>
              <span>:</span>
              <select value={minute} onChange={(event) => setMinute(event.target.value)} aria-label="Minute">
                {Array.from({ length: 60 }, (_, index) => {
                  const option = String(index).padStart(2, '0')
                  return <option key={option}>{option}</option>
                })}
              </select>
              <select value={period} onChange={(event) => setPeriod(event.target.value)} aria-label="AM or PM">
                <option>AM</option>
                <option>PM</option>
              </select>
            </div>
            <div className="time-picker-actions">
              <button type="button" className="btn secondary" onClick={() => setOpen(false)}>
                Cancel
              </button>
              <button type="button" className="btn primary" onClick={saveTime}>
                Set Time
              </button>
            </div>
          </div>
        </div>
      )}
    </>
  )
}

function formatTime(value) {
  const [hours, minutes] = value.split(':').map(Number)
  return `${String(hours % 12 || 12).padStart(2, '0')}:${String(minutes).padStart(2, '0')} ${hours >= 12 ? 'PM' : 'AM'}`
}

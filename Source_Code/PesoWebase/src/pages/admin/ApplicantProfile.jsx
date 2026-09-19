import { useEffect, useState } from 'react'
import { api } from '../../services/api'
import FullSubmissionDetails from '../../components/common/FullSubmissionDetails'

export default function ApplicantProfile({ id, edit = false }) {
  const [applicant, setApplicant] = useState(null)
  const [form, setForm] = useState({})
  const [error, setError] = useState('')
  useEffect(() => {
    api.admin
      .applicant(id)
      .then((data) => {
        setApplicant(data)
        setForm(data)
      })
      .catch(() => setError('Unable to load applicant profile.'))
  }, [id])
  if (!applicant)
    return <section className="panel form-panel">{error || 'Loading applicant profile...'}</section>
  const update = (event) => setForm({ ...form, [event.target.name]: event.target.value })
  const save = async (event) => {
    event.preventDefault()
    try {
      await api.admin.updateApplicant(id, form)
      window.open(`/admin/applicants/${id}`, '_self')
    } catch {
      setError('Unable to save applicant changes.')
    }
  }
  if (edit)
    return (
      <form className="panel form-panel profile-form" onSubmit={save}>
        <div className="panel-header">
          <h3>Edit Applicant Record</h3>
        </div>
        {[
          'first_name',
          'middle_name',
          'last_name',
          'suffix',
          'birth_date',
          'gender',
          'civil_status',
          'contact_number',
          'email',
          'barangay',
          'address',
          'educational_attainment',
          'course_or_major',
          'skills',
          'emergency_contact_name',
          'emergency_contact_number',
        ].map((field) => (
          <label key={field}>
            <span>{field.replaceAll('_', ' ')}</span>
            <input name={field} value={form[field] || ''} onChange={update} />
          </label>
        ))}
        {error && <div className="form-error">{error}</div>}
        <button className="btn primary">Save Changes</button>
      </form>
    )
  return (
    <section className="panel profile-view">
      <div className="panel-header">
        <div>
          <h3>{applicant.full_name}</h3>
          <small>{applicant.applicant_code}</small>
        </div>
        <div>
          <button
            className="btn secondary"
            onClick={() => window.open(`/admin/applicants/${id}/edit`, '_self')}
          >
            Edit
          </button>
          <button
            className="btn secondary"
            onClick={() => window.open(`/admin/applicants/${id}/print`, '_blank')}
          >
            Print
          </button>
        </div>
      </div>
      <div className="profile-grid">
        {[
          ['Contact Number', applicant.contact_number],
          ['Email', applicant.email || 'No email provided'],
          ['Barangay', applicant.present_barangay_name || applicant.barangay],
          ['Address', applicant.present_address || applicant.address],
          ['Birth Date', applicant.birth_date],
          ['Gender', applicant.gender],
          ['Civil Status', applicant.civil_status],
          ['Education', applicant.educational_attainment],
          ['Course / Major', applicant.course_or_major],
          ['Skills', applicant.skills],
          ['Emergency Contact', applicant.emergency_contact_name],
          ['Emergency Number', applicant.emergency_contact_number],
        ].map(([label, value]) => (
          <div key={label}>
            <small>{label}</small>
            <strong>{value || 'N/A'}</strong>
          </div>
        ))}
      </div>
      <FullSubmissionDetails applicant={applicant} />
      <h4>Application History</h4>
      <div className="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Application</th>
              <th>Program</th>
              <th>Purpose</th>
              <th>Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            {(applicant.applications || []).map((application) => (
              <tr key={application.id}>
                <td>{application.application_number}</td>
                <td>{application.program?.code}</td>
                <td>{application.purpose_or_position}</td>
                <td>{application.submission_date}</td>
                <td>{application.status}</td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </section>
  )
}

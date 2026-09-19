import { useEffect, useState } from 'react'
import { api } from '../../services/api'

export default function Applicants() {
  const [filters, setFilters] = useState({ search: '', program: '', education: '' })
  const [data, setData] = useState({ data: [], total: 0 })
  const [error, setError] = useState('')
  const load = () =>
    api
      .applicants(filters)
      .then(setData)
      .catch(() => setError('Unable to connect to the PESO server.'))
  useEffect(() => {
    load()
  }, [])
  const update = (event) => setFilters({ ...filters, [event.target.name]: event.target.value })
  const remove = async (id) => {
    if (!window.confirm('Permanently delete this applicant record?')) return
    try {
      await api.admin.deleteApplicant(id)
      load()
    } catch {
      setError('Unable to delete applicant record.')
    }
  }
  return (
    <section className="panel full-panel">
      <div className="panel-header">
        <h3>Master Applicant Information Records</h3>
        <button
          className="btn primary"
          onClick={() => window.open('/applicant/account', '_blank')}
        >
          Create Applicant Account
        </button>
      </div>
      <div className="filters modern-filters">
        <div className="filter-intro">
          <strong>Find applicants</strong>
          <span>Search and narrow the records below</span>
        </div>
        <label className="filter-control filter-search-control">
          <span>Search</span>
          <input
            name="search"
            value={filters.search}
            onChange={update}
            placeholder="Name, code, contact, barangay"
          />
        </label>
        <label className="filter-control">
          <span>Program</span>
          <select name="program" value={filters.program} onChange={update}>
            <option value="">All programs</option>
            <option>GIP</option>
            <option>JOB</option>
            <option>SPES</option>
          </select>
        </label>
        <label className="filter-control">
          <span>Education</span>
          <select name="education" value={filters.education} onChange={update}>
            <option value="">All education</option>
            <option>High School</option>
            <option>College Undergraduate</option>
            <option>College Graduate</option>
            <option>Vocational</option>
          </select>
        </label>
        <button className="btn primary filter-submit" onClick={load}>
          Apply filters
        </button>
      </div>
      {error && <div className="form-error">{error}</div>}
      <div className="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Applicant Code</th>
              <th>Full Name</th>
              <th>Contact & Email</th>
              <th>Barangay</th>
              <th>Educational Attainment</th>
              <th>Registered Programs</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {data.data.map((applicant) => (
              <tr key={applicant.id}>
                <td>
                  <strong>{applicant.applicant_code}</strong>
                </td>
                <td>
                  <strong>{applicant.full_name}</strong>
                  <small>
                    {applicant.gender || 'N/A'} • {applicant.civil_status || 'N/A'}
                  </small>
                </td>
                <td>
                  {applicant.contact_number}
                  <small>{applicant.email || 'No email provided'}</small>
                </td>
                <td>{applicant.present_barangay_name || applicant.barangay || 'Agoo'}</td>
                <td>
                  <span className="badge completed">
                    {applicant.educational_attainment || 'Unspecified'}
                  </span>
                  <small>{applicant.course_or_major}</small>
                </td>
                <td>
                  {(applicant.applications || []).map((application) => (
                    <span
                      className={`program-pill ${application.program?.code?.toLowerCase()}`}
                      key={application.id}
                    >
                      {application.program?.code}
                    </span>
                  ))}
                </td>
                <td>
                  <button
                    className="table-action"
                    onClick={() => window.open(`/admin/applicants/${applicant.id}`, '_self')}
                  >
                    View
                  </button>
                  <button
                    className="table-action"
                    onClick={() => window.open(`/admin/applicants/${applicant.id}/edit`, '_self')}
                  >
                    Edit
                  </button>
                  <button
                    className="table-action"
                    onClick={() => window.open(`/admin/applicants/${applicant.id}/print`, '_blank')}
                  >
                    Print
                  </button>
                  <button className="table-action" onClick={() => remove(applicant.id)}>
                    Delete
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
      <div className="pagination">
        <span>
          Showing {data.data.length} of {data.total} records
        </span>
        <span>Pagination is available through the API response.</span>
        <span>Pagination is available through the API response.</span>
      </div>
    </section>
  )
}

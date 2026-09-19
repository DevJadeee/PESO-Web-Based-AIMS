import { useEffect, useState } from 'react'
import { api } from '../../services/api'
import DatePicker from '../../components/common/DatePicker'

const statuses = ['Pending', 'Under Review', 'Approved', 'Completed', 'Rejected']
const colors = { GIP: 'gip', JOB: 'job', SPES: 'spes' }
const programNames = {
  GIP: 'Government Internship Program',
  JOB: 'Job Referral and Placement',
  SPES: 'Special Program for Employment of Students',
}
const statusClass = (status) => status.toLowerCase().replaceAll(' ', '-')

export default function ProgramApplications({ code }) {
  const [filters, setFilters] = useState({ search: '', status: '', date_from: '' })
  const [data, setData] = useState({
    program: { name: code },
    total: 0,
    applications: { data: [] },
  })
  const [error, setError] = useState('')
  const load = () =>
    api.admin
      .applications(code, filters)
      .then(setData)
      .catch(() => setError('Unable to connect to the PESO server.'))
  useEffect(() => {
    load()
  }, [code])
  const updateFilter = (event) =>
    setFilters({ ...filters, [event.target.name]: event.target.value })
  const updateStatus = async (id, status) => {
    try {
      await api.admin.updateStatus(id, { status })
      load()
    } catch {
      setError('Unable to update application status.')
    }
  }
  const remove = async (id) => {
    if (!window.confirm('Delete this application record?')) return
    try {
      await api.admin.deleteApplication(id)
      load()
    } catch {
      setError('Unable to delete application.')
    }
  }
  const applications = data.applications?.data || []
  return (
    <>
      <div className={`program-banner ${colors[code] || 'gip'}`}>
        <div>
          <strong>{code} MODULE</strong>
          <span>{programNames[code] || data.program?.name}</span>
          <p>{data.program?.description}</p>
        </div>
        <b>{data.total || 0}</b>
      </div>
      <section className="panel full-panel">
        <div className="filters modern-filters">
          <div className="filter-intro">
            <strong>Filter applications</strong>
            <span>Search this program's records</span>
          </div>
          <label className="filter-control filter-search-control">
            <span>Search</span>
            <input
              name="search"
              value={filters.search}
              onChange={updateFilter}
              placeholder="Applicant, purpose, agency"
            />
          </label>
          <label className="filter-control">
            <span>Status</span>
            <select name="status" value={filters.status} onChange={updateFilter}>
              <option value="">All statuses</option>
              {statuses.map((status) => (
                <option key={status}>{status}</option>
              ))}
            </select>
          </label>
          <DatePicker
            name="date_from"
            label="Submitted from"
            compact
            value={filters.date_from}
            onChange={updateFilter}
          />
          <button className="btn primary filter-submit" onClick={load}>
            Apply filters
          </button>
        </div>
        {error && <div className="form-error">{error}</div>}
        <div className="table-wrap">
          <table>
            <thead>
              <tr>
                <th>Date / Application</th>
                <th>Applicant</th>
                <th>Place / Agency</th>
                <th>Purpose / Position</th>
                <th>Time In</th>
                <th>Contact</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              {applications.map((application) => (
                <tr key={application.id}>
                  <td>
                    <strong>{application.submission_date || 'N/A'}</strong>
                    <small>{application.application_number}</small>
                  </td>
                  <td>
                    <strong className="link-text">
                      {application.applicant?.full_name || 'Unknown'}
                    </strong>
                    <small>{application.applicant?.applicant_code}</small>
                  </td>
                  <td>{application.place_or_agency || 'PESO Agoo'}</td>
                  <td>{application.purpose_or_position}</td>
                  <td>{application.time_in || 'N/A'}</td>
                  <td>{application.applicant?.contact_number || 'N/A'}</td>
                  <td>
                    <select
                      className={`status-select program-status-${colors[code] || 'gip'} status-${statusClass(application.status || 'Pending')}`}
                      value={application.status}
                      onChange={(event) => updateStatus(application.id, event.target.value)}
                    >
                      {statuses.map((status) => (
                        <option key={status}>{status}</option>
                      ))}
                    </select>
                  </td>
                  <td>
                    <button
                      className="table-action"
                      onClick={() => window.open(`/admin/applications/${application.id}`, '_self')}
                    >
                      View
                    </button>
                    <button
                      className="table-action"
                      onClick={() =>
                        window.open(`/admin/applications/${application.id}/edit`, '_self')
                      }
                    >
                      Edit
                    </button>
                    <button className="table-action" onClick={() => remove(application.id)}>
                      Delete
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </section>
    </>
  )
}

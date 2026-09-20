import { useEffect, useState } from 'react'
import { api, SERVER_WEB_URL } from '../../services/api'
import DatePicker from '../../components/common/DatePicker'
import './Reports.css'

const statuses = ['Approved', 'Pending', 'Under Review', 'Completed', 'Rejected']

function MetricCard({ title, value, note, tone = '' }) {
  return (
    <div className={`stat-card ${tone}`}>
      <div className="stat-info">
        <h3>{title}</h3>
        <div className="metric-value">{value ?? 0}</div>
        <p>{note}</p>
      </div>
      <div className="stat-icon">▤</div>
    </div>
  )
}

function formatDate(value) {
  if (!value) return 'N/A'
  return new Date(value).toLocaleDateString('en-US', {
    month: 'short',
    day: '2-digit',
    year: 'numeric',
  })
}

export default function Reports() {
  const [filters, setFilters] = useState({ date_from: '', date_to: '', program_id: '', status: '' })
  const [data, setData] = useState({
    dateFrom: '',
    dateTo: '',
    metrics: {},
    applications: [],
    programs: [],
  })
  const [error, setError] = useState('')
  const load = async () => {
    setError('')
    try {
      setData(await api.admin.reports(filters))
    } catch {
      setError('Unable to connect to the PESO server.')
    }
  }
  useEffect(() => {
    load()
  }, [])
  const update = (event) => setFilters({ ...filters, [event.target.name]: event.target.value })
  const reset = () => {
    setFilters({ date_from: '', date_to: '', program_id: '', status: '' })
    setTimeout(load, 0)
  }
  const printUrl = `${SERVER_WEB_URL}/admin/reports/print?${new URLSearchParams(filters)}`
  const previewUrl = `${SERVER_WEB_URL}/admin/reports/preview?${new URLSearchParams(filters)}`
  const pdfUrl = `${SERVER_WEB_URL}/admin/reports/pdf?${new URLSearchParams(filters)}`
  return (
    <>
      <section className="panel report-filter-card">
        <div className="panel-header">
          <h3>
            <span className="report-icon">☷</span>Report Filter Options
          </h3>
          <div className="report-header-actions">
            <button className="btn secondary" onClick={() => window.open(previewUrl, '_blank')}>
              View PDF Preview
            </button>
            <a className="btn secondary" href={pdfUrl}>
              Save as PDF
            </a>
            <button className="btn primary" onClick={() => window.open(printUrl, '_blank')}>
              ⎙ Print Official Report
            </button>
          </div>
        </div>
        <div className="report-filter-form">
          <DatePicker name="date_from" label="Date From" value={filters.date_from} onChange={update} compact />
          <DatePicker name="date_to" label="Date To" value={filters.date_to} onChange={update} compact />
          <div className="report-field">
            <label>Program Module</label>
            <select name="program_id" value={filters.program_id} onChange={update}>
              <option value="">-- All Programs --</option>
              {data.programs.map((program) => (
                <option key={program.id} value={program.id}>
                  {program.code} - {program.name}
                </option>
              ))}
            </select>
          </div>
          <div className="report-field">
            <label>Application Status</label>
            <select name="status" value={filters.status} onChange={update}>
              <option value="">-- All Statuses --</option>
              {statuses.map((status) => (
                <option key={status}>{status}</option>
              ))}
            </select>
          </div>
        </div>
        <div className="report-filter-actions">
          <button className="btn secondary" onClick={reset}>
            Reset Filters
          </button>
          <button className="btn primary" onClick={load}>
            ⌕ Generate Report
          </button>
        </div>
      </section>
      {error && <div className="form-error">{error}</div>}
      <div className="metrics-grid report-metrics">
        <MetricCard
          title="Filtered Total"
          value={data.metrics.total}
          note="Applications Recorded"
        />
        <MetricCard
          title="GIP Applications"
          value={data.metrics.gip}
          note="Govt Internship"
          tone="stat-gip"
        />
        <MetricCard
          title="Job Placement"
          value={data.metrics.job}
          note="Job Referrals"
          tone="stat-job"
        />
        <MetricCard
          title="SPES Students"
          value={data.metrics.spes}
          note="Student Employment"
          tone="stat-spes"
        />
      </div>
      <section className="panel report-details">
        <div className="panel-header">
          <h3>
            <span className="report-icon">▦</span>Report Details Summary Data
          </h3>
          <span className="report-period">
            Period: {formatDate(data.dateFrom)} - {formatDate(data.dateTo)}
          </span>
        </div>
        <div className="table-wrap">
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>App Number</th>
                <th>Submission Date</th>
                <th>Applicant Name</th>
                <th>Barangay</th>
                <th>Program</th>
                <th>Purpose / Position</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              {data.applications.length ? (
                data.applications.map((application, index) => (
                  <tr key={application.id}>
                    <td>{index + 1}</td>
                    <td>
                      <strong className="link-text">{application.application_number}</strong>
                    </td>
                    <td>{formatDate(application.submission_date)}</td>
                    <td>
                      <strong>{application.applicant?.full_name || 'N/A'}</strong>
                    </td>
                    <td>
                      {application.applicant?.barangay ||
                        application.applicant?.present_barangay_name ||
                        'Agoo'}
                    </td>
                    <td>
                      <span className={`program-pill ${application.program?.code?.toLowerCase()}`}>
                        {application.program?.code}
                      </span>
                    </td>
                    <td>{application.purpose_or_position}</td>
                    <td>
                      <span
                        className={`badge ${application.status?.toLowerCase().replace(' ', '-')}`}
                      >
                        {application.status}
                      </span>
                    </td>
                  </tr>
                ))
              ) : (
                <tr>
                  <td colSpan="8" className="empty-report">
                    No applications match the selected report criteria.
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
      </section>
    </>
  )
}

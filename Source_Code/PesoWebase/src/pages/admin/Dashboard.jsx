import { useEffect, useState } from 'react'
import Icon from '../../components/common/Icon'
import ApplicationsTable from '../../components/common/ApplicationsTable'
import { api } from '../../services/api'

export default function Dashboard({ setPage }) {
  const [data, setData] = useState(null)
  const [error, setError] = useState('')
  useEffect(() => {
    api
      .dashboard()
      .then(setData)
      .catch(() => setError('Unable to connect to the PESO server.'))
  }, [])
  const metrics = data?.metrics || { totalApplicants: 0, gip: 0, job: 0, spes: 0 }
  const metricCards = [
    ['Total Applicants', metrics.totalApplicants, 'Central Database Profiles', 'users'],
    ['GIP Applications', metrics.gip, 'Government Internship Program', 'GIP'],
    ['Job Applications', metrics.job, 'Job Referral & Placement', 'JOB'],
    ['SPES Applications', metrics.spes, 'Student Employment', 'SPES'],
  ]
  return (
    <>
      <div className="metrics-grid">
        {metricCards.map(([label, value, note, icon], index) => (
          <div className={`stat-card metric-${index}`} key={label}>
            <div>
              <h3>{label}</h3>
              <div className="metric-value">{value}</div>
              <p>{note}</p>
            </div>
            <div className="stat-icon">{icon === 'users' ? '♙' : icon}</div>
          </div>
        ))}
      </div>
      {error && <div className="form-error">{error}</div>}
      <div className="dashboard-grid">
        <section className="panel">
          <div className="panel-header">
            <h3>
              <Icon>◷</Icon>Recent Application Submissions
            </h3>
            <button className="btn secondary small" onClick={() => setPage('applicants')}>
              View All Records
            </button>
          </div>
          <ApplicationsTable
            rows={(data?.recentApplications || []).map((application) => ({
              id: application.id,
              code: application.applicant?.applicant_code,
              name: application.applicant?.full_name,
              program: application.program?.code,
              purpose: application.purpose_or_position,
              status: application.status,
              date: application.submission_date,
            }))}
          />
        </section>
        <div className="stack">
          <section className="panel">
            <div className="panel-header">
              <h3>
                <Icon>✦</Icon>Quick Operations
              </h3>
            </div>
            <div className="quick-actions">
              <button
                className="btn secondary"
                onClick={() => window.open('/applicant/account', '_blank')}
              >
                ↗ Open Applicant Account Page
              </button>
              <button className="btn secondary" onClick={() => setPage('reports')}>
                ▤ Generate Official PESO Report
              </button>
            </div>
          </section>
          <section className="panel activity">
            <div className="panel-header">
              <h3>
                <Icon>◉</Icon>System Activity Log
              </h3>
            </div>
            {(data?.recentActivity || []).map((item) => (
              <div className="activity-row" key={item.id}>
                <strong>{item.action}</strong>
                <span>{item.description}</span>
              </div>
            ))}
          </section>
        </div>
      </div>
    </>
  )
}

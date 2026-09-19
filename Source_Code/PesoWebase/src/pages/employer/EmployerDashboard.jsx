const metrics = [
  ['Active vacancies', '8', '+2 this month', 'teal'],
  ['Total applicants', '126', '+18 this week', 'blue'],
  ['Hired candidates', '14', '11% conversion', 'orange'],
  ['School-Ready listings', '3', 'All verified', 'green'],
]

const responseItems = [
  ['Warehouse Assistant', 'Maria Theresa Santos', '6 days waiting', 'urgent'],
  ['Junior Bookkeeper', 'John Michael Dela Cruz', '3 days waiting', 'watch'],
  ['Kitchen Staff', 'Angela Mae Flores', 'Responded today', 'done'],
]

export default function EmployerDashboard({ setPage }) {
  return (
    <>
      <section className="employer-welcome">
        <div>
          <span className="employer-eyebrow">Wednesday, September 16, 2026</span>
          <h2>Good morning, Agoo Distribution Center.</h2>
          <p>Keep your hiring moving with a clear view of vacancies, candidates, and response commitments.</p>
        </div>
        <button className="employer-primary" onClick={() => setPage('employer-jobs-new')}>+ Post a vacancy</button>
      </section>
      <section className="employer-metrics">
        {metrics.map(([label, value, note, tone]) => (
          <article className={`employer-metric ${tone}`} key={label}>
            <span>{label}</span><strong>{value}</strong><small>{note}</small>
          </article>
        ))}
      </section>
      <div className="employer-dashboard-grid">
        <section className="employer-panel response-panel">
          <div className="employer-panel-heading"><div><span className="employer-eyebrow">No-Ghosting Pledge</span><h3>Applicant responses</h3></div><button className="employer-text-button">View all</button></div>
          <p className="employer-panel-copy">Average response time <strong>2.4 days</strong>. Stay ahead of the 7-day commitment.</p>
          <div className="response-list">
            {responseItems.map(([job, applicant, time, state]) => <div className="response-item" key={`${job}-${applicant}`}><span className={`response-dot ${state}`} /><div><strong>{job}</strong><small>{applicant}</small></div><em className={state}>{time}</em></div>)}
          </div>
        </section>
        <section className="employer-panel">
          <div className="employer-panel-heading"><div><span className="employer-eyebrow">Candidate pipeline</span><h3>Hiring progress</h3></div></div>
          <div className="pipeline-bars"><div><span>New applicants <b>42</b></span><i style={{ width: '82%' }} /></div><div><span>For review <b>28</b></span><i style={{ width: '59%' }} /></div><div><span>Interview <b>12</b></span><i style={{ width: '34%' }} /></div><div><span>Hired <b>14</b></span><i style={{ width: '27%' }} /></div></div>
          <button className="employer-outline-button" onClick={() => setPage('employer-candidates')}>Review candidates</button>
        </section>
      </div>
      <section className="employer-panel employer-list-panel"><div className="employer-panel-heading"><div><span className="employer-eyebrow">Your listings</span><h3>Recent job vacancies</h3></div><button className="employer-text-button" onClick={() => setPage('employer-jobs')}>Manage vacancies</button></div><div className="employer-jobs-preview"><div><span className="job-status active">Active</span><strong>Warehouse Assistant</strong><small>12 applicants · Posted 4 days ago</small></div><div><span className="job-status review">Under PESO Review</span><strong>OJT Administrative Intern</strong><small>School-Ready documents pending</small></div><div><span className="job-status active">Active</span><strong>Junior Bookkeeper</strong><small>8 applicants · Posted 1 week ago</small></div></div></section>
    </>
  )
}

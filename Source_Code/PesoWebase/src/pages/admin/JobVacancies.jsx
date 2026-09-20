import { useEffect, useState } from 'react'
import { api } from '../../services/api'

export default function JobVacancies() {
  const [jobs, setJobs] = useState([])
  const [filter, setFilter] = useState('')
  const load = () => api.adminJobs.list().then(setJobs).catch(() => {})
  useEffect(() => { load() }, [])
  const approve = async (id) => { await api.adminJobs.approve(id); load() }
  const visible = jobs.filter((job) => !filter || job.status === filter)
  return <section className="panel full-panel vacancy-admin-page"><div className="panel-header"><div><h3>Job Vacancies</h3><small>Review employer postings and publish approved jobs to the applicant console.</small></div><div className="vacancy-admin-metrics"><span><strong>{jobs.length}</strong> Total</span><span><strong>{jobs.filter((job) => job.status === 'approved').length}</strong> Active</span><span><strong>{jobs.filter((job) => job.status === 'pending').length}</strong> For review</span></div></div><div className="modern-filters vacancy-filters"><label className="filter-control"><span>Status</span><select value={filter} onChange={(event) => setFilter(event.target.value)}><option value="">All statuses</option><option value="approved">Active</option><option value="pending">Under PESO Review</option></select></label></div><div className="vacancy-admin-list">{visible.map((job) => <article className="vacancy-admin-card" key={job.id}><div className="vacancy-admin-main"><span className={`job-status ${job.status === 'approved' ? 'active' : 'review'}`}>{job.status === 'approved' ? 'Active' : 'Under PESO Review'}</span><h4>{job.title}</h4><p>{job.employer} · {job.location}</p></div><div className="vacancy-admin-meta"><span><small>Employment type</small><strong>{job.type}</strong></span><span><small>Applicants</small><strong>{job.applicants || 0}</strong></span></div><div className="vacancy-admin-actions"><button className="table-action">View</button>{job.status === 'pending' && <button className="btn primary" onClick={() => approve(job.id)}>Approve and publish</button>}</div></article>)}</div></section>
}

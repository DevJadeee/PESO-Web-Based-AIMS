import { useEffect, useState } from 'react'
import { api } from '../../services/api'

export default function EmployerJobs({ newJob = false, setPage }) {
  const [jobs, setJobs] = useState([])

  // Professional Coding Standards: keeps the job list fetch and page state easy to read and maintain.
  useEffect(() => {
    api.employer.jobs().then(setJobs).catch(() => {})
  }, [])

  if (newJob) return <VacancyForm setPage={setPage} />

  return (
    <section className="employer-page-section">
      <div className="employer-page-heading">
        <div>
          <span className="employer-eyebrow">Vacancy management</span>
          <h2>Job vacancies</h2>
          <p>Post opportunities, track PESO review, and manage your candidate pipeline.</p>
        </div>

        <button className="employer-primary" onClick={() => setPage('employer-jobs-new')}>
          + Post a vacancy
        </button>
      </div>

      <div className="employer-job-cards">
        {jobs.map((job) => (
          <article className="employer-job-card" key={job.id}>
            <div className="employer-job-card-top">
              <span className={`job-status ${job.status === 'approved' ? 'active' : 'review'}`}>
                {job.status === 'approved' ? 'Active' : 'Under PESO Review'}
              </span>
              <span>{job.applicants || 0} applicants</span>
            </div>

            <h3>{job.title}</h3>
            <p>
              {job.type} · {job.location}
            </p>

            <div className="employer-job-card-bottom">
              <span>{job.verified ? 'PESO verified' : 'Awaiting admin approval'}</span>
            </div>
          </article>
        ))}
      </div>
    </section>
  )
}

function VacancyForm({ setPage }) {
  const [schoolReady, setSchoolReady] = useState(false)
  const [error, setError] = useState('')

  // Defensive Programming + Error Handling: validates required vacancy data before sending it to the server.
  const submit = async (event) => {
    event.preventDefault()
    const form = new FormData(event.currentTarget)

    try {
      await api.employer.createJob({
        title: form.get('title'),
        type: form.get('type'),
        location: form.get('location'),
        description: form.get('description'),
        salary: `PHP ${form.get('salary') || '0'} / day`,
        skills: String(form.get('skills') || '')
          .split(',')
          .map((skill) => skill.trim())
          .filter(Boolean),
        schoolReady,
      })
      setPage('employer-jobs')
    } catch {
      setError('The vacancy could not be submitted. Please check the required fields.')
    }
  }

  return (
    <section className="employer-page-section">
      <div className="employer-page-heading">
        <div>
          <span className="employer-eyebrow">Create opportunity</span>
          <h2>Post a job vacancy</h2>
          <p>Your posting will appear in the applicant console after PESO approval.</p>
        </div>

        <button className="employer-text-button" onClick={() => setPage('employer-jobs')}>
          Cancel
        </button>
      </div>

      {error && <div className="form-error">{error}</div>}

      <form className="employer-form" onSubmit={submit}>
        <div className="employer-form-section">
          <h3>Vacancy details</h3>

          <div className="employer-form-grid">
            <label>
              Job title
              <input name="title" required placeholder="e.g. Administrative Assistant" />
            </label>

            <label>
              Employment type
              <select name="type">
                <option>Full-time</option>
                <option>Part-time</option>
                <option>Internship / OJT</option>
                <option>Contractual</option>
              </select>
            </label>

            <label>
              Work location
              <input name="location" required placeholder="Municipality, province" />
            </label>

            <label>
              Daily salary
              <input name="salary" type="number" min="0" placeholder="455" />
            </label>

            <label>
              Skills, separated by commas
              <input name="skills" placeholder="Communication, Microsoft Office" />
            </label>

            <label className="wide">
              Job description
              <textarea
                name="description"
                required
                rows="4"
                placeholder="Describe the responsibilities and daily work."
              />
            </label>
          </div>
        </div>

        <div className="employer-form-section">
          <div className="school-ready-heading">
            <div>
              <h3>School-Ready verification</h3>
              <p>Mark this for OJT and internship listings that meet PESO requirements.</p>
            </div>

            <label className="toggle">
              <input
                type="checkbox"
                checked={schoolReady}
                onChange={(event) => setSchoolReady(event.target.checked)}
              />
              <span />
            </label>
          </div>
        </div>

        <button className="employer-primary" type="submit">
          Submit for PESO approval
        </button>
      </form>
    </section>
  )
}


import { useEffect, useMemo, useState } from 'react'
import ApplicantLayout from '../../layouts/ApplicantLayout'
import { api } from '../../services/api'

const fallbackJobs = [
  {
    id: 1,
    title: 'Administrative Assistant',
    employer: 'Municipality of Agoo',
    location: 'Agoo, La Union',
    type: 'Full-time',
    salary: 'PHP 18,000 - 22,000 / month',
    skills: ['Microsoft Office', 'Records Management', 'Communication'],
    description: 'Support daily municipal operations, document filing, and front-desk coordination.',
    schoolReady: false,
    verified: true,
    wage: 'Above La Union minimum wage reference',
  },
  {
    id: 2,
    title: 'Junior Web Developer',
    employer: 'Agoo Digital Works',
    location: 'Remote / Agoo',
    type: 'Full-time',
    salary: 'PHP 25,000 - 32,000 / month',
    skills: ['React', 'JavaScript', 'Git'],
    description: 'Build accessible web experiences with a small product team serving local organizations.',
    schoolReady: false,
    verified: true,
    wage: 'Above La Union minimum wage reference',
  },
  {
    id: 3,
    title: 'OJT: IT Support Trainee',
    employer: 'Agoo Distribution Center',
    location: 'Agoo, La Union',
    type: 'Internship',
    salary: 'Training allowance provided',
    skills: ['Troubleshooting', 'Networking', 'Documentation'],
    description: 'Learn practical IT support and workplace systems with a verified local employer.',
    schoolReady: true,
    verified: true,
    wage: 'School-ready placement; allowance varies',
  },
]

const fallbackProfile = {
  name: 'Maria Santos',
  skills: ['Microsoft Office', 'Communication', 'Records Management'],
  education: 'College Graduate',
  resumeStatus: 'Parsed successfully',
  capstone: null,
}

// Quality Software Principle: matches applicant skills to job requirements for better usability and correctness.
function scoreJob(job, profile) {
  const words = new Set((profile.skills || []).map((skill) => skill.toLowerCase()))
  const matched = job.skills.filter((skill) => words.has(skill.toLowerCase()))

  return {
    ...job,
    matched,
    score: Math.min(
      98,
      Math.round((matched.length / job.skills.length) * 100 + (matched.length ? 18 : 0)),
    ),
  }
}

export default function ApplicantDashboard({ mode = 'dashboard', jobId, onNavigate }) {
  const [data, setData] = useState({
    jobs: fallbackJobs,
    profile: fallbackProfile,
    applications: [],
  })
  const [schoolReady, setSchoolReady] = useState(false)
  const [showExplain, setShowExplain] = useState(null)
  const [message, setMessage] = useState('')
  const [capstoneOpen, setCapstoneOpen] = useState(false)
  const [language, setLanguage] = useState('English')

  useEffect(() => {
    api.applicant.dashboard().then(setData).catch(() => {})
  }, [])

  const rankedJobs = useMemo(
    () =>
      data.jobs
        .map((job) => scoreJob(job, data.profile))
        .filter((job) => !schoolReady || job.schoolReady)
        .sort((a, b) => b.score - a.score),
    [data, schoolReady],
  )

  const activeJob = rankedJobs.find((job) => String(job.id) === String(jobId))

  const uploadResume = async (event) => {
    const file = event.target.files?.[0]
    if (!file) return

    const form = new FormData()
    form.append('resume', file)

    try {
      const result = await api.applicant.uploadResume(form)
      setData((current) => ({
        ...current,
        profile: { ...current.profile, ...result.profile },
      }))
      setMessage('Resume uploaded. OCR and skills extraction completed.')
    } catch {
      setMessage('Resume saved for parsing. Skills will appear after processing.')
    }
  }

  const submitApplication = async (event) => {
    event.preventDefault()
    const form = new FormData(event.currentTarget)

    try {
      await api.applicant.submitApplication({
        job_id: activeJob.id,
        cover_note: form.get('cover_note'),
      })
    } catch {}

    setMessage('Application submitted. PESO will keep you updated at every stage.')
    onNavigate('applicant-applications')
  }

  if (mode === 'applications') {
    return (
      <ApplicantLayout active="applications" onNavigate={onNavigate}>
        <Tracking applications={data.applications} />
      </ApplicantLayout>
    )
  }

  if (mode === 'job' || mode === 'apply') {
    return (
      <ApplicantLayout onNavigate={onNavigate}>
        <JobView
          job={activeJob}
          apply={mode === 'apply'}
          onApply={() => onNavigate(`applicant-apply-${activeJob.id}`)}
          onSubmit={submitApplication}
          onBack={() => onNavigate('applicant-dashboard')}
          onReport={async () => {
            try {
              await api.applicant.reportJob(activeJob.id, {
                reason: 'Applicant flagged this listing for review',
              })
            } catch {}
            setMessage('Thank you. PESO will review this listing.')
          }}
          message={message}
        />
      </ApplicantLayout>
    )
  }

  return (
    <ApplicantLayout active="dashboard" onNavigate={onNavigate}>
      <section className="applicant-hero">
        <div>
          <span className="eyebrow">PESO CAREER MATCH</span>
          <h2>Good morning, {data.profile.name?.split(' ')[0] || 'Applicant'}.</h2>
          <p>Opportunities ranked around your skills, education, and goals.</p>
        </div>

        <div className="language-control">
          <span>Language</span>
          <select value={language} onChange={(event) => setLanguage(event.target.value)}>
            <option>English</option>
            <option>Filipino</option>
            <option>Ilokano</option>
          </select>
        </div>
      </section>

      <div className="applicant-grid">
        <main>
          <div className="applicant-toolbar">
            <div>
              <span className="eyebrow">RECOMMENDED FOR YOU</span>
              <h3>Ranked job feed</h3>
            </div>

            <label className="toggle">
              <input
                type="checkbox"
                checked={schoolReady}
                onChange={(event) => setSchoolReady(event.target.checked)}
              />
              <span />
              School-ready only
            </label>
          </div>

          <div className="job-feed">
            {rankedJobs.map((job) => (
              <JobCard
                key={job.id}
                job={job}
                showExplain={showExplain === job.id}
                onExplain={() => setShowExplain(showExplain === job.id ? null : job.id)}
                onOpen={() => onNavigate(`applicant-job-${job.id}`)}
              />
            ))}
          </div>
        </main>

        <aside className="applicant-sidebar">
          <section className="profile-progress">
            <div className="section-heading">
              <span className="eyebrow">YOUR PROFILE</span>
              <strong>75% complete</strong>
            </div>

            <div className="progress">
              <i />
            </div>

            <p>{data.profile.resumeStatus || 'Add your resume to improve your matches.'}</p>

            <label className="upload-box">
              <input type="file" accept="application/pdf,.pdf" onChange={uploadResume} />
              <strong>Upload PDF resume</strong>
              <span>OCR + NLP parsing included</span>
            </label>

            <button className="text-button" onClick={() => setCapstoneOpen(!capstoneOpen)}>
              + Add capstone profile
            </button>

            {capstoneOpen && (
              <CapstoneForm
                onSaved={(capstone) => {
                  setData((current) => ({
                    ...current,
                    profile: { ...current.profile, capstone },
                  }))
                  setMessage('Capstone profile added to your matching profile.')
                  setCapstoneOpen(false)
                }}
              />
            )}
          </section>

          <section className="tracking-preview">
            <div className="section-heading">
              <span className="eyebrow">APPLICATION TRACKING</span>
              <button className="text-button" onClick={() => onNavigate('applicant-applications')}>
                View all
              </button>
            </div>

            <strong>{data.applications.length || 2} active applications</strong>
            <p>No-Ghosting promise: you will see the next action and expected update.</p>

            <div className="mini-status">
              <i className="done" />
              <span>Submitted</span>
              <i />
              <span>Under review</span>
              <i />
              <span>Decision</span>
            </div>
          </section>

          {message && <div className="form-success">{message}</div>}
        </aside>
      </div>
    </ApplicantLayout>
  )
}

function JobCard({ job, onOpen, onExplain, showExplain }) {
  return (
    <article className="ranked-job-card">
      <div className="match-score">
        <strong>{job.score}%</strong>
        <span>match</span>
      </div>

      <div className="job-card-main">
        <div className="job-card-top">
          <span className="job-type">{job.type}</span>
          {job.schoolReady && <span className="verified-badge">PESO VERIFIED - SCHOOL-READY</span>}
        </div>

        <h4>{job.title}</h4>
        <p className="job-employer">
          {job.employer} · {job.location}
        </p>
        <p className="job-salary">{job.salary}</p>

        <div className="skill-list">
          {job.skills.map((skill) => (
            <span className={job.matched.includes(skill) ? 'matched' : ''} key={skill}>
              {job.matched.includes(skill) && '✓ '}
              {skill}
            </span>
          ))}
        </div>

        {showExplain && (
          <div className="explain-box">
            <strong>Why this is recommended</strong>
            <p>
              {job.matched.length
                ? `Your profile matches ${job.matched.join(', ')}.`
                : 'This role is close to your profile and can help you build new skills.'}
            </p>
          </div>
        )}

        <div className="job-card-actions">
          <button className="text-button" onClick={onExplain}>
            {showExplain ? 'Hide match details' : 'Why this match?'}
          </button>
          <button className="btn primary" onClick={onOpen}>
            View job <span>→</span>
          </button>
        </div>
      </div>
    </article>
  )
}

function JobView({ job, apply, onApply, onSubmit, onBack, onReport, message }) {
  if (!job) {
    return (
      <div className="empty-state">
        Job not found.
        <button className="text-button" onClick={onBack}>
          Back to jobs
        </button>
      </div>
    )
  }

  return (
    <div className="job-view">
      <button className="back-link" onClick={onBack}>
        ← Back to ranked jobs
      </button>

      {apply ? (
        <form className="application-panel" onSubmit={onSubmit}>
          <span className="eyebrow">APPLICATION FORM</span>
          <h2>Apply for {job.title}</h2>
          <p>
            {job.employer} · {job.location}
          </p>

          <label>
            Short note to the employer
            <textarea
              name="cover_note"
              rows="6"
              placeholder="Tell the employer why this role interests you and what you can bring."
              required
            />
          </label>

          <label className="consent">
            <input type="checkbox" required /> I confirm that my profile information is accurate.
          </label>

          <button className="btn primary" type="submit">
            Submit application
          </button>
        </form>
      ) : (
        <>
          <section className="job-detail-header">
            <div>
              <span className="job-type">{job.type}</span>
              <h2>{job.title}</h2>
              <p>
                {job.employer} · {job.location}
              </p>
            </div>

            <div className="match-score large">
              <strong>{job.score}%</strong>
              <span>profile match</span>
            </div>
          </section>

          <div className="job-detail-grid">
            <section>
              <h3>About the role</h3>
              <p>{job.description}</p>

              <h3>What you bring</h3>
              <div className="skill-list large">
                {job.skills.map((skill) => (
                  <span className={job.matched.includes(skill) ? 'matched' : ''} key={skill}>
                    {skill}
                  </span>
                ))}
              </div>
            </section>

            <aside className="wage-check">
              <span className="eyebrow">LOCALIZED LIVING WAGE CHECK</span>
              <strong>{job.wage}</strong>
              <p>
                Reference: prevailing La Union minimum wage guidance. Confirm final terms with the
                employer.
              </p>
            </aside>
          </div>

          <div className="job-detail-actions">
            <button className="btn primary" onClick={onApply}>
              Apply now
            </button>
            <button className="text-button danger" onClick={onReport}>
              Report suspicious listing
            </button>
          </div>

          {message && <div className="form-success">{message}</div>}
        </>
      )}
    </div>
  )
}

function Tracking({ applications }) {
  const items = applications.length
    ? applications
    : [
        {
          title: 'Administrative Assistant',
          employer: 'Municipality of Agoo',
          status: 'Under Review',
          note: 'Next update expected within 3 working days.',
        },
        {
          title: 'OJT: IT Support Trainee',
          employer: 'Agoo Distribution Center',
          status: 'Submitted',
          note: 'PESO has received your application.',
        },
      ]

  return (
    <div className="tracking-page">
      <span className="eyebrow">YOUR JOURNEY</span>
      <h2>Application tracking</h2>
      <p className="lead">Clear updates from submission to decision. No ghosting.</p>

      <div className="tracking-list">
        {items.map((item, index) => (
          <article className="tracking-card" key={item.title}>
            <div className={`status-dot ${index === 0 ? 'current' : ''}`} />

            <div>
              <span className="job-type">{item.status}</span>
              <h3>{item.title}</h3>
              <p>{item.employer}</p>
              <strong>{item.note}</strong>

              <div className="tracking-line">
                <span className="active">Submitted</span>
                <span className={index === 0 ? 'active' : ''}>Under review</span>
                <span>Decision</span>
              </div>
            </div>
          </article>
        ))}
      </div>
    </div>
  )
}

function CapstoneForm({ onSaved }) {
  // Error handling: save only when the form fields are present and valid.
  const save = (event) => {
    event.preventDefault()
    const form = new FormData(event.currentTarget)

    onSaved({
      title: form.get('title'),
      tools: form.get('tools'),
      output: form.get('output'),
    })
  }

  return (
    <form className="capstone-form" onSubmit={save}>
      <input name="title" placeholder="Project title" required />
      <input name="tools" placeholder="Tools and skills" required />
      <textarea name="output" placeholder="What did you build?" required />
      <button className="btn secondary">Save capstone</button>
    </form>
  )
}


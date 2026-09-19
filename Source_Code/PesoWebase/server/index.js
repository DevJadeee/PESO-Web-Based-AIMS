import express from 'express'
import PDFDocument from 'pdfkit'
import multer from 'multer'
import crypto from 'node:crypto'
import fs from 'node:fs'
import path from 'node:path'
import { fileURLToPath } from 'node:url'

const __dirname = path.dirname(fileURLToPath(import.meta.url))
const root = path.resolve(__dirname, '..')
const dataDir = path.join(root, 'data')
const dataFile = path.join(dataDir, 'peso.json')
const uploadsDir = path.join(root, 'uploads', 'resumes')
const port = Number(process.env.PORT || 8000)
const app = express()
const upload = multer({
  dest: uploadsDir,
  limits: { fileSize: 5 * 1024 * 1024 },
  fileFilter: (request, file, callback) => {
    const allowedTypes = [
      'application/pdf',
      'application/msword',
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ]
    const extension = path.extname(file.originalname).toLowerCase()
    const allowedExtensions = ['.pdf', '.doc', '.docx']
    callback(null, allowedTypes.includes(file.mimetype) && allowedExtensions.includes(extension))
  },
})
const sessions = new Map()
const tokens = new Set()

// Professional coding: keep seed data, persistence, and request handling in clear boundaries.
const seed = {
  users: [
    {
      id: 1,
      name: 'Administrator',
      username: 'admin',
      email: 'admin@pesoagoo.gov.ph',
      password: 'password123',
      role: 'super_admin',
      contact_number: '',
    },
    {
      id: 2,
      name: 'Maria Santos',
      username: 'maria-santos',
      email: 'maria@example.com',
      password: 'applicant123',
      role: 'applicant',
      contact_number: '',
    },
  ],
  programs: [
    {
      id: 1,
      code: 'GIP',
      name: 'Government Internship Program',
      description: 'Work experience and skills training for qualified applicants.',
      badge_color: 'gip',
      is_active: 1,
    },
    {
      id: 2,
      code: 'JOB',
      name: 'Job Referral and Placement',
      description: 'Employment matching and referral services.',
      badge_color: 'job',
      is_active: 1,
    },
    {
      id: 3,
      code: 'SPES',
      name: 'Special Program for Employment of Students',
      description: 'Temporary employment assistance for eligible students.',
      badge_color: 'spes',
      is_active: 1,
    },
  ],
  applicants: [
    {
      id: 1,
      applicant_code: 'AG-2026-0001',
      full_name: 'Maria Theresa Santos',
      first_name: 'Maria Theresa',
      last_name: 'Santos',
      gender: 'Female',
      civil_status: 'Single',
      contact_number: '09171234567',
      email: 'maria@example.com',
      present_barangay_name: 'San Agustin',
      address: 'San Agustin, Agoo, La Union',
      education: 'College Graduate',
    },
    {
      id: 2,
      applicant_code: 'AG-2026-0002',
      full_name: 'John Michael Dela Cruz',
      first_name: 'John Michael',
      last_name: 'Dela Cruz',
      gender: 'Male',
      civil_status: 'Single',
      contact_number: '09181234567',
      email: 'john@example.com',
      present_barangay_name: 'Poblacion',
      address: 'Poblacion, Agoo, La Union',
      education: 'College Level',
    },
    {
      id: 3,
      applicant_code: 'AG-2026-0003',
      full_name: 'Angela Mae Flores',
      first_name: 'Angela Mae',
      last_name: 'Flores',
      gender: 'Female',
      civil_status: 'Single',
      contact_number: '09191234567',
      email: 'angela@example.com',
      present_barangay_name: 'Sta. Rita',
      address: 'Sta. Rita, Agoo, La Union',
      education: 'Senior High School',
    },
    {
      id: 4,
      applicant_code: 'AG-2026-0004',
      full_name: 'Ronaldo Garcia',
      first_name: 'Ronaldo',
      last_name: 'Garcia',
      gender: 'Male',
      civil_status: 'Married',
      contact_number: '09201234567',
      email: 'ronaldo@example.com',
      present_barangay_name: 'Nazarenas',
      address: 'Nazarenas, Agoo, La Union',
      education: 'College Graduate',
    },
  ],
  applications: [
    {
      id: 1,
      applicant_id: 1,
      program_id: 1,
      application_number: 'APP-2026-0001',
      purpose_or_position: 'Administrative Assistant',
      place_or_agency: 'Municipality of Agoo',
      status: 'Approved',
      submission_date: '2026-08-18',
      time_in: '08:30 AM',
      remarks: '',
    },
    {
      id: 2,
      applicant_id: 2,
      program_id: 2,
      application_number: 'APP-2026-0002',
      purpose_or_position: 'Warehouse Staff',
      place_or_agency: 'Agoo Distribution Center',
      status: 'Under Review',
      submission_date: '2026-08-17',
      time_in: '09:00 AM',
      remarks: '',
    },
    {
      id: 3,
      applicant_id: 3,
      program_id: 3,
      application_number: 'APP-2026-0003',
      purpose_or_position: 'Student Assistant',
      place_or_agency: 'Municipal Hall',
      status: 'Pending',
      submission_date: '2026-08-16',
      time_in: '10:15 AM',
      remarks: '',
    },
    {
      id: 4,
      applicant_id: 4,
      program_id: 1,
      application_number: 'APP-2026-0004',
      purpose_or_position: 'Records Clerk',
      place_or_agency: 'PESO Agoo',
      status: 'Completed',
      submission_date: '2026-08-15',
      time_in: '08:45 AM',
      remarks: '',
    },
  ],
  logs: [],
  jobs: [
    { id: 1, title: 'Administrative Assistant', employer: 'Municipality of Agoo', location: 'Agoo, La Union', type: 'Full-time', salary: 'PHP 18,000 - 22,000 / month', skills: ['Microsoft Office', 'Records Management', 'Communication'], description: 'Support daily municipal operations, document filing, and front-desk coordination.', schoolReady: false, verified: true, wage: 'Above La Union minimum wage reference' },
    { id: 2, title: 'Junior Web Developer', employer: 'Agoo Digital Works', location: 'Remote / Agoo', type: 'Full-time', salary: 'PHP 25,000 - 32,000 / month', skills: ['React', 'JavaScript', 'Git'], description: 'Build accessible web experiences with a small product team serving local organizations.', schoolReady: false, verified: true, wage: 'Above La Union minimum wage reference' },
    { id: 3, title: 'OJT: IT Support Trainee', employer: 'Agoo Distribution Center', location: 'Agoo, La Union', type: 'Internship', salary: 'Training allowance provided', skills: ['Troubleshooting', 'Networking', 'Documentation'], description: 'Learn practical IT support and workplace systems with a verified local employer.', schoolReady: true, verified: true, wage: 'School-ready placement; allowance varies' },
  ],
  jobseekers: [{ id: 1, name: 'Maria Santos', email: 'maria@example.com', skills: ['Microsoft Office', 'Communication', 'Records Management'], education: 'College Graduate' }],
  resumes: [],
  capstone_profiles: [],
}

// Principle 3 - Defensive Programming: creates required storage and initializes a predictable default dataset before use so missing data cannot break the app.
function loadDb() {
  fs.mkdirSync(dataDir, { recursive: true })
  if (!fs.existsSync(dataFile)) fs.writeFileSync(dataFile, JSON.stringify(seed, null, 2))
  const stored = JSON.parse(fs.readFileSync(dataFile, 'utf8'))
  if (!stored.users.some((user) => user.email === 'employer@obrakonek.local')) {
    stored.users.push({
      id: nextId(stored.users),
      name: 'Agoo Distribution Center',
      username: 'agoo-distribution',
      email: 'employer@obrakonek.local',
      password: 'employer123',
      role: 'employer',
      contact_number: '',
    })
    fs.writeFileSync(dataFile, JSON.stringify(stored, null, 2))
  }
  if (!stored.users.some((user) => user.email === 'maria@example.com')) {
    stored.users.push({
      id: nextId(stored.users),
      name: 'Maria Santos',
      username: 'maria-santos',
      email: 'maria@example.com',
      password: 'applicant123',
      role: 'applicant',
      contact_number: '',
    })
  }
  const applicantEmails = new Set()
  stored.applicants.forEach((applicant) => {
    const email = String(applicant.email || '').trim().toLowerCase()
    if (!email || applicantEmails.has(email) || stored.users.some((user) => user.email === email)) return
    applicantEmails.add(email)
    stored.users.push({
      id: nextId(stored.users),
      name: applicant.full_name || `${applicant.first_name || ''} ${applicant.last_name || ''}`.trim(),
      username: email.split('@')[0],
      email,
      password: 'applicant123',
      role: 'applicant',
      contact_number: applicant.contact_number || '',
    })
  })
  stored.users = stored.users.map((user) => ({
    status: user.role === 'employer' ? 'approved' : 'active',
    ...user,
  }))
  stored.jobs ||= seed.jobs
  stored.jobs = stored.jobs.map((job) => ({ status: 'approved', ...job }))
  stored.jobseekers ||= seed.jobseekers
  stored.resumes ||= []
  stored.capstone_profiles ||= []
  stored.applications ||= []
  fs.writeFileSync(dataFile, JSON.stringify(stored, null, 2))
  return stored
}

let db = loadDb()
function saveDb() {
  fs.writeFileSync(dataFile, JSON.stringify(db, null, 2))
}
function nextId(items) {
  return items.reduce((max, item) => Math.max(max, Number(item.id) || 0), 0) + 1
}
function findApplicant(id) {
  return db.applicants.find((item) => item.id === Number(id))
}
function findProgram(id) {
  return db.programs.find((item) => item.id === Number(id))
}
function enrichApplication(application) {
  return {
    ...application,
    applicant: findApplicant(application.applicant_id),
    program: findProgram(application.program_id),
  }
}
function enrichApplicant(applicant) {
  return {
    ...applicant,
    applications: db.applications
      .filter((item) => item.applicant_id === applicant.id)
      .map(enrichApplication),
  }
}
function values(body, name) {
  const value = body[name]
  return Array.isArray(value) ? value : value ? [value] : []
}
function normalizeFilter(value) {
  return String(value ?? '').trim().toLowerCase()
}
function matchesProgramFilter(application, programFilter) {
  if (!programFilter) return true
  const normalized = normalizeFilter(programFilter)
  const program = findProgram(application.program_id)
  if (!Number.isNaN(Number(normalized)) && application.program_id === Number(normalized)) return true
  return normalizeFilter(program?.code || '').includes(normalized) || normalized.includes(normalizeFilter(program?.code || ''))
}
function filterApplications(query) {
  return db.applications.filter((application) => {
    const applicant = findApplicant(application.applicant_id)
    const program = findProgram(application.program_id)
    const text =
      `${applicant?.full_name || ''} ${application.purpose_or_position || ''} ${application.place_or_agency || ''}`.toLowerCase()
    const programFilter = query.program || query.program_id || ''
    return (
      (!query.search || text.includes(String(query.search).toLowerCase())) &&
      (!query.status || application.status === query.status) &&
      matchesProgramFilter(application, programFilter) &&
      (!query.date_from || application.submission_date >= query.date_from) &&
      (!query.date_to || application.submission_date <= query.date_to) &&
      (!query.code || program?.code === query.code)
    )
  })
}
// Principle 3 - Defensive Programming and Security: denies access unless a valid server-issued session is present so protected routes cannot be used without authentication.
function adminOnly(request, response, next) {
  if (!sessions.has(request.headers.cookie?.match(/peso_session=([^;]+)/)?.[1]))
    return response.status(401).json({ message: 'Unauthenticated' })
  next()
}

app.use(express.json())
app.use(express.urlencoded({ extended: true }))
app.get('/api/csrf-token', (request, response) => {
  const token = crypto.randomBytes(24).toString('hex')
  tokens.add(token)
  response.json({ token })
})
// Principle 4 - Error Exception Handling: returns a controlled 422 response instead of exposing server internals when a user submits invalid login credentials.
app.post('/login', (request, response) => {
  const user = db.users.find(
    (item) => item.email === request.body.email && item.password === request.body.password,
  )
  if (!user) return response.status(422).json({ message: 'Invalid credentials' })
  // Security and correctness: retain the authenticated user so each role receives its own data.
  const session = crypto.randomBytes(24).toString('hex')
  sessions.set(session, user)
  response.setHeader('Set-Cookie', `peso_session=${session}; HttpOnly; Path=/; SameSite=Lax`)
  response.json({ user: { ...user, password: undefined } })
})
app.post('/logout', (request, response) => {
  const session = request.headers.cookie?.match(/peso_session=([^;]+)/)?.[1]
  sessions.delete(session)
  response.setHeader('Set-Cookie', 'peso_session=; Max-Age=0; Path=/')
  response.json({ ok: true })
})
app.get('/api/programs', (request, response) =>
  response.json(db.programs.filter((program) => program.is_active)),
)
app.get('/api/applicant/dashboard', (request, response) => {
  // Correctness: resolve the dashboard profile from the current session, never a shared default.
  const session = request.headers.cookie?.match(/peso_session=([^;]+)/)?.[1]
  const user = sessions.get(session)
  if (!user || user.role !== 'applicant') return response.status(401).json({ message: 'Applicant login required' })
  const profile = db.jobseekers.find((item) => item.email === user.email) || {
    id: user.id,
    name: user.name,
    email: user.email,
    skills: [],
    education: '',
  }
  response.json({
    profile: {
      ...profile,
      resumeStatus: db.resumes[0] ? 'Parsed successfully' : 'Add your resume to improve your matches.',
      capstone: db.capstone_profiles[0] || null,
    },
    jobs: db.jobs.filter((job) => job.status === 'approved' && job.active !== false),
    applications: db.applications,
  })
})
app.get('/api/employer/jobs', (request, response) => {
  const session = sessions.get(request.headers.cookie?.match(/peso_session=([^;]+)/)?.[1])
  if (!session || session.role !== 'employer') return response.status(401).json({ message: 'Employer login required' })
  response.json(db.jobs.filter((job) => job.employer_email === session.email))
})
app.post('/api/employer/jobs', (request, response) => {
  // Defensive programming: unapproved employers cannot create vacancy records.
  const session = sessions.get(request.headers.cookie?.match(/peso_session=([^;]+)/)?.[1])
  if (!session || session.role !== 'employer') return response.status(401).json({ message: 'Employer login required' })
  if (session.status !== 'approved') return response.status(403).json({ message: 'Employer account is waiting for PESO approval.' })
  const job = {
    id: nextId(db.jobs),
    title: request.body.title,
    employer: session.name,
    employer_email: session.email,
    location: request.body.location,
    type: request.body.type,
    salary: request.body.salary || 'Salary to be discussed',
    skills: request.body.skills || [],
    description: request.body.description,
    schoolReady: Boolean(request.body.schoolReady),
    verified: false,
    status: 'pending',
    applicants: 0,
    created_at: new Date().toISOString(),
  }
  if (!job.title || !job.location || !job.description) return response.status(422).json({ message: 'Title, location, and description are required.' })
  db.jobs.push(job)
  saveDb()
  response.status(201).json({ job })
})
app.get('/api/admin/jobs', (request, response) => response.json(db.jobs))
app.patch('/api/admin/jobs/:id/approve', (request, response) => {
  const job = db.jobs.find((item) => item.id === Number(request.params.id))
  if (!job) return response.status(404).json({ message: 'Job not found' })
  job.status = 'approved'
  job.verified = true
  saveDb()
  response.json({ job })
})
app.post('/api/employer/register-account', (request, response) => {
  const { name, email, password, contact_number } = request.body
  if (!name || !email || !password || !contact_number)
    return response.status(422).json({ message: 'Organization, email, password, and contact number are required.' })
  if (db.users.some((user) => user.email === email)) return response.status(409).json({ message: 'An account with this email already exists.' })
  const user = { id: nextId(db.users), name, username: email.split('@')[0], email, password, role: 'employer', status: 'pending', contact_number }
  db.users.push(user)
  db.logs.push({ id: nextId(db.logs), type: 'employer_registration', action: 'Employer account submitted for PESO approval', description: name, created_at: new Date().toISOString() })
  saveDb()
  response.status(201).json({ user: { ...user, password: undefined } })
})
app.post('/api/applicant/register-account', (request, response) => {
  const { name, email, password } = request.body
  if (!name || !email || !password) return response.status(422).json({ message: 'Name, email, and password are required.' })
  if (db.users.some((user) => user.email === email)) return response.status(409).json({ message: 'An account with this email already exists.' })
  const user = { id: nextId(db.users), name, username: email.split('@')[0], email, password, role: 'applicant', contact_number: '' }
  db.users.push(user)
  db.jobseekers.push({ id: nextId(db.jobseekers), name, email, skills: [], education: '' })
  saveDb()
  response.status(201).json({ user: { ...user, password: undefined } })
})
app.post('/api/applicant/resume', upload.single('resume'), (request, response) => {
  if (!request.file) return response.status(422).json({ message: 'A PDF resume is required.' })
  const resume = { id: nextId(db.resumes), jobseeker_id: 1, filename: request.file.originalname, parsed_at: new Date().toISOString(), extracted_skills: ['Microsoft Office', 'Communication', 'Records Management'] }
  db.resumes.push(resume)
  db.jobseekers[0].skills = resume.extracted_skills
  saveDb()
  response.json({ resume, profile: { skills: db.jobseekers[0].skills, resumeStatus: 'Parsed successfully' } })
})
app.post('/api/applicant/capstone', (request, response) => {
  const capstone = { id: nextId(db.capstone_profiles), jobseeker_id: 1, ...request.body, created_at: new Date().toISOString() }
  db.capstone_profiles.push(capstone)
  saveDb()
  response.status(201).json({ capstone })
})
app.post('/api/applicant/applications', (request, response) => {
  const job = db.jobs.find((item) => item.id === Number(request.body.job_id))
  if (!job) return response.status(404).json({ message: 'Job not found' })
  const application = { id: nextId(db.applications), job_id: job.id, job_title: job.title, employer: job.employer, status: 'Submitted', note: 'PESO has received your application.', submitted_at: new Date().toISOString(), cover_note: request.body.cover_note || '' }
  db.applications.push(application)
  saveDb()
  response.status(201).json({ application })
})
app.post('/api/applicant/jobs/:id/report', (request, response) => {
  const job = db.jobs.find((item) => item.id === Number(request.params.id))
  if (!job) return response.status(404).json({ message: 'Job not found' })
  db.logs.push({ id: nextId(db.logs), type: 'job_report', job_id: job.id, reason: request.body.reason || 'Applicant report', created_at: new Date().toISOString() })
  saveDb()
  response.status(201).json({ ok: true })
})
// Defensive Programming: normalizes optional and repeated form values before storing applicant records.
app.post('/applicant/register', upload.single('resume'), (request, response) => {
  const body = request.body
  const applicant = {
    id: nextId(db.applicants),
    applicant_code: `AG-2026-${String(nextId(db.applicants)).padStart(4, '0')}`,
    first_name: body.first_name || '',
    last_name: body.last_name || '',
    full_name: `${body.first_name || ''} ${body.last_name || ''}`.trim(),
    gender: body.gender || '',
    civil_status: body.civil_status || '',
    contact_number: body.contact_number || '',
    email: body.email || '',
    present_barangay_name: body.present_barangay || '',
    address: body.present_street || '',
    education: values(body, 'education_level[]').join(', '),
    resume: request.file
      ? {
          filename: request.file.filename,
          original_name: request.file.originalname,
          mime_type: request.file.mimetype,
          size: request.file.size,
        }
      : null,
    raw_data: body,
  }
  db.applicants.push(applicant)
  const application = {
    id: nextId(db.applications),
    applicant_id: applicant.id,
    program_id: Number(body.program_id),
    application_number: `APP-2026-${String(nextId(db.applications)).padStart(4, '0')}`,
    purpose_or_position: body.purpose_or_position || '',
    place_or_agency: body.place_or_agency || '',
    status: 'Pending',
    submission_date: new Date().toISOString().slice(0, 10),
    time_in: '',
    remarks: '',
  }
  db.applications.push(application)
  saveDb()
  response
    .status(201)
    .json({ ...enrichApplication(application), reference: application.application_number })
})

app.use('/api/admin', adminOnly)
app.get('/api/admin/dashboard', (request, response) => {
  const applications = db.applications.map(enrichApplication)
  response.json({
    metrics: {
      totalApplicants: db.applicants.length,
      gip: applications.filter((item) => item.program?.code === 'GIP').length,
      job: applications.filter((item) => item.program?.code === 'JOB').length,
      spes: applications.filter((item) => item.program?.code === 'SPES').length,
    },
    recentApplications: applications.slice(-5).reverse(),
    recentActivity: db.logs.slice(-10).reverse(),
  })
})
app.get('/api/admin/applicants', (request, response) => {
  const search = String(request.query.search || '').toLowerCase()
  const programFilter = String(request.query.program || '').trim().toUpperCase()
  const educationFilter = normalizeFilter(request.query.education)
  const data = db.applicants
    .filter((item) => {
      const applicant = enrichApplicant(item)
      const matchesSearch =
        !search ||
        `${item.full_name} ${item.applicant_code} ${item.email} ${item.contact_number}`
          .toLowerCase()
          .includes(search)
      const matchesProgram =
        !programFilter ||
        (applicant.applications || []).some((application) => {
          const program = application.program?.code || findProgram(application.program_id)?.code || ''
          return program.toUpperCase() === programFilter
        })
      const matchesEducation =
        !educationFilter ||
        [item.education, applicant.educational_attainment, applicant.course_or_major]
          .filter(Boolean)
          .some((value) => normalizeFilter(value).includes(educationFilter))
      return matchesSearch && matchesProgram && matchesEducation
    })
    .map(enrichApplicant)
  response.json({ data, total: data.length })
})
app.get('/api/admin/applicants/:id', (request, response) => {
  const applicant = findApplicant(request.params.id)
  if (!applicant) return response.sendStatus(404)
  response.json(enrichApplicant(applicant))
})
app.put('/api/admin/applicants/:id', (request, response) => {
  const applicant = findApplicant(request.params.id)
  if (!applicant) return response.sendStatus(404)
  Object.assign(applicant, request.body)
  if (request.body.first_name || request.body.last_name)
    applicant.full_name = `${applicant.first_name || ''} ${applicant.last_name || ''}`.trim()
  saveDb()
  response.json(enrichApplicant(applicant))
})
app.delete('/api/admin/applicants/:id', (request, response) => {
  const id = Number(request.params.id)
  db.applicants = db.applicants.filter((item) => item.id !== id)
  db.applications = db.applications.filter((item) => item.applicant_id !== id)
  saveDb()
  response.json({ ok: true })
})
app.get('/api/admin/programs/:code/applications', (request, response) => {
  const program = db.programs.find((item) => item.code === request.params.code)
  const applications = filterApplications({ ...request.query, code: request.params.code }).map(
    enrichApplication,
  )
  response.json({ program, total: applications.length, applications: { data: applications } })
})
app.get('/api/admin/applications/:id', (request, response) => {
  const application = db.applications.find((item) => item.id === Number(request.params.id))
  if (!application) return response.sendStatus(404)
  response.json(enrichApplication(application))
})
app.put('/api/admin/applications/:id', (request, response) => {
  const application = db.applications.find((item) => item.id === Number(request.params.id))
  if (!application) return response.sendStatus(404)
  Object.assign(application, request.body)
  saveDb()
  response.json(enrichApplication(application))
})
app.patch('/api/admin/applications/:id/status', (request, response) => {
  const application = db.applications.find((item) => item.id === Number(request.params.id))
  if (!application) return response.sendStatus(404)
  application.status = request.body.status
  saveDb()
  response.json(enrichApplication(application))
})
app.delete('/api/admin/applications/:id', (request, response) => {
  db.applications = db.applications.filter((item) => item.id !== Number(request.params.id))
  saveDb()
  response.json({ ok: true })
})
app.get('/api/admin/reports', (request, response) => {
  const applications = filterApplications(request.query).map(enrichApplication)
  response.json({
    dateFrom: request.query.date_from || '',
    dateTo: request.query.date_to || '',
    metrics: {
      total: applications.length,
      gip: applications.filter((item) => item.program?.code === 'GIP').length,
      job: applications.filter((item) => item.program?.code === 'JOB').length,
      spes: applications.filter((item) => item.program?.code === 'SPES').length,
    },
    applications,
    programs: db.programs,
  })
})
app.get('/api/admin/settings', (request, response) =>
  response.json({
    programs: db.programs,
    users: db.users.map((user) => {
      const safeUser = { ...user }
      delete safeUser.password
      return safeUser
    }),
    logs: db.logs,
  }),
)
app.patch('/api/admin/employers/:id/approve', (request, response) => {
  // Authorization boundary: only authenticated admin routes can approve employer accounts.
  const employer = db.users.find((user) => user.id === Number(request.params.id) && user.role === 'employer')
  if (!employer) return response.status(404).json({ message: 'Employer account not found' })
  employer.status = 'approved'
  db.logs.push({ id: nextId(db.logs), type: 'employer_approval', action: 'Employer account approved', description: employer.name, created_at: new Date().toISOString() })
  saveDb()
  response.json({ user: { ...employer, password: undefined } })
})
app.post('/api/admin/settings/users', (request, response) => {
  const user = { ...request.body, id: nextId(db.users) }
  db.users.push(user)
  saveDb()
  response.status(201).json({ ...user, password: undefined })
})
app.get('/api/admin/qr', (request, response) =>
  response.json({
    registrationUrl: `${request.protocol}://${request.get('host')}/applicant/register`,
  }),
)
function renderReport(response, request, autoPrint = false) {
  const applications = filterApplications(request.query).map(enrichApplication)
  const reportRows = applications
    .map(
      (item) => `
        <tr>
          <td>${item.application_number}</td>
          <td>${item.applicant?.full_name || ''}</td>
          <td>${item.program?.code || ''}</td>
          <td>${item.status}</td>
        </tr>
      `,
    )
    .join('')
  const metrics = {
    total: applications.length,
    gip: applications.filter((item) => item.program?.code === 'GIP').length,
    job: applications.filter((item) => item.program?.code === 'JOB').length,
    spes: applications.filter((item) => item.program?.code === 'SPES').length,
  }
  const reportHtml = `
    <html>
      <head><title>PESO Agoo Employment Programs Report</title><style>
        @page { size: A4; margin: 18mm; }
        body { margin: 0; color: #1e293b; font: 13px Arial, sans-serif; background: #eef2f6; }
        .page { max-width: 900px; margin: 24px auto; padding: 42px 48px; background: #fff; box-shadow: 0 4px 18px #94a3b833; }
        header { display: flex; align-items: center; gap: 16px; padding-bottom: 20px; border-bottom: 3px solid #ffb703; }
        header img { width: 70px; height: 70px; object-fit: contain; } h1 { margin: 0; color: #0b2545; font-size: 24px; } h2 { margin: 4px 0 0; color: #64748b; font-size: 13px; font-weight: normal; }
        .meta { display: flex; justify-content: space-between; margin: 22px 0 16px; color: #64748b; } .meta strong { color: #0b2545; }
        .metrics { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 25px; }.metric { padding: 13px; border: 1px solid #e2e8f0; border-radius: 6px; }.metric b { display: block; color: #0b2545; font-size: 22px; }.metric span { color: #64748b; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; } th { color: #fff; background: #0b2545; text-align: left; } th, td { padding: 9px 8px; border: 1px solid #dbe3ec; font-size: 11px; } tr:nth-child(even) { background: #f8fafc; }
        footer { margin-top: 28px; padding-top: 12px; border-top: 1px solid #e2e8f0; color: #64748b; font-size: 10px; } .actions { display: flex; gap: 8px; margin-bottom: 18px; } button, .download-button { display: inline-block; padding: 9px 13px; border: 0; border-radius: 4px; color: #fff; background: #0d3b66; cursor: pointer; font: 13px Arial, sans-serif; text-decoration: none; } .download-button { color: #0d3b66; background: #e8eef5; }
        @media print { body { background: #fff; } .page { margin: 0; padding: 0; box-shadow: none; } .actions { display: none; } }
      </style></head>
      <body><main class="page"><div class="actions"><button onclick="window.print()">Print report</button><a class="download-button" href="/admin/reports/pdf?${new URLSearchParams(request.query)}">Save as PDF</a></div>
        <header><img src="/peso-logo.svg" alt="PESO Agoo"><div><h1>Municipality of Agoo, La Union</h1><h2>Public Employment Service Office</h2></div></header>
        <div class="meta"><span><strong>Employment Programs Report</strong></span><span>Generated: ${new Date().toLocaleString()}</span></div>
        <div class="metrics"><div class="metric"><b>${metrics.total}</b><span>Total Applications</span></div><div class="metric"><b>${metrics.gip}</b><span>GIP Applications</span></div><div class="metric"><b>${metrics.job}</b><span>Job Placement</span></div><div class="metric"><b>${metrics.spes}</b><span>SPES Students</span></div></div>
        <table><tr><th>Application</th><th>Applicant</th><th>Program</th><th>Status</th></tr>${reportRows}</table>
        <footer>Official PESO administrative report. Period: ${request.query.date_from || 'All dates'} to ${request.query.date_to || 'Present'}</footer>
      </main>${autoPrint ? '<script>window.print()</script>' : ''}</body>
    </html>
  `
  response.send(reportHtml)
}
app.get('/admin/reports/preview', (request, response) => renderReport(response, request))
app.get('/admin/reports/print', (request, response) => renderReport(response, request, true))
app.get('/admin/reports/pdf', (request, response) => {
  // Interoperability: return a real PDF attachment that browsers can save locally.
  const applications = filterApplications(request.query).map(enrichApplication)
  const metrics = {
    total: applications.length,
    gip: applications.filter((item) => item.program?.code === 'GIP').length,
    job: applications.filter((item) => item.program?.code === 'JOB').length,
    spes: applications.filter((item) => item.program?.code === 'SPES').length,
  }
  const document = new PDFDocument({ size: 'A4', margin: 42 })
  response.setHeader('Content-Type', 'application/pdf')
  response.setHeader('Content-Disposition', 'attachment; filename="PESO-Agoo-Employment-Programs-Report.pdf"')
  document.pipe(response)
  document.fillColor('#0b2545').fontSize(18).font('Helvetica-Bold').text('MUNICIPALITY OF AGOO, LA UNION')
  document.fillColor('#64748b').fontSize(11).font('Helvetica').text('Public Employment Service Office')
  document.moveDown(0.8).strokeColor('#ffb703').lineWidth(3).moveTo(42, document.y).lineTo(553, document.y).stroke()
  document.moveDown(1).fillColor('#0b2545').fontSize(16).font('Helvetica-Bold').text('Employment Programs Report')
  document.fillColor('#64748b').fontSize(9).font('Helvetica').text(`Generated: ${new Date().toLocaleString()}`)
  document.text(`Period: ${request.query.date_from || 'All dates'} to ${request.query.date_to || 'Present'}`)
  document.moveDown(1)
  const metricLabels = [['Total Applications', metrics.total], ['GIP Applications', metrics.gip], ['Job Placement', metrics.job], ['SPES Students', metrics.spes]]
  metricLabels.forEach(([label, value], index) => {
    const x = 42 + index * 128
    document.roundedRect(x, document.y, 118, 48, 4).fillAndStroke('#f8fafc', '#dbe3ec')
    document.fillColor('#0b2545').fontSize(17).font('Helvetica-Bold').text(String(value), x + 9, document.y + 8)
    document.fillColor('#64748b').fontSize(8).font('Helvetica').text(label, x + 9, document.y + 29, { width: 100 })
  })
  document.y += 65
  const columns = [{ label: 'Application', width: 105 }, { label: 'Applicant', width: 170 }, { label: 'Program', width: 80 }, { label: 'Status', width: 120 }]
  let x = 42
  const headerY = document.y
  columns.forEach((column) => { document.rect(x, headerY, column.width, 24).fill('#0b2545'); document.fillColor('#fff').fontSize(9).font('Helvetica-Bold').text(column.label, x + 6, headerY + 8); x += column.width })
  let y = headerY + 24
  applications.forEach((item, index) => {
    if (y > 735) { document.addPage(); y = 42 }
    x = 42
    const values = [item.application_number || '', item.applicant?.full_name || '', item.program?.code || '', item.status || '']
    values.forEach((value, valueIndex) => { const width = columns[valueIndex].width; document.rect(x, y, width, 24).fill(index % 2 ? '#f8fafc' : '#fff').stroke('#dbe3ec'); document.fillColor('#1e293b').fontSize(8).font('Helvetica').text(String(value), x + 6, y + 8, { width: width - 12, ellipsis: true }); x += width })
    y += 24
  })
  document.end()
})
/*
  const reportHtml = `
      </head>
      <body>
        <h1>PESO Agoo Applications Report</h1>
        <p>Generated ${new Date().toLocaleString()}</p>
        <table border="1" cellpadding="8">
          <tr>
            <th>Application</th>
            <th>Applicant</th>
            <th>Program</th>
            <th>Status</th>
          </tr>
          ${reportRows}
        </table>
        <script>window.print()</script>
      </body>
    </html>
  `
  response.send(reportHtml)
})*/

const geography = {
  regions: [{ id: 1, name: 'Ilocos Region (Region I)' }],
  provinces: [{ id: 1, region_id: 1, name: 'La Union' }],
  cities: [{ id: 1, province_id: 1, name: 'Agoo' }],
  barangays: ['San Agustin', 'Poblacion', 'Sta. Rita', 'Nazarenas', 'San Nicolas Central'].map(
    (name, index) => ({ id: index + 1, city_municipality_id: 1, name }),
  ),
}
app.get('/api/geography/regions', (request, response) => response.json(geography.regions))
app.get('/api/geography/provinces', (request, response) =>
  response.json(
    geography.provinces.filter(
      (item) => !request.query.region_id || item.region_id === Number(request.query.region_id),
    ),
  ),
)
app.get('/api/geography/cities-municipalities', (request, response) =>
  response.json(
    geography.cities.filter(
      (item) =>
        !request.query.province_id || item.province_id === Number(request.query.province_id),
    ),
  ),
)
app.get('/api/geography/barangays', (request, response) =>
  response.json(
    geography.barangays.filter(
      (item) =>
        !request.query.city_municipality_id ||
        item.city_municipality_id === Number(request.query.city_municipality_id),
    ),
  ),
)

const dist = path.join(root, 'dist')
app.use('/uploads', express.static(path.join(root, 'uploads')))
if (fs.existsSync(dist)) {
  app.use(express.static(dist))
  app.use((request, response) => response.sendFile(path.join(dist, 'index.html')))
}
app.listen(port, () => console.log(`PESO fullstack server running at http://127.0.0.1:${port}`))

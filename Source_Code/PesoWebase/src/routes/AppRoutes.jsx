export function getInitialRoute(pathname) {
  if (!pathname || pathname === '/') return 'login'
  if (pathname === '/employer' || pathname === '/employer/') return 'employer-dashboard'
  if (pathname === '/employer/jobs') return 'employer-jobs'
  if (pathname === '/employer/jobs/new') return 'employer-jobs-new'
  if (pathname === '/employer/candidates') return 'employer-candidates'
  if (pathname === '/employer/verification') return 'employer-verification'
  if (pathname === '/login') return 'login'
  if (pathname === '/employer/account') return 'employer-account'
  if (pathname === '/applicant/register') return 'applicant-account'
  if (pathname === '/applicant/dashboard') return 'applicant-dashboard'
  if (pathname === '/applicant/account') return 'applicant-account'
  if (pathname === '/applicant/applications') return 'applicant-applications'
  const applyMatch = pathname.match(/^\/applicant\/jobs\/(\d+)\/apply/)
  if (applyMatch) return `applicant-apply-${applyMatch[1]}`
  const jobMatch = pathname.match(/^\/applicant\/jobs\/(\d+)/)
  if (jobMatch) return `applicant-job-${jobMatch[1]}`
  if (pathname.includes('/qr-code')) return 'qr'
  const applicantMatch = pathname.match(/^\/admin\/applicants\/(\d+)(\/edit)?/)
  if (applicantMatch) return `applicant-${applicantMatch[1]}${applicantMatch[2] ? '-edit' : ''}`
  const applicationMatch = pathname.match(/^\/admin\/applications\/(\d+)(\/edit)?/)
  if (applicationMatch)
    return `application-${applicationMatch[1]}${applicationMatch[2] ? '-edit' : ''}`
  if (pathname === '/admin/gip') return 'gip'
  if (pathname === '/admin/job') return 'job'
  if (pathname === '/admin/spes') return 'spes'
  if (pathname.startsWith('/admin/applicants')) return 'applicants'
  if (pathname.startsWith('/admin/vacancies')) return 'vacancies'
  if (pathname.startsWith('/admin/reports')) return 'reports'
  if (pathname.startsWith('/admin/settings')) return 'settings'
  if (pathname.startsWith('/admin')) return 'dashboard'
  return 'register'
}

export function getRoutePath(page) {
  const paths = {
    login: '/login',
    'employer-account': '/employer/account',
    register: '/applicant/account',
    'applicant-dashboard': '/applicant/dashboard',
    'applicant-account': '/applicant/account',
    'applicant-applications': '/applicant/applications',
    dashboard: '/admin/dashboard',
    applicants: '/admin/applicants',
    vacancies: '/admin/vacancies',
    gip: '/admin/gip',
    job: '/admin/job',
    spes: '/admin/spes',
    reports: '/admin/reports',
    qr: '/admin/qr-code',
    settings: '/admin/settings',
    'employer-dashboard': '/employer',
    'employer-jobs': '/employer/jobs',
    'employer-jobs-new': '/employer/jobs/new',
    'employer-candidates': '/employer/candidates',
    'employer-verification': '/employer/verification',
  }
  if (paths[page]) return paths[page]
  const apply = page.match(/^applicant-apply-(\d+)$/)
  if (apply) return `/applicant/jobs/${apply[1]}/apply`
  const applicantJob = page.match(/^applicant-job-(\d+)$/)
  if (applicantJob) return `/applicant/jobs/${applicantJob[1]}`
  const applicant = page.match(/^applicant-(\d+)(-edit)?$/)
  if (applicant) return `/admin/applicants/${applicant[1]}${applicant[2] ? '/edit' : ''}`
  const application = page.match(/^application-(\d+)(-edit)?$/)
  if (application) return `/admin/applications/${application[1]}${application[2] ? '/edit' : ''}`
  return '/admin/dashboard'
}

export function getAdminPageContent(page) {
  return (
    {
      dashboard: 'Dashboard',
      applicants: 'Applicants',
      gip: 'GIP Applications',
      job: 'Job Applications',
      spes: 'SPES Applications',
      reports: 'Reports',
      qr: 'Municipal QR Poster',
      settings: 'Settings',
    }[page] || 'Dashboard'
  )
}

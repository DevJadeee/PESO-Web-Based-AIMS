import { useEffect, useState } from 'react'
import LoginPage from './pages/auth/Login'
import AdminLayoutView from './layouts/AdminLayout'
import { getInitialRoute, getRoutePath } from './routes/AppRoutes'
import { useAuth } from './hooks/useAuth'
import DashboardPage from './pages/admin/Dashboard'
import ApplicantsPage from './pages/admin/Applicants'
import JobVacanciesPage from './pages/admin/JobVacancies'
import ReportsPage from './pages/admin/Reports'
import SettingsPage from './pages/admin/Settings'
import QRPosterPage from './pages/admin/QRPoster'
import ProgramApplicationsPage from './pages/admin/ProgramApplications'
import ApplicantProfilePage from './pages/admin/ApplicantProfile'
import ApplicationProfilePage from './pages/admin/ApplicationProfile'
import EmployerLayout from './layouts/EmployerLayout'
import EmployerDashboardPage from './pages/employer/EmployerDashboard'
import EmployerJobsPage from './pages/employer/EmployerJobs'
import EmployerCandidatesPage from './pages/employer/EmployerCandidates'
import EmployerVerificationPage from './pages/employer/EmployerVerification'
import ApplicantDashboardPage from './pages/applicant/ApplicantDashboard'
import ApplicantAccountPage from './pages/applicant/ApplicantAccount'
import EmployerAccountPage from './pages/employer/EmployerAccount'
import './App.css'

function App() {
  const { authenticated, login, logout } = useAuth()
  const [page, setPage] = useState(() => getInitialRoute(window.location.pathname))
  const navigate = (nextPage) => {
    window.history.pushState({}, '', getRoutePath(nextPage))
    setPage(nextPage)
  }
  useEffect(() => {
    const handlePopState = () => setPage(getInitialRoute(window.location.pathname))
    window.addEventListener('popstate', handlePopState)
    return () => window.removeEventListener('popstate', handlePopState)
  }, [])
  const employerPage = page.startsWith('employer-')
  const handleLogin = (user) => {
    if (user?.role === 'employer') {
      sessionStorage.setItem('obrakonek-employer', 'true')
      sessionStorage.setItem('obrakonek-employer-status', user.status || 'approved')
      navigate('employer-dashboard')
      return
    }
    if (user?.role === 'applicant') {
      sessionStorage.setItem('peso-applicant', 'true')
      navigate('applicant-dashboard')
      return
    }
    login()
    navigate('dashboard')
  }
  if (employerPage && sessionStorage.getItem('obrakonek-employer') !== 'true')
    return <LoginPage onLogin={handleLogin} />
  if (employerPage)
    return (
      <EmployerLayout
        page={page}
        setPage={navigate}
        onLogout={() => {
          sessionStorage.removeItem('obrakonek-employer')
          sessionStorage.removeItem('obrakonek-employer-status')
          navigate('login')
        }}
        approved={sessionStorage.getItem('obrakonek-employer-status') !== 'pending'}
      >
        {page === 'employer-dashboard' ? <EmployerDashboardPage setPage={navigate} /> : null}
        {page === 'employer-jobs' || page === 'employer-jobs-new' ? (
          <EmployerJobsPage newJob={page === 'employer-jobs-new'} setPage={navigate} />
        ) : null}
        {page === 'employer-candidates' ? <EmployerCandidatesPage /> : null}
        {page === 'employer-verification' ? <EmployerVerificationPage /> : null}
      </EmployerLayout>
    )
  if (page === 'login')
    return <LoginPage onLogin={handleLogin} />
  if (page === 'employer-account') return <EmployerAccountPage onLogin={() => navigate('login')} />
  if (page === 'register') return <ApplicantAccountPage onLogin={() => navigate('login')} />
  if (page === 'applicant-account') return <ApplicantAccountPage onLogin={() => navigate('login')} />
  const applicantPage = page === 'applicant-dashboard' || page === 'applicant-applications' || page.startsWith('applicant-job-') || page.startsWith('applicant-apply-')
  if (applicantPage && sessionStorage.getItem('peso-applicant') !== 'true') return <LoginPage onLogin={handleLogin} />
  if (page === 'applicant-dashboard')
    return <ApplicantDashboardPage onNavigate={navigate} />
  if (page === 'applicant-applications')
    return <ApplicantDashboardPage mode="applications" onNavigate={navigate} />
  const applicantJob = page.match(/^applicant-job-(\d+)$/)
  if (applicantJob)
    return <ApplicantDashboardPage mode="job" jobId={applicantJob[1]} onNavigate={navigate} />
  const applicantApply = page.match(/^applicant-apply-(\d+)$/)
  if (applicantApply)
    return <ApplicantDashboardPage mode="apply" jobId={applicantApply[1]} onNavigate={navigate} />
  if (!authenticated)
    return <LoginPage onLogin={handleLogin} />
  const applicantRoute = page.match(/^applicant-(\d+)(-edit)?$/)
  const applicationRoute = page.match(/^application-(\d+)(-edit)?$/)
  const content = applicantRoute ? (
    <ApplicantProfilePage id={applicantRoute[1]} edit={Boolean(applicantRoute[2])} />
  ) : applicationRoute ? (
    <ApplicationProfilePage id={applicationRoute[1]} edit={Boolean(applicationRoute[2])} />
  ) : page === 'dashboard' ? (
    <DashboardPage setPage={setPage} />
  ) : page === 'vacancies' ? (
    <JobVacanciesPage />
  ) : page === 'reports' ? (
    <ReportsPage />
  ) : page === 'settings' ? (
    <SettingsPage />
  ) : page === 'qr' ? (
    <QRPosterPage />
  ) : ['gip', 'job', 'spes'].includes(page) ? (
    <ProgramApplicationsPage code={page.toUpperCase()} />
  ) : (
    <ApplicantsPage />
  )
  return (
    <AdminLayoutView
      page={page}
      setPage={navigate}
      onLogout={() => {
        logout()
        navigate('login')
      }}
    >
      {content}
    </AdminLayoutView>
  )
}

export default App

import Sidebar from '../components/navigation/Sidebar'

const titles = {
  dashboard: [
    'Operational Overview',
    'Municipal Public Employment Service Office - Agoo, La Union',
  ],
  applicants: [
    'Central Applicant Directory',
    'Municipal Public Employment Service Office - Agoo, La Union',
  ],
  vacancies: ['Job Vacancies', 'Employer vacancy postings and PESO review queue'],
  gip: ['GIP Applications', 'Municipal Public Employment Service Office - Agoo, La Union'],
  job: ['Job Applications', 'Municipal Public Employment Service Office - Agoo, La Union'],
  spes: ['SPES Applications', 'Municipal Public Employment Service Office - Agoo, La Union'],
  reports: ['Official Reports', 'Municipal Public Employment Service Office - Agoo, La Union'],
  qr: ['Municipal QR Poster', 'Municipal Public Employment Service Office - Agoo, La Union'],
  settings: ['System Settings', 'Municipal Public Employment Service Office - Agoo, La Union'],
}

export default function AdminLayout({ page, setPage, onLogout, children }) {
  const title = titles[page] || titles.dashboard
  return (
    <div className="admin-wrapper">
      <Sidebar page={page} setPage={setPage} onLogout={onLogout} />
      <div className="main-content">
        <header className="top-header">
          <div>
            <h2>{title[0]}</h2>
            <p>{title[1]}</p>
          </div>
          <div className="header-right">
            <div className="search-top">
              ⌕ <input placeholder="Search applicants..." />
            </div>
            <div className="profile">
              <span>AD</span>
              <div>
                <strong>Administrator</strong>
                <small>Super Admin</small>
              </div>
            </div>
          </div>
        </header>
        <main className="admin-body">{children}</main>
      </div>
    </div>
  )
}

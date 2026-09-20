export default function ApplicantLayout({ children, active = 'dashboard', onNavigate }) {
  return (
    <div className="public-page">
      <div className="public-card">
        <header className="public-header">
          <div className="public-logo">
            <img src="/peso-logo.svg" alt="PESO Logo" />
          </div>
          <div>
            <h1>MUNICIPALITY OF AGOO, LA UNION</h1>
            <p>Public Employment Service Office (PESO)</p>
          </div>
          {onNavigate && (
            <nav className="applicant-nav" aria-label="Applicant navigation">
              <button className={active === 'dashboard' ? 'active' : ''} onClick={() => onNavigate('applicant-dashboard')}>Find work</button>
              <button className={active === 'applications' ? 'active' : ''} onClick={() => onNavigate('applicant-applications')}>My applications</button>
              <button onClick={() => onNavigate('register')}>Profile</button>
              <select aria-label="Language"><option>English</option><option>Filipino</option><option>Ilokano</option></select>
            </nav>
          )}
        </header>
        <main className="public-body">{children}</main>
      </div>
      <footer>
        © 2026 Public Employment Service Office - Agoo, La Union. All rights reserved.
      </footer>
    </div>
  )
}

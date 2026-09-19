const navigation = [
  ['employer-dashboard', 'Overview', '⌂'],
  ['employer-jobs', 'Job vacancies', '▣'],
  ['employer-candidates', 'Candidates', '♙'],
  ['employer-verification', 'Verification', '✓'],
]

export default function EmployerLayout({ page, setPage, onLogout, children, approved = true }) {
  return (
    <div className="employer-shell">
      <aside className="employer-sidebar">
        <div className="employer-brand">
          <div className="employer-brand-mark">E</div>
          <div>
            <strong>Employer</strong>
            <small>CONSOLE</small>
          </div>
        </div>
        <div className="employer-sidebar-label">Workspace</div>
        <nav className="employer-nav">
          {navigation.map(([id, label, icon]) => (
            <button key={id} className={page === id ? 'active' : ''} onClick={() => setPage(id)}>
              <span>{icon}</span>{label}
            </button>
          ))}
        </nav>
        <div className="employer-sidebar-note">
          <strong>No-Ghosting Pledge</strong>
          <span>Respond to every applicant within 7 days.</span>
        </div>
        <button className="employer-signout" onClick={onLogout}>↪ Sign out</button>
      </aside>
      <div className="employer-main">
        <header className="employer-header">
          <div>
            <span className="employer-eyebrow">Employer workspace</span>
            <h1>{navigation.find(([id]) => id === page)?.[1] || 'Overview'}</h1>
          </div>
          <div className="employer-header-actions">
            <select aria-label="Language">
              <option>English</option>
              <option>Filipino</option>
              <option>Ilokano</option>
            </select>
            <button className="employer-avatar" aria-label="Open employer profile">AC</button>
          </div>
        </header>
        <main className="employer-content">
          {!approved && <div className="form-error">Your employer account is waiting for PESO approval. You can post vacancies after an administrator approves your account.</div>}
          {children}
        </main>
      </div>
    </div>
  )
}

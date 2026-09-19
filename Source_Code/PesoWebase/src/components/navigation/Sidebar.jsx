import Icon from '../common/Icon'

export default function Sidebar({ page, setPage, onLogout }) {
  const links = [
    ['dashboard', '⌂', 'Dashboard'],
    ['applicants', '♙', 'Applicant Records'],
    ['vacancies', '▰', 'Job Vacancies'],
    ['gip', '▣', 'GIP Applications'],
    ['job', '▤', 'Job Applications'],
    ['spes', '▥', 'SPES Applications'],
    ['reports', '▥', 'Reports'],
    ['qr', '▦', 'Municipal QR Poster'],
  ]
  return (
    <aside className="sidebar">
      <div className="sidebar-brand">
        <div className="sidebar-logo">
          <img src="/peso-logo.svg" alt="" />
        </div>
        <div>
          <strong>PESO AGOO</strong>
          <small>ADMINISTRATION</small>
        </div>
      </div>
      <nav>
        {links.map(([id, icon, label]) => (
          <button key={id} className={page === id ? 'active' : ''} onClick={() => setPage(id)}>
            <Icon>{icon}</Icon>
            {label}
          </button>
        ))}
      </nav>
      <div className="sidebar-bottom">
        <button className={page === 'settings' ? 'active' : ''} onClick={() => setPage('settings')}>
          <Icon>⚙</Icon>Settings
        </button>
        <button onClick={onLogout}>
          <Icon>↪</Icon>Sign Out
        </button>
      </div>
    </aside>
  )
}

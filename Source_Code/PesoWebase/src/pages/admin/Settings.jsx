import { useEffect, useState } from 'react'
import { api } from '../../services/api'

export default function Settings() {
  const [data, setData] = useState({ programs: [], users: [], logs: [] })
  const [showUser, setShowUser] = useState(false)
  const [accountFilter, setAccountFilter] = useState('all')
  const [user, setUser] = useState({
    name: '',
    username: '',
    email: '',
    password: '',
    role: 'staff',
    contact_number: '',
  })
  const [message, setMessage] = useState('')
  const load = () =>
    api.admin
      .settings()
      .then(setData)
      .catch(() => setMessage('Unable to connect to the PESO server.'))
  useEffect(() => {
    load()
  }, [])
  const updateUser = (event) => setUser({ ...user, [event.target.name]: event.target.value })
  const createUser = async (event) => {
    event.preventDefault()
    try {
      await api.admin.createUser(user)
      setShowUser(false)
      setUser({
        name: '',
        username: '',
        email: '',
        password: '',
        role: 'staff',
        contact_number: '',
      })
      load()
    } catch {
      setMessage('Unable to create administrator account.')
    }
  }
  const approveEmployer = async (id) => {
    // Usability: expose one clear action for the admin approval decision.
    try {
      await api.admin.approveEmployer(id)
      load()
    } catch {
      setMessage('Unable to approve employer account.')
    }
  }
  const pendingEmployers = data.users.filter(
    (account) => account.role === 'employer' && account.status === 'pending',
  )
  return (
    <div className="settings-grid">
      <section className="panel form-panel">
        <div className="panel-header">
          <h3>Municipal Office Configuration</h3>
        </div>
        <label>
          Municipality Name
          <input defaultValue="Municipality of Agoo" />
        </label>
        <label>
          Province
          <input defaultValue="La Union" />
        </label>
        <label>
          Office Name
          <input defaultValue="Public Employment Service Office (PESO)" />
        </label>
        <label>
          Contact Phone
          <input defaultValue="(072) 607-1234" />
        </label>
        <label>
          Email
          <input defaultValue="peso@agoo.gov.ph" />
        </label>
        <label>
          Office Address
          <textarea defaultValue="Municipal Hall Compound, Agoo, La Union" />
        </label>
        <button className="btn primary">Save Changes</button>
      </section>
      <section className="panel">
        <div className="panel-header">
          <h3>Configured Employment Programs</h3>
        </div>
        {data.programs.map((program) => (
          <div className="setting-row" key={program.id}>
            <span className={`program-mark ${program.badge_color || 'blue'}`}>{program.code}</span>
            <div>
              <strong>{program.name}</strong>
              <small>{program.description}</small>
            </div>
            <span className={`badge ${program.is_active ? 'approved' : 'pending'}`}>
              {program.is_active ? 'Active' : 'Inactive'}
            </span>
          </div>
        ))}
      </section>
      <section className="panel employer-approval-panel">
        <div className="panel-header">
          <div>
            <h3>Employer accounts awaiting approval</h3>
            <small>Review these employer registrations before they can post vacancies.</small>
          </div>
          <span className="badge pending">{pendingEmployers.length} Pending</span>
        </div>
        {pendingEmployers.length ? pendingEmployers.map((account) => (
          <div className="employer-approval-row" key={account.id}>
            <div>
              <strong>{account.name}</strong>
              <small>{account.email} · {account.contact_number || 'No contact number'}</small>
            </div>
            <button className="btn primary" onClick={() => approveEmployer(account.id)}>
              Approve account
            </button>
          </div>
        )) : <p className="empty-report">No employer accounts are waiting for approval.</p>}
      </section>
      <section className="panel">
        <div className="panel-header">
          <h3>Accounts</h3>
          <button className="btn primary small" onClick={() => setShowUser(!showUser)}>
            ＋ Add User
          </button>
        </div>
        <label className="report-field">
          Account type
          <select value={accountFilter} onChange={(event) => setAccountFilter(event.target.value)}>
            <option value="all">All accounts</option>
            <option value="employer">Employer accounts</option>
            <option value="applicant">Applicant accounts</option>
            <option value="admin">Admin and staff accounts</option>
          </select>
        </label>
        {showUser && (
          <form className="inline-user-form" onSubmit={createUser}>
            {['name', 'username', 'email', 'password', 'contact_number'].map((field) => (
              <input
                key={field}
                name={field}
                type={field === 'password' ? 'password' : field === 'email' ? 'email' : 'text'}
                placeholder={field.replaceAll('_', ' ')}
                value={user[field]}
                onChange={updateUser}
                required={field !== 'contact_number'}
              />
            ))}
            <select name="role" value={user.role} onChange={updateUser}>
              <option value="staff">Staff</option>
              <option value="manager">Manager</option>
              <option value="super_admin">Super Admin</option>
            </select>
            <button className="btn primary">Create User</button>
          </form>
        )}
        {data.users.filter((account) => {
          if (accountFilter === 'admin') return !['employer', 'applicant'].includes(account.role)
          return accountFilter === 'all' || account.role === accountFilter
        }).map((account) => (
          <div className="setting-row" key={account.id}>
            <span className="avatar small-avatar">{account.name?.slice(0, 2).toUpperCase()}</span>
            <div>
              <strong>{account.name}</strong>
              <small>
                {account.username} • {account.email}
              </small>
            </div>
            <span className={`badge ${account.status === 'pending' ? 'pending' : 'completed'}`}>{account.status === 'pending' ? 'Pending approval' : account.role}</span>
            {account.role === 'employer' && account.status === 'pending' && <button className="btn primary small" onClick={() => approveEmployer(account.id)}>Approve employer</button>}
          </div>
        ))}
      </section>
      {message && <div className="form-error">{message}</div>}
    </div>
  )
}

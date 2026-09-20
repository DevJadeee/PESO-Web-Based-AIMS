import { demoApplicants } from '../../services/demoData'

function StatusBadge({ status }) {
  return <span className={`badge ${status.toLowerCase().replace(' ', '-')}`}>{status}</span>
}

export default function ApplicationsTable({ rows = demoApplicants, program }) {
  const filtered = program ? rows.filter((row) => row.program === program) : rows
  return (
    <div className="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Date & Time</th>
            <th>Applicant Name</th>
            <th>Program</th>
            <th>Purpose / Position</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          {filtered.map((row) => (
            <tr key={row.id}>
              <td>
                <strong>{row.date}</strong>
                <small>09:30 AM</small>
              </td>
              <td>
                <strong className="link-text">{row.name}</strong>
                <small>{row.code}</small>
              </td>
              <td>
                <span className={`program-pill ${row.program.toLowerCase()}`}>{row.program}</span>
              </td>
              <td>{row.purpose}</td>
              <td>
                <StatusBadge status={row.status} />
              </td>
              <td>
                <button
                  className="table-action"
                  onClick={() => alert(`Opening application ${row.code}`)}
                >
                  View
                </button>
                <button className="table-action">⋮</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  )
}

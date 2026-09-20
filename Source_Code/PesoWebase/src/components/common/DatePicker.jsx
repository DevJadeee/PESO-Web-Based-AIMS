import { useState } from 'react'

const monthNames = [
  'January',
  'February',
  'March',
  'April',
  'May',
  'June',
  'July',
  'August',
  'September',
  'October',
  'November',
  'December',
]
const weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']

function parseDate(value) {
  if (!value) return null
  const [year, month, day] = value.split('-').map(Number)
  return new Date(year, month - 1, day)
}

function formatDate(date) {
  return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(
    date.getDate(),
  ).padStart(2, '0')}`
}

function displayDate(value) {
  const date = parseDate(value)
  return date
    ? date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
    : 'Choose date'
}

export default function DatePicker({ name, label, value, onChange, required = false, compact = false }) {
  const selectedDate = parseDate(value)
  const [open, setOpen] = useState(false)
  const [draftValue, setDraftValue] = useState(value || '')
  const [visibleMonth, setVisibleMonth] = useState(
    () => selectedDate || new Date(),
  )
  const firstDay = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth(), 1).getDay()
  const daysInMonth = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth() + 1, 0).getDate()
  const cells = Array.from({ length: Math.ceil((firstDay + daysInMonth) / 7) * 7 }, (_, index) => {
    const day = index - firstDay + 1
    return day > 0 && day <= daysInMonth ? new Date(visibleMonth.getFullYear(), visibleMonth.getMonth(), day) : null
  })
  const moveMonth = (amount) =>
    setVisibleMonth(new Date(visibleMonth.getFullYear(), visibleMonth.getMonth() + amount, 1))
  const currentYear = new Date().getFullYear()
  const years = Array.from({ length: currentYear - 1899 }, (_, index) => currentYear + 10 - index)
  const openPicker = () => {
    setDraftValue(value || '')
    setVisibleMonth(parseDate(value) || new Date())
    setOpen(true)
  }
  const chooseDate = (date) => setDraftValue(formatDate(date))
  const confirmDate = () => {
    if (!draftValue) return
    onChange({ target: { name, value: draftValue } })
    setOpen(false)
  }
  return (
    <div className={`date-picker-field ${compact ? 'compact' : ''}`}>
      {label && <span>{label}</span>}
      <button type="button" className="date-picker-button" onClick={openPicker}>
        <span>{displayDate(value)}</span>
        <span className="date-picker-icon" aria-hidden="true">&#128197;</span>
      </button>
      <input className="date-picker-value" name={name} value={value} onChange={() => {}} required={required} tabIndex={-1} aria-hidden="true" />
      {open && (
        <div className="date-picker-backdrop" role="presentation" onMouseDown={() => setOpen(false)}>
          <div className="date-picker-dialog" role="dialog" aria-modal="true" onMouseDown={(event) => event.stopPropagation()}>
            <div className="date-picker-dialog-header">
              <span>{label || 'Choose date'}</span>
              <strong>{displayDate(draftValue)}</strong>
            </div>
            <div className="date-picker-calendar-header">
              <button type="button" onClick={() => moveMonth(-1)} aria-label="Previous month">&lt;</button>
              <div className="date-picker-month-year">
                <select
                  value={visibleMonth.getMonth()}
                  onChange={(event) =>
                    setVisibleMonth(new Date(visibleMonth.getFullYear(), Number(event.target.value), 1))
                  }
                  aria-label="Month"
                >
                  {monthNames.map((month, index) => <option value={index} key={month}>{month}</option>)}
                </select>
                <select
                  value={visibleMonth.getFullYear()}
                  onChange={(event) =>
                    setVisibleMonth(new Date(Number(event.target.value), visibleMonth.getMonth(), 1))
                  }
                  aria-label="Year"
                >
                  {years.map((year) => <option value={year} key={year}>{year}</option>)}
                </select>
              </div>
              <button type="button" onClick={() => moveMonth(1)} aria-label="Next month">&gt;</button>
            </div>
            <div className="date-picker-weekdays">
              {weekDays.map((day) => <span key={day}>{day}</span>)}
            </div>
            <div className="date-picker-days">
              {cells.map((date, index) => (
                <button
                  type="button"
                  className={date && draftValue === formatDate(date) ? 'selected' : ''}
                  key={date ? formatDate(date) : `empty-${index}`}
                  disabled={!date}
                  onClick={() => date && chooseDate(date)}
                >
                  {date?.getDate() || ''}
                </button>
              ))}
            </div>
            <div className="date-picker-actions">
              <button type="button" className="btn secondary" onClick={() => setOpen(false)}>Cancel</button>
              <button type="button" className="btn primary" disabled={!draftValue} onClick={confirmDate}>Confirm Date</button>
            </div>
          </div>
        </div>
      )}
    </div>
  )
}

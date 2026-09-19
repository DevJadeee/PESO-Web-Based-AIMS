const API_BASE = import.meta.env.VITE_API_URL || ''
export const SERVER_WEB_URL = import.meta.env.VITE_API_URL || ''

// Principle 1 - Professional Coding Standards and Practices: centralizes HTTP request logic and validates responses in one place to keep the client consistent and maintainable.
async function request(path, options = {}) {
  const isFormData = options.body instanceof FormData
  const response = await fetch(`${API_BASE}${path}`, {
    credentials: 'include',
    headers: {
      Accept: 'application/json',
      ...(options.body && !isFormData ? { 'Content-Type': 'application/json' } : {}),
    },
    ...options,
  })
  if (!response.ok) throw new Error(`Request failed: ${response.status}`)
  return response.json()
}

export const api = {
  get: request,
  login: async (credentials) => {
    const csrf = await request('/api/csrf-token')
    return request('/login', {
      method: 'POST',
      body: JSON.stringify({ ...credentials, _token: csrf.token }),
    })
  },
  logout: () => request('/logout', { method: 'POST' }),
  submitApplication: (payload) => request('/applicant/register', { method: 'POST', body: payload }),
  applicant: {
    dashboard: () => request('/api/applicant/dashboard'),
    register: (payload) => request('/api/applicant/register-account', { method: 'POST', body: JSON.stringify(payload) }),
    uploadResume: (payload) => request('/api/applicant/resume', { method: 'POST', body: payload }),
    saveCapstone: (payload) => request('/api/applicant/capstone', { method: 'POST', body: JSON.stringify(payload) }),
    submitApplication: (payload) => request('/api/applicant/applications', { method: 'POST', body: JSON.stringify(payload) }),
    reportJob: (id, payload) => request(`/api/applicant/jobs/${id}/report`, { method: 'POST', body: JSON.stringify(payload) }),
  },
  employer: {
    register: (payload) => request('/api/employer/register-account', { method: 'POST', body: JSON.stringify(payload) }),
    jobs: () => request('/api/employer/jobs'),
    createJob: (payload) => request('/api/employer/jobs', { method: 'POST', body: JSON.stringify(payload) }),
  },
  adminJobs: {
    list: () => request('/api/admin/jobs'),
    approve: (id) => request(`/api/admin/jobs/${id}/approve`, { method: 'PATCH' }),
  },
  programs: () => request('/api/programs'),
  csrfToken: () => request('/api/csrf-token'),
  dashboard: () => request('/api/admin/dashboard'),
  applicants: (params = {}) => request(`/api/admin/applicants?${new URLSearchParams(params)}`),
  admin: {
    applications: (code, params = {}) =>
      request(`/api/admin/programs/${code}/applications?${new URLSearchParams(params)}`),
    application: (id) => request(`/api/admin/applications/${id}`),
    updateApplication: (id, payload) =>
      request(`/api/admin/applications/${id}`, { method: 'PUT', body: JSON.stringify(payload) }),
    updateStatus: (id, payload) =>
      request(`/api/admin/applications/${id}/status`, {
        method: 'PATCH',
        body: JSON.stringify(payload),
      }),
    deleteApplication: (id) => request(`/api/admin/applications/${id}`, { method: 'DELETE' }),
    applicant: (id) => request(`/api/admin/applicants/${id}`),
    updateApplicant: (id, payload) =>
      request(`/api/admin/applicants/${id}`, { method: 'PUT', body: JSON.stringify(payload) }),
    deleteApplicant: (id) => request(`/api/admin/applicants/${id}`, { method: 'DELETE' }),
    reports: (params = {}) => request(`/api/admin/reports?${new URLSearchParams(params)}`),
    settings: () => request('/api/admin/settings'),
    approveEmployer: (id) => request(`/api/admin/employers/${id}/approve`, { method: 'PATCH' }),
    qr: () => request('/api/admin/qr'),
    createUser: (payload) =>
      request('/api/admin/settings/users', { method: 'POST', body: JSON.stringify(payload) }),
  },
  geography: {
    regions: () => request('/api/geography/regions?country=Philippines'),
    provinces: (regionId) => request(`/api/geography/provinces?region_id=${regionId}`),
    cities: (provinceId) =>
      request(`/api/geography/cities-municipalities?province_id=${provinceId}`),
    barangays: (cityId) => request(`/api/geography/barangays?city_municipality_id=${cityId}`),
  },
}

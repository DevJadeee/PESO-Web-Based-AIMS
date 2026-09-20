# Software Principles Evidence

This document identifies where the requested principles are applied in the self-contained PESO React + Node program.

## 1. Professional Coding Standards and Practices

**Path/directory:** `server/index.js`, `src/services/api.js`, and `src/pages/auth/Login.jsx`

**Implementation lines:**

- `server/index.js:18` keeps seed data, storage, and request handling organized in one backend boundary.
- `src/services/api.js:5` centralizes HTTP configuration and response checking instead of duplicating fetch logic.
- `src/pages/auth/Login.jsx:4-31` keeps login state, validation, loading, and user feedback inside the login component.

**Code segment:**

```js
// server/index.js:18
// Professional coding: keep seed data, persistence, and request handling in clear boundaries.
const seed = { users: [...], programs: [...], applicants: [...], applications: [...] }

// src/services/api.js:5
// Professional coding: centralize fetch configuration and response validation for every API call.
async function request(path, options = {}) {
  const response = await fetch(`${API_BASE}${path}`, { credentials: 'include', ...options })
  if (!response.ok) throw new Error(`Request failed: ${response.status}`)
  return response.json()
}
```

## 2. Fifteen Principles of Quality Software

The following quality principles are evidenced in the implementation. The line numbers refer to the current source files.

| Quality principle | Path and line | How it is applied |
| --- | --- | --- |
| Correctness | `server/index.js:91-109` | API handlers return the response shapes consumed by the React pages. |
| Reliability | `server/index.js:39-47` | The data file is created and loaded consistently at startup. |
| Usability | `src/pages/auth/Login.jsx:11-29` | Login loading, errors, password visibility, and registration links are represented clearly in the UI. |
| Efficiency | `server/index.js:56-62` | Filtering happens before response enrichment and rendering. |
| Maintainability | `src/services/api.js:14-46` | API operations are named and grouped by feature. |
| Portability | `package.json:6-12` | `npm run server` and `npm run dev:full` provide platform-independent project commands. |
| Security | `server/index.js:64-65, 74-76, 89` | Admin routes require a session and login issues an HTTP-only cookie. |
| Testability | `server/index.js:1-124` | The backend exposes deterministic HTTP boundaries that can be tested independently. Automated tests are still a recommended follow-up. |
| Reusability | `server/index.js:50-55` | `findApplicant`, `findProgram`, and enrichment helpers are shared by multiple endpoints. |
| Scalability | `src/components/common/ApplicationsTable.jsx` and API pagination shape | The API returns structured data that can be paginated or filtered without changing the record contract. |
| Simplicity | `server/index.js:1-124` | A small Express service and JSON store avoid unnecessary infrastructure for this local program. |
| Modularity | `src/services`, `src/pages`, `src/layouts`, and `server` | UI, API client, layouts, pages, and server logic have separate directories. |
| Flexibility | `src/services/api.js:1-2` | `VITE_API_URL` can change the API origin without changing consumers. |
| Robustness | `server/index.js:42, 65, 71, 81` | Missing storage, unauthenticated requests, invalid credentials, and optional form values are handled deliberately. |
| Interoperability | `server/index.js:68-89` | The server accepts JSON, URL-encoded data, and multipart `FormData` used by the React client. |

**Code segment:**

```js
// server/index.js:64-65
// Defensive programming: reject every admin request unless a server-issued session exists.
function adminOnly(request, response, next) {
  if (!sessions.has(request.headers.cookie?.match(/peso_session=([^;]+)/)?.[1])) {
    return response.status(401).json({ message: 'Unauthenticated' })
  }
  next()
}
```

## 3. Defensive Programming

**Path/directory:** `server/index.js`

**Implementation lines:**

- `server/index.js:42-44` creates missing storage and initializes predictable data.
- `server/index.js:64-65` blocks protected requests without a valid session.
- `server/index.js:81-88` normalizes optional and repeated registration values before saving them.
- `server/index.js:72-76` rejects unknown credentials instead of assuming a matching user exists.

**Code segment:**

```js
// server/index.js:81
// Defensive programming: normalize optional and repeated form values before persistence.
const body = request.body
const applicant = {
  first_name: body.first_name || '',
  last_name: body.last_name || '',
  education: values(body, 'education_level[]').join(', '),
}
```

## 4. Error Exception Handling

**Path/directory:** `server/index.js`, `src/services/api.js`, and `src/pages/auth/Login.jsx`

**Implementation lines:**

- `server/index.js:71-76` returns HTTP 422 for invalid login credentials.
- `server/index.js:65` returns HTTP 401 for unauthenticated admin access.
- `src/services/api.js:11-12` converts failed HTTP responses into exceptions for callers.
- `src/pages/auth/Login.jsx:7-29` catches login failure, displays a user-safe message, and always clears loading state.
- `src/pages/auth/Login.jsx:6-29` treats unsuccessful login as a controlled UI state instead of crashing the page.

**Code segment:**

```jsx
// src/pages/auth/Login.jsx:7-29
// Error exception principle: login errors are contained and shown to the user without crashing the form.
const submit = async (event) => {
  event.preventDefault()
  setError('')
  setLoading(true)

  try {
    const result = await authService.login({ email: form.get('email'), password: form.get('password') })
    onLogin(result.user)
  } catch {
    setError('The provided credentials do not match our records.')
  } finally {
    setLoading(false)
  }
}
```

## SVG Audit

The application does not contain unused SVG assets in the main code path. Both files are actively used:

- `public/favicon.svg` is referenced from `index.html` as the browser tab icon.
- `public/peso-logo.svg` is referenced in `src/pages/auth/Login.jsx`, `src/components/navigation/Sidebar.jsx`, `src/layouts/ApplicantLayout.jsx`, and `src/pages/admin/QRPoster.jsx`.

No SVG deletion was required because each file contributes to the app's visible UI and branding.

## Remaining Quality Improvements

- Replace plaintext demo passwords with salted password hashes before production deployment.
- Validate CSRF tokens on state-changing requests; the current token endpoint supplies compatibility tokens.
- Persist sessions if users must remain signed in after a server restart.
- Add automated endpoint and component tests for login, registration, filtering, and authorization.

# PESO Agoo

This project is a full-stack employment application for the Public Employment Service Office of Agoo. It includes a React frontend, an Express backend, and local JSON-based data storage for applicants, employers, jobs, and application records.

## How to run the program

### 1) Install dependencies

```bash
npm install
```

This installs the required modules from `package.json`, including:

- `react` and `react-dom` for the frontend
- `vite` for development and build tools
- `express` for the backend server
- `multer` for file uploads
- `pdfkit` for PDF generation
- `psgc` for geographic data support
- `qrcode` for QR features
- `concurrently` to run frontend and backend together

### 2) Run the project

Start the backend and frontend together:

```bash
npm run dev:full
```

Then open this URL in the browser:

```txt
http://localhost:5174
```

The backend server runs on:

```txt
http://127.0.0.1:8000
```

The project stores its local data in:

```txt
data/peso.json
```

### 3) Production build

```bash
npm run build
npm run server
```

Then open:

```txt
http://127.0.0.1:8000
```

---

## Default login accounts

### Admin account

- Email: `admin@pesoagoo.gov.ph`
- Password: `password123`

Use this account to access the admin console and manage records.

### Applicant account

- Name: Maria Santos
- Email: `maria@example.com`
- Password: `applicant123`

Use this account to access the applicant dashboard and job matching page.

### Employer account

- Name: Agoo Distribution Center
- Email: `employer@obrakonek.local`
- Password: `employer123`

Use this account to access the employer console and create or review job postings.

---

## How the system works

The application has three main layers:

1. Frontend in `src/` using React
2. Backend API in `server/index.js`
3. Local database in `data/peso.json`

The login page authenticates users, creates a session cookie, and routes the user to the correct role-based area.

- Admin users can access reports, applications, and management pages.
- Applicants can upload resumes, add a capstone profile, and view job recommendations.
- Employers can register, log in, and post jobs.

---

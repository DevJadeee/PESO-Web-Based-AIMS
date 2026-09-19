# Applicant domain schema

The current demo persists these collections in `data/peso.json`. They map directly to relational tables if the project moves to SQL.

## `jobseekers`

`id`, `name`, `email`, `skills[]`, `education`, `created_at`, `updated_at`

## `resumes`

`id`, `jobseeker_id`, `filename`, `parsed_at`, `extracted_skills[]`, `extracted_education`, `extracted_experience`

## `capstone_profiles`

`id`, `jobseeker_id`, `title`, `tools`, `output`, `created_at`

## `applications`

`id`, `jobseeker_id`, `job_id`, `status`, `note`, `cover_note`, `submitted_at`, `updated_at`

The applicant API currently simulates OCR/NLP parsing by returning extracted skills after PDF upload. The matching score is calculated from overlapping normalized skill terms, and each job exposes its matched terms for explainability.

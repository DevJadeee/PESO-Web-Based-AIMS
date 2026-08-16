## Structure Chart Explanation

This Structure Chart illustrates the top-down modular architecture of the **Web-Based Applicant Information and Employment Assistance Management System**. It shows how the system is partitioned into three primary subsystems (controllers) under the main controller.

## Top Control Level

### Root Module

**Web-Based Applicant Information and Employment Assistance Management System** acts as the central coordinator, passing data (like applicant details and document requests) up and down to its three main branches.

### 1. Input Controller Branch (Left)

Responsible for capturing and preparing incoming applicant data.

**Applicant Profiling:** Coordinates the intake of applicant data.

#### 1.1 Application Form

Accepts raw input details (View Applicant Details / Complete Applicant Details) and prepares them for processing.

### 2. Central Transform Controller Branch (Middle)

Handles core data processing, verification, matching algorithms, reporting, and status tracking.

**Application Process:** Manages system-wide operations across three key child components:

#### 2.1 Application Verification

Performs document and data checks (Verify Applicant Details / Verified Documents).

##### 2.1.1 Match Applicants with Job Vacancies

Evaluates verified records against job requirements.

#### 2.2 Reports Processing

Compiles and formats system outputs (Applicants Documents / Generated Reports / Converted Documents).

##### 2.2.1 Compile Statistical Data & Summary

Aggregates data into statistical summaries.

##### 2.2.2 Convert to MS Office Applications

Converts structured reports into editable formats.

#### 2.3 Application Status Process

Tracks changes in an applicant's evaluation progress (Status Messages).

##### 2.3.1 Update Application Status

Records and updates the current status of each application.

### 3. Output Controller Branch (Right)

Manages data presentation and delivery of results to users.

**Application Updates:** Controls output routes for applicants and administrators (Applicant Information).

#### 3.1 Application Status Result

Generates status updates viewable by applicants (Application Status Message).

#### 3.2 View or Print Reports

Outputs finalized reports for printing or administrative review (Final Report).

#### 3.3 View Application Summary

Summarizes overall application progress (Generated Applications).

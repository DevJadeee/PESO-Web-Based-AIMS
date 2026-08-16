This Structure Chart illustrates the top-down modular architecture of the Web-Based Applicant Information and Employment Assistance Management System, showing how tasks are partitioned across three primary subsystems under the main controller.
‎
‎​Top Control Level
‎
‎​Root Module: Web-Based Applicant Information and Employment Assistance Management System acts as the central coordinator, passing data (like applicant details and document requests) up and down to its three main branches.
‎
‎​1. Input Controller Branch (Left)
‎Focuses on capturing and managing incoming user information.
‎​Applicant Profiling: Coordinates the intake of applicant data.
‎​1.1 Application Form: Accepts raw input details (View Applicant Details / Complete Applicant Details) and prepares them for processing.
‎
‎​2. Central Transform Controller Branch (Middle)
‎Handles core data processing, matching algorithms, reporting, and status tracking.
‎
‎​Application Process: Manages system-wide operations across three key child components:
‎​2.1 Application Verification: Handles document checks (Verify Applicant Details / Verified Documents).
‎​2.1.1 Match Applicants with Job Vacancies: Evaluates verified records against job requirements.
‎​2.2 Reports Processing: Compiles system findings and documentation (Reports/Documents / Generated Reports).
‎​2.2.1 Compile Statistical Data & Summary: Aggregates background data and summary metrics.
‎​2.2.2 Convert to MS Office Applications: Converts structured reports into editable formats.
‎​2.3 Application Status Process: Tracks changes in an applicant's evaluation progress (Status Messages).
‎​2.3.1 Update Application Status: Modifies and saves current application states.
‎
‎​3. Output Controller Branch (Right)
‎Manages data presentation and dissemination.
‎
‎​Application Updates: Controls output routes for applicants and administrators (Applicant Information).
‎​3.1 Application Status Result: Generates status updates viewable by applicants (Application Status Message).
‎​3.2 View Application Summary: Summarizes overall application progress (Generated Applications).
‎​3.3 View or Print Reports: Outputs finalized reports for printing or administrative review (Print Report).

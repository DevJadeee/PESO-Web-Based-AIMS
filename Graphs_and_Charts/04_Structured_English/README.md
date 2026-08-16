This Structured English document outlines the procedural, logic-based flow for the PESO Applicant Information and Employment Assistance Management System. It uses conditional control logic (IF ... ELSE IF ... ENDIF) to define input, processing, and output steps based on the role or action of the user.
‎
‎​1. Applicant Workflow (IF USER TYPE = "APPLICANT")
‎Defines how standard users apply and build their system profile.
‎
‎​Input: Receives an Application Form, Personal Information, Resume, and Supporting Documents.
‎
‎​Process:
‎​Submits the application.
‎​Creates an applicant profile.
‎​Stores the provided information in the system database.
‎​Matches the applicant against available job vacancies.
‎​Forwards uploaded documents for verification.
‎
‎​Output: Generates an Applicant Profile, stores Application Details, and sends an Application Submitted Confirmation to the user.
‎
‎​2. Administrator Workflow (ELSE IF USER TYPE = "PESO ADMIN")
‎Defines the management, verification, and reporting tasks carried out by administrative staff.
‎
‎​Input: Receives Applicant Information, Submitted Documents, Verification Requests, and requests for Application Status Reports.
‎
‎​Process:
‎​Reviews applicant information.
‎​Verifies submitted documents.
‎​Matches applicants with job vacancies.
‎​Generates system reports.
‎​Converts reports into MS Office formats (e.g., Word/Excel).
‎​Updates overall application statuses.
‎​Stores processed documents and reports.
‎
‎​Output: Produces Verified Applications, Generated Reports, Updated Application Status, and final Approved/Rejected Applications decisions.
‎
‎​3. Status Tracking Workflow (ELSE IF USER ACTION = "CHECK APPLICATION STATUS")
‎Handles status queries from applicants checking their submission progress.
‎
‎​Input: Requires the Applicant ID or Reference Number.
‎
‎​Process:
‎​Retrieves the corresponding applicant record from the database.
‎​Checks the current status of the application.
‎​Prepares the status details for display.
‎
‎​Output: Returns an Application Status Notification alongside complete Status Details.

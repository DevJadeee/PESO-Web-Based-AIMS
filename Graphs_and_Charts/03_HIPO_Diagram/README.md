This **HIPO (Hierarchy plus Input-Process-Output)** Diagram illustrates the functional decomposition of the Web-Based Applicant Information and Employment Assistance Management System (0.0). It breaks down the system top-down into three core functional modules and their specific sub-functions.

## 1.0 Applicant Module
Handles all client-side inputs and form submissions.
‎​
**1.1 Application Form:** Captures core applicant data.
‎​
Personal Details / Résumé
‎
Supporting Documents
‎
‎​**1.2 Submit Application:** Processes and submits completed applications.
‎
‎​Store Applications: Saves application entries into the system database.
‎
‎​**1.3 Applicant Details:** Allows viewing/reviewing submitted applicant profile details.

---

## 2.0 PESO Admin Module
‎Provides administrative tools to review, verify, update, and manage job applications.
‎​
**2.1 Applicant Information:** Accesses applicant profiles and attached files.
‎​
Submitted Documents: Displays uploaded files for verification.
‎
**​2.2 Review Applications:** Administrative processing tasks.
‎
​Verify Documents: Authenticates uploaded applicant files.
‎​
Update Status: Modifies the progress/approval status of an application.
‎
​Generate Reports: Produces system-level summary reports.

‎​**2.3 Verified Applications:** Contains finalized/verified applicant outputs.

Generated Reports: Displays compiled reports on verified applications.

--- 

## ​3.0 Application Status Module
‎Manages status tracking and record lookups.
‎​
**3.1 Applicant ID or Reference Number:** Inputs unique identifiers for tracking.
‎
**​3.2 Retrieve Applicant Record:** Pulls up record details.
‎
​Check Status: Verifies the current state of an application.
‎​
**3.3 Application Status:** Displays the final status updates to the user.

This **Pseudocode** details the underlying programmatic logic and function calls for the PESO Applicant Information and Employment Assistance Management System. It evaluates the user's role or request (UserType) via conditional branching (IF ... ELSE IF ... ELSE) and executes the corresponding operations.

## 1. Applicant Execution Path (UserType = "Applicant")

Handles data submission and profile generation when a job seeker accesses the system.

**Input:** Prompts for ApplicantData.

### Function Calls:

​**SubmitApplication(ApplicantData)** initializes the submission.

**CreateApplicantProfile(ApplicantData)** generates and returns an ApplicantProfile.

**StoreApplicantInformation(ApplicantProfile)** writes the profile to the database.

**MatchApplicantWithJobVacancies(ApplicantProfile)** runs automated job-matching logic.

**SubmitDocumentsForVerification(ApplicantProfile)** routes uploaded documents for review.

​**Output:** Displays "Application Submitted Successfully".

---

## 2. PESO Admin Execution Path (UserType = "PESO Admin")

Executes administrative controls after authenticating system managers.

**Authentication:** Executes LOGIN PESO Admin.

### Function Calls:

**ManageApplicantInformation() / ReviewApplicantInformation()** opens profile management tools.

​**VerifyDocuments()** checks submitted files for validity.

**MatchApplicantsWithJobVacancies()** initiates system-wide job matching.

**GenerateReports() and ConvertReportsToMSOffice()** compile and export administrative reporting files.

​**UpdateApplicationStatus()** updates evaluation states.

**StoreDocumentsAndReports()** saves processed changes and reports to storage.

**Outputs:** Displays/presents "Verified Applications", "Generated Reports", "Updated Application Status", and "Approved/Rejected Applications".

---

## 3. Status Check Execution Path (UserType = "Check Application Status")

Provides a lightweight query route for applicants checking their application status.

**Input:** Prompts for an ApplicantID.

### Function Calls:

**RetrieveApplicantRecord(ApplicantID)** queries and assigns data to ApplicantRecord.

**​CheckApplicationStatus(ApplicantRecord)** evaluates the profile and assigns the result to Status.
‎
‎​**Output** Displays the current Status.

---

## ​4. Exception Handling (ELSE)
‎
‎​**Output:** Displays "Invalid User Type" if the input does not match any defined role or action.

These Data Flow Diagrams (DFDs) break down the high-level and detailed interactions within the Web-Based Applicant Information & Employment Assistance Management System.

## Data Flow Diagram: Level 0 (Context Diagram)

This diagram presents an overarching, top-level view of the entire system as a single central process (Process 0: "Web-Based Applicant Information & Employment Assistance Management System") interacting with external entities.

### External Entities

**Applicant:** Submits the Application Form into the system and receives an Application Update.

**PESO Admin:** Sends Manage Applicant Info, Verify Documents, and Update Application Status into the system, and receives Generated Reports and View Application Details.

### Purpose

Defines the system boundary and the primary inputs/outputs. No internal processes or data stores are shown.

---

## Data Flow Diagram: Level 1

This diagram expands Process 0 into four major internal processes and introduces the three data stores.

### Key Processes

**1.0 Applicant Profiling:** Receives the Application Form from the Applicant, exchanges Manage Applicant Info / View Application Details / Generated Reports with the PESO Admin, and stores data in D1 Applicants Database.

**2.0 Application Verification Process:** Allows the PESO Admin to perform Verify Documents, stores/retrieves information from D3 Documents Database, and sends verification data (Generate Reports) downstream.

**3.0 Reports Processing:** Receives data from process 2.0, stores/retrieves reports from D2 Reports Database, and sends Generated Reports to the PESO Admin.

**4.0 Application Status Process:** Receives Update Application Status from the Admin and returns Application Status to the Applicant.

### Purpose

Shows the main functional modules of the system and how they interact with the three persistent data stores (D1, D2, D3).

---

## Data Flow Diagram: Level 2

This diagram further decomposes the Level-1 processes into more detailed sub-processes:

**1.0 Applicant Profiling** remains as a single process.

**2.0 Application Verification Process** is expanded to include 2.1 Match Applicants with Job Vacancies.

**3.0 Reports Processing** is expanded to include 3.1 MS Office Applications (conversion of reports into MS Office format).

**4.0 Application Status Process** remains as a single process.

The same three data stores (D1 Applicants Database, D2 Reports Database, D3 Documents Database) and the same external entities are retained.

### Purpose

Provides implementation-level detail on the two most complex processes (job matching and report formatting). 

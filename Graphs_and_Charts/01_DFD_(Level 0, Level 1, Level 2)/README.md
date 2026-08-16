These Data Flow Diagrams (DFDs) break down the high-level and detailed interactions within the Web-Based Applicant Information & Employment Assistance Management System.
‎
‎​Level 0: 
‎This diagram presents an overarching, top-level view of the entire system as a single central process (0) interacting with external entities.
‎
‎​Entities:
‎​Applicant: Submits the Application Form into the system and receives an Application Update.
‎
‎​PESO Admin: Manages system data by sending inputs (Manage Applicant Info, Verify Documents, and Update Application Status) and retrieves outputs (Generated Reports and View Application Details).
‎
‎​Purpose: Defines the boundary of the system and identifies primary data inputs/outputs without revealing internal processing steps.
‎
‎​Level 1 DFD
‎This diagram expands the central system into four main sub-processes and introduces data stores for persistent storage.
‎
‎​Key Processes & Data Flows:
‎​1.0 Applicant Profiling: Takes the Application Form from the Applicant, interacts with the PESO Admin (Manage Applicant Info / View Application Details), and stores data in D1 Applicants Database.
‎
‎​2.0 Application Verification Process: Allows the PESO Admin to perform Verify Documents, stores/retrieves information from D3 Documents Database, and sends verification data (Generate Reports) downstream.
‎
‎​3.0 Reports Processing: Collects report data from process 2.0, saves or reads records from D2 Reports Database, and delivers Generated Reports to the PESO Admin.

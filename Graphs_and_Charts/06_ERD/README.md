This Entity Relationship Diagram (ERD) models the database structure for the PESO system, detailing six primary entities, their attributes, and how they relate to one another.
‎
‎​Core Entities & Attributes
‎
‎​Applicant: Represents the job seeker.
‎
‎​Attributes: Applicant_id (Primary Key), Applicant_Details, and Resume.
‎
‎​Application: Stores job application submissions.
‎
‎​Attributes: Application_id (Primary Key), Applicant_id, Application_Date, Applicant_Details, Preferred_Job, and Applicant_Field.
‎
‎​PESO Admin: Represents administrative users managing the portal.
‎
‎​Attributes: Admin_id (Primary Key), Applicant_id, Application_id, Report_id, Admin_Details, Password, and Email.
‎
‎​Documents: Stores verification files uploaded by applicants.
‎
‎​Attributes: Documents_id (Primary Key), Application_id, Document_Type, Verification_Status, and Remarks.
‎
‎​Reports: Handles administrative reporting data.
‎
‎​Attributes: Reports_id (Primary Key), Documents_id, Applicant_Details, Applicant_Field, and Applicants_List.
‎
‎​Application_Status: Tracks the progress and state of an application.
‎
‎​Attributes: Status_id (Primary Key), Status, and Status_Description.
‎
‎​Relationships & Cardinality
‎
‎​Applicant — Submit — Application: An Applicant can submit one or more Applications (1:N).
‎​PESO Admin — Manages — Applicant: A PESO Admin oversees multiple Applicants (1:N).
‎​PESO Admin — Verifies — Application: A PESO Admin reviews and verifies Applications (1:N).
‎​Application — Includes — Documents: An Application contains one or more submitted Documents (1:N).
‎​Documents — Includes — Reports: Verified Documents are compiled and aggregated into Reports (1:N).
‎​PESO Admin — Generates — Reports: A PESO Admin processes system data to generate Reports (1:N).
‎​PESO Admin — Generates — Application_Status: A PESO Admin assigns and updates the Application_Status (1:N).
‎​Applicant — Receive — Application_Status: An Applicant receives tracking updates from Application_Status (1:N).

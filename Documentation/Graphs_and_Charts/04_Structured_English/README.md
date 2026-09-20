
This **Structured English** document outlines the procedural, logic-based flow for the two core components of the system: the **Semantic Job Matching Procedure** and the **Relevance Ranking Procedure**. Together, these procedures define how an applicant's resume is compared against available job vacancies and how the resulting matches are scored and ordered for presentation.

## 1. Semantic Job Matching Procedure

Defines how the system determines which job vacancies are relevant to a given applicant.

**Input:** Receives an applicant's Resume and the Job Details of each posted vacancy.

### Process:

Extracts data from the applicant's resume.

​Creates an applicant profile and a corresponding job profile for comparison.

​Performs text preprocessing on both profiles (cleaning and normalizing the text).

​Generates TF-IDF representation of the preprocessed text.

Applies domain-specific weighting to the TF-IDF representations.

Repeats the following for each job in the list of vacancies:
- Calculates the cosine similarity between the applicant's representation and the job's reresentation.
- If the similarity meets or exceeds the threshold, classifies the job as Matched/Relevant. Otherwise, Exclude the job from the matched set

This repeats until no jobs remain unevaluated.

**Output:** Produces the Matched Job Set
- the list of job vacancies classifies as relevant to the applicant.

---

## ​2. Relevance Ranking Procedure

Defines how the matched jobs are scored and arranged in order of relevance before being shown to the applicant.

**Input:** Receives the Matched Job Set produced by the Semantic Job Matching Procedure.

### Process:

Retrieves the similarity values already calculated for each matched job.

Repeats the following for each job in the matched set:
- Calculates a relevance score.
- Converts the relevance score into a percentage.
- Stores the relevance score for the job.​

This repeats until no jobs remain unevaluated.

Sorts the matched jobs from highest to lowest relevance score.

Assigns a rank to each job based on its sorted position.

**Output:** Produces a Ranked List of Jobs, each displayed its Match Percentage.


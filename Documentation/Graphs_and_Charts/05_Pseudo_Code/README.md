

This **Pseudocode** details the underlying programmatic logic and function calls for the two core algorithmic components of the system: **Semantic Job Matching** and **Relevance Ranking**. Together, these algorithms take an applicant's resume and the available job vacancies as input and produce a ranked list of the most relevant job matches as output.

## 1. Semantic Job Matching Algorithm

Determines which job vacancies are semantically relevant to a given applicant by comparing their resume against each job posting.

**Input:** Prompts for 'Resume' and 'JobDetails'.

### Function Calls:

​**ExtractResumeData(Resume)** parses the applicants resume and returns structured 'ResumeData'.

**CreateApplicantProfiles(ResumeData, JobDetails)** builds the corresponding 'ApplicantProfile' and 'JobProfile' used for comparison.

**TextPreprocessing(ApplicantProfile, JobProfile)** cleans and normalizes the profile text (e.g., tokenization, stop-word removal) and returns 'PreprocessedText'.

**GenerateTF-IDFRepresentation(PreprocessedText)** converts the preprocessed text into a 'TF-IDFRepresentation'.

**ApplyDomainSpecificWeighting(TF-IDFRepresentation)** adjust terms weights based on domain-specific relevance, producing a 'WeightedRepresentation'.

**CalculateCosineSimilarity(WeightedRepresentation, Job)** computes a 'Similarity' score between the applicants profile and each job, repeated for every job vacancyn ('REPEAT ... UNTIL MoreJobs = FALSE').

Within this loop, each job is evaluated against a 'Threshold':
- If 'Similarity ≥ Threshold', the job is classified as **Matched/Relevant** and added to the 'MatchedJobSet'.
- Otherwise, the job is excluded from the matched set.

​**Output:** Returns the 'MatchedJobSet', the collection of job vacancies classified as relevant to the applicant.

---

## 2. Relevance Ranking Algorithm

Takes the jobs identified by the Semantic Job Matching algorithm and orders them by how closely each one matches the applicant.

**Input:** Prompts for 'MatchedJobSet'.

### Function Calls:

**RetrievalSimilarityValue(MatchedJobSet)** retrieves the similarity values previously calculated for each matched job.

​**CalculateRelevanceScore(SimilarityValues, Job)** computes a 'RelevanceScore' for each job, repeated for every job in the matched set ('REPEAT ... UNTIL MoreJobs = FALSE').

Within this loop, for each job:
- **ConvertToPercentage(RelevanceScore)** converts the score into a 'MatchPercentage'.
- **StoreRelevanceScore(Job, MatchPercentage)** saves the jobs relevance score for later display.

**SortHighestToLowest(MatchedJobSet)** arranges 'RankedJobs' in descending order of relevance.

**AssignRank(RankedJobs)** assign a numerical rank to each job based on its position in the sorted list.

**Output:** **DisplayRankedJobs(RankedJobs) WITH MatchedPercentage** presents the final ranked list of matched jobs, each shown alongside its computed match percentage.


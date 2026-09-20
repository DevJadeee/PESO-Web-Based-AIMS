import { localGeography } from '../../services/geography'

const excludedFields = new Set(['_token', 'program_id', 'program_code'])
const groups = [
  { key: 'personal', title: 'Personal Information', matches: ['first_name', 'middle_name', 'last_name', 'suffix', 'birth_date', 'place_of_birth', 'gender', 'civil_status', 'citizenship', 'religion', 'tin'] },
  { key: 'contact', title: 'Contact Information', matches: ['contact_number', 'email', 'social_media_account'] },
  { key: 'present-address', title: 'Present Address', matches: ['present_country', 'present_region', 'present_province', 'present_city_municipality', 'present_barangay', 'present_street'] },
  { key: 'permanent-address', title: 'Permanent Address', matches: ['permanent_country', 'permanent_region', 'permanent_province', 'permanent_city_municipality', 'permanent_barangay', 'permanent_street'] },
  { key: 'family', title: 'Family Information', matches: ['father_', 'mother_', 'gsis_beneficiary', 'relationship_to_beneficiary'] },
  { key: 'category', title: 'Applicant Category', matches: ['applicant_status', 'employment_status', 'disability_type', 'pwd', 'senior_citizen', 'indigenous_people', 'former_ofw', 'ofw', 'four_ps_beneficiary', 'household_id'] },
  { key: 'education', title: 'Educational Background', matches: ['education_'] },
  { key: 'experience', title: 'Training, Experience and Skills', matches: ['training_', 'company_', 'position', 'months', 'work_status', 'skills_list', 'language_'] },
  { key: 'program', title: 'Program Application', matches: ['purpose_or_position', 'place_or_agency', 'spes_', 'preferred_'] },
  { key: 'consent', title: 'Consent and Certification', matches: ['consent_', 'data_privacy_'] },
]

function fieldLabel(name) {
  return name
    .replace(/\[\]/g, '')
    .replaceAll('_', ' ')
    .replace(/\b\w/g, (letter) => letter.toUpperCase())
}

function fieldValue(value, name, allValues) {
  if (Array.isArray(value)) return value.filter(Boolean).join(', ')
  if (value === '1') return 'Yes'
  if (value === '0') return 'No'
  if (name.endsWith('_region')) {
    return localGeography.regions().find((item) => item.id === Number(value))?.name || value
  }
  if (name.endsWith('_province')) {
    const regionId = allValues[`${name.split('_')[0]}_region`]
    return (
      localGeography.provinces(regionId).find((item) => item.id === Number(value))?.name || value
    )
  }
  if (name.endsWith('_city_municipality')) {
    const prefix = name.split('_')[0]
    const provinceId = allValues[`${prefix}_province`]
    return localGeography.cities(provinceId).find((item) => item.id === Number(value))?.name || value
  }
  return String(value ?? '')
}

function belongsToGroup(name, group) {
  return group.matches.some((match) => name === match || name.startsWith(match))
}

export default function FullSubmissionDetails({ applicant }) {
  const details = Object.entries(applicant?.raw_data || {}).filter(
    ([name, value]) => !excludedFields.has(name) && fieldValue(value, name, applicant.raw_data),
  )
  const groupedDetails = groups.map((group) => ({
    ...group,
    details: details.filter(([name]) => belongsToGroup(name, group)),
  }))
  const groupedNames = new Set(groupedDetails.flatMap((group) => group.details.map(([name]) => name)))
  const otherDetails = details.filter(([name]) => !groupedNames.has(name))
  if (!details.length) return null
  return (
    <section className="submission-details">
      <div className="section-heading">
        <h4>Complete Application Information</h4>
        <span>{details.length} submitted fields</span>
      </div>
      {groupedDetails.map(
        (group) =>
          group.details.length > 0 && (
            <div className="submission-group" key={group.key}>
              <h5>{group.title}</h5>
              <div className="submission-details-grid">
                {group.details.map(([name, value]) => (
                  <div className="submission-detail" key={name}>
                    <small>{fieldLabel(name)}</small>
                    <strong>{fieldValue(value, name, applicant.raw_data)}</strong>
                  </div>
                ))}
              </div>
            </div>
          ),
      )}
      {otherDetails.length > 0 && (
        <div className="submission-group">
          <h5>Other Submitted Information</h5>
          <div className="submission-details-grid">
            {otherDetails.map(([name, value]) => (
              <div className="submission-detail" key={name}>
                <small>{fieldLabel(name)}</small>
                <strong>{fieldValue(value, name, applicant.raw_data)}</strong>
              </div>
            ))}
          </div>
        </div>
      )}
      {applicant.resume && (
        <div className="resume-summary">
          <small>Resume / CV</small>
          <strong>
            <a href={`/uploads/resumes/${encodeURIComponent(applicant.resume.filename)}`} target="_blank" rel="noreferrer">
              {applicant.resume.original_name || applicant.resume.filename}
            </a>
          </strong>
          <span>{Math.ceil((applicant.resume.size || 0) / 1024)} KB</span>
        </div>
      )}
    </section>
  )
}

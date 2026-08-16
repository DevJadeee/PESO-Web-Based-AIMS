@extends('layouts.public')

@section('title', 'Unified Applicant Registration')

@section('content')
<div class="unified-form-shell">
    <div class="form-intro">
        <p class="eyebrow">PESO Agoo, La Union</p>
        <h2>Applicant Registration</h2>
    </div>

    @if($errors->any())
        <div class="alert-error">
            <strong>Please correct the following:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('public.register.store') }}" method="POST" id="unifiedApplicantForm" novalidate>
        @csrf

        <div class="section-card">
            <div class="section-header">
                <h3>Personal Information</h3>
            </div>

            <div class="grid-3">
                <div class="form-group">
                    <label for="last_name">Surname / Last Name <span>*</span></label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required>
                </div>
                <div class="form-group">
                    <label for="first_name">First Name <span>*</span></label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required>
                </div>
                <div class="form-group">
                    <label for="middle_name">Middle Name</label>
                    <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name') }}">
                </div>
            </div>

            <div class="grid-4">
                <div class="form-group">
                    <label for="suffix">Suffix</label>
                    <input type="text" name="suffix" id="suffix" value="{{ old('suffix') }}" placeholder="Jr., Sr., III">
                </div>
                <div class="form-group">
                    <label for="birth_date">Date of Birth <span>*</span></label>
                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" required>
                </div>
                <div class="form-group">
                    <label for="place_of_birth">Place of Birth</label>
                    <input type="text" name="place_of_birth" id="place_of_birth" value="{{ old('place_of_birth') }}" placeholder="e.g. Agoo, La Union">
                </div>
                <div class="form-group">
                    <label for="gender">Sex / Gender <span>*</span></label>
                    <select name="gender" id="gender" required>
                        <option value="">Select</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Prefer not to say" {{ old('gender') == 'Prefer not to say' ? 'selected' : '' }}>Prefer not to say</option>
                    </select>
                </div>
            </div>

            <div class="grid-4">
                <div class="form-group">
                    <label for="civil_status">Civil Status <span>*</span></label>
                    <select name="civil_status" id="civil_status" required>
                        <option value="">Select</option>
                        <option value="Single" {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                        <option value="Married" {{ old('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                        <option value="Widowed" {{ old('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                        <option value="Separated" {{ old('civil_status') == 'Separated' ? 'selected' : '' }}>Separated</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="citizenship">Citizenship</label>
                    <input type="text" name="citizenship" id="citizenship" value="{{ old('citizenship') }}" placeholder="Filipino">
                </div>
                <div class="form-group">
                    <label for="religion">Religion</label>
                    <input type="text" name="religion" id="religion" value="{{ old('religion') }}" placeholder="Optional">
                </div>
                <div class="form-group">
                    <label for="tin">TIN</label>
                    <input type="text" name="tin" id="tin" value="{{ old('tin') }}" placeholder="Optional">
                </div>
            </div>

            <div class="grid-3 contact-row">
                <div class="form-group contact-group">
                    <label for="contact_number">Contact Number / Cellphone Number <span>*</span></label>
                    <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number') }}" inputmode="numeric" maxlength="11" pattern="[0-9]{11}" data-mobile-input required>
                    <small class="field-hint">Enter 11 digits only, e.g. 09171234567</small>
                </div>
                <div class="form-group contact-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}">
                </div>
                <div class="form-group contact-group">
                    <label for="social_media_account">Social Media Account</label>
                    <input type="text" name="social_media_account" id="social_media_account" value="{{ old('social_media_account') }}" placeholder="Facebook / Messenger / X / etc.">
                </div>
            </div>
        </div>

        <div class="section-card">
            <div class="section-header">
                <h3>Address Information</h3>
            </div>

            <div class="address-block" data-address-type="present">
                <div class="address-row">
                    <div class="form-group">
                        <label for="present_country">Country <span>*</span></label>
                        <select id="present_country" name="present_country" required>
                            <option value="">Select Country</option>
                            <option value="Philippines" {{ old('present_country', 'Philippines') == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="present_region">Region <span>*</span></label>
                        <select id="present_region" name="present_region" required disabled>
                            <option value="">Select Region</option>
                        </select>
                    </div>
                </div>

                <div class="address-row">
                    <div class="form-group">
                        <label for="present_province">Province <span>*</span></label>
                        <select id="present_province" name="present_province" required disabled>
                            <option value="">Select Province</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="present_city_municipality">City / Municipality <span>*</span></label>
                        <select id="present_city_municipality" name="present_city_municipality" required disabled>
                            <option value="">Select City / Municipality</option>
                        </select>
                    </div>
                </div>

                <div class="address-row">
                    <div class="form-group">
                        <label for="present_barangay">Barangay <span>*</span></label>
                        <select id="present_barangay" name="present_barangay" required disabled>
                            <option value="">Select Barangay</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="present_street">House No. / Street / Sitio / Purok <span>*</span></label>
                        <input type="text" id="present_street" name="present_street" value="{{ old('present_street') }}" placeholder="e.g. 123 Rizal Street, Purok 2" required>
                    </div>
                </div>
            </div>

            <div class="checkbox-row">
                <label class="checkbox-wrap">
                    <input type="checkbox" name="same_as_present_address" id="same_as_present_address" value="1" {{ old('same_as_present_address') == '1' || old('same_as_present_address') === 1 || old('same_as_present_address') === true ? 'checked' : '' }} data-old-checked="{{ old('same_as_present_address') == '1' || old('same_as_present_address') === 1 || old('same_as_present_address') === true ? '1' : '0' }}">
                    <span>Same as Present Address</span>
                </label>
            </div>

            <div class="address-block" data-address-type="permanent">
                <div class="address-row">
                    <div class="form-group">
                        <label for="permanent_country">Country <span>*</span></label>
                        <select id="permanent_country" name="permanent_country" required>
                            <option value="">Select Country</option>
                            <option value="Philippines" {{ old('permanent_country', 'Philippines') == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="permanent_region">Region <span>*</span></label>
                        <select id="permanent_region" name="permanent_region" required disabled>
                            <option value="">Select Region</option>
                        </select>
                    </div>
                </div>

                <div class="address-row">
                    <div class="form-group">
                        <label for="permanent_province">Province <span>*</span></label>
                        <select id="permanent_province" name="permanent_province" required disabled>
                            <option value="">Select Province</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="permanent_city_municipality">City / Municipality <span>*</span></label>
                        <select id="permanent_city_municipality" name="permanent_city_municipality" required disabled>
                            <option value="">Select City / Municipality</option>
                        </select>
                    </div>
                </div>

                <div class="address-row">
                    <div class="form-group">
                        <label for="permanent_barangay">Barangay <span>*</span></label>
                        <select id="permanent_barangay" name="permanent_barangay" required disabled>
                            <option value="">Select Barangay</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="permanent_street">House No. / Street / Sitio / Purok <span>*</span></label>
                        <input type="text" id="permanent_street" name="permanent_street" value="{{ old('permanent_street') }}" placeholder="e.g. 123 Rizal Street, Purok 2" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-card">
            <div class="section-header">
                <h3>Family Information</h3>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label for="father_name">Father's Name</label>
                    <input type="text" name="father_name" id="father_name" value="{{ old('father_name') }}">
                </div>
                <div class="form-group">
                    <label for="father_contact_number">Father's Contact Number</label>
                    <input type="text" name="father_contact_number" id="father_contact_number" value="{{ old('father_contact_number') }}" inputmode="numeric" maxlength="11" pattern="[0-9]{11}" data-mobile-input>
                </div>
                <div class="form-group">
                    <label for="father_occupation">Father's Occupation</label>
                    <input type="text" name="father_occupation" id="father_occupation" value="{{ old('father_occupation') }}">
                </div>
                <div class="form-group"></div>

                <div class="form-group">
                    <label for="mother_maiden_name">Mother's Maiden Name</label>
                    <input type="text" name="mother_maiden_name" id="mother_maiden_name" value="{{ old('mother_maiden_name') }}">
                </div>
                <div class="form-group">
                    <label for="mother_contact_number">Mother's Contact Number</label>
                    <input type="text" name="mother_contact_number" id="mother_contact_number" value="{{ old('mother_contact_number') }}" inputmode="numeric" maxlength="11" pattern="[0-9]{11}" data-mobile-input>
                </div>
                <div class="form-group">
                    <label for="mother_occupation">Mother's Occupation</label>
                    <input type="text" name="mother_occupation" id="mother_occupation" value="{{ old('mother_occupation') }}">
                </div>
                <div class="form-group"></div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label for="gsis_beneficiary">GSIS Beneficiary / Relationship</label>
                    <input type="text" name="gsis_beneficiary" id="gsis_beneficiary" value="{{ old('gsis_beneficiary') }}" placeholder="Optional">
                </div>
                <div class="form-group">
                    <label for="relationship_to_beneficiary">Relationship</label>
                    <input type="text" name="relationship_to_beneficiary" id="relationship_to_beneficiary" value="{{ old('relationship_to_beneficiary') }}" placeholder="Optional">
                </div>
            </div>
        </div>

        <div class="section-card">
            <div class="section-header">
                <h3>Applicant Category</h3>
            </div>

            <div class="grid-3">
                <div class="form-group">
                    <label for="applicant_status">Applicant Status</label>
                    <select name="applicant_status" id="applicant_status">
                        <option value="">Select</option>
                        <option value="Student" {{ old('applicant_status') == 'Student' ? 'selected' : '' }}>Student</option>
                        <option value="ALS Student" {{ old('applicant_status') == 'ALS Student' ? 'selected' : '' }}>ALS Student</option>
                        <option value="Out-of-School Youth" {{ old('applicant_status') == 'Out-of-School Youth' ? 'selected' : '' }}>Out-of-School Youth</option>
                        <option value="Employed" {{ old('applicant_status') == 'Employed' ? 'selected' : '' }}>Employed</option>
                        <option value="Unemployed" {{ old('applicant_status') == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                        <option value="Fresh Graduate" {{ old('applicant_status') == 'Fresh Graduate' ? 'selected' : '' }}>Fresh Graduate</option>
                        <option value="Former OFW" {{ old('applicant_status') == 'Former OFW' ? 'selected' : '' }}>Former OFW</option>
                        <option value="OFW" {{ old('applicant_status') == 'OFW' ? 'selected' : '' }}>OFW</option>
                        <option value="Other" {{ old('applicant_status') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="employment_status">Employment Status</label>
                    <select name="employment_status" id="employment_status">
                        <option value="">Select</option>
                        <option value="Permanent" {{ old('employment_status') == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                        <option value="Contractual" {{ old('employment_status') == 'Contractual' ? 'selected' : '' }}>Contractual</option>
                        <option value="Part-time" {{ old('employment_status') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="Probationary" {{ old('employment_status') == 'Probationary' ? 'selected' : '' }}>Probationary</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="disability_type">Disability Type</label>
                    <input type="text" name="disability_type" id="disability_type" value="{{ old('disability_type') }}" placeholder="If applicable">
                </div>
            </div>

            <div class="check-grid">
                <label class="checkbox-wrap"><input type="checkbox" name="pwd" value="1" {{ old('pwd') == '1' || old('pwd') === 1 || old('pwd') === true ? 'checked' : '' }}><span>PWD / Person with Disability</span></label>
                <label class="checkbox-wrap"><input type="checkbox" name="senior_citizen" value="1" {{ old('senior_citizen') == '1' || old('senior_citizen') === 1 || old('senior_citizen') === true ? 'checked' : '' }}><span>Senior Citizen</span></label>
                <label class="checkbox-wrap"><input type="checkbox" name="indigenous_people" value="1" {{ old('indigenous_people') == '1' || old('indigenous_people') === 1 || old('indigenous_people') === true ? 'checked' : '' }}><span>Indigenous People</span></label>
                <label class="checkbox-wrap"><input type="checkbox" name="former_ofw" value="1" {{ old('former_ofw') == '1' || old('former_ofw') === 1 || old('former_ofw') === true ? 'checked' : '' }}><span>Former OFW</span></label>
                <label class="checkbox-wrap"><input type="checkbox" name="ofw" value="1" {{ old('ofw') == '1' || old('ofw') === 1 || old('ofw') === true ? 'checked' : '' }}><span>Current OFW</span></label>
                <label class="checkbox-wrap"><input type="checkbox" name="four_ps_beneficiary" value="1" {{ old('four_ps_beneficiary') == '1' || old('four_ps_beneficiary') === 1 || old('four_ps_beneficiary') === true ? 'checked' : '' }}><span>4Ps Beneficiary</span></label>
            </div>

            <div class="form-group inline-field" style="max-width: 420px; margin-top: 18px;">
                <label for="household_id">Household ID (if 4Ps)</label>
                <input type="text" name="household_id" id="household_id" value="{{ old('household_id') }}" placeholder="Optional">
            </div>
        </div>

        <div class="section-card">
            <div class="section-header">
                <h3>Educational Background</h3>
            </div>

            <div class="education-block">
                <div class="grid-3">
                    <div class="form-group">
                        <label>Level</label>
                        <select name="education_level[]">
                            <option value="">Select</option>
                            <option>Elementary</option>
                            <option>Secondary / Junior High</option>
                            <option>Senior High / K-12</option>
                            <option>Tertiary</option>
                            <option>Technical-Vocational</option>
                            <option>Graduate Studies / Post-graduate</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>School Name</label>
                        <input type="text" name="education_school[]" placeholder="School name">
                    </div>
                    <div class="form-group">
                        <label>Course / Strand / Degree</label>
                        <input type="text" name="education_course[]" placeholder="Course / degree">
                    </div>
                </div>

                <div class="grid-2 education-meta-row">
                    <div class="form-group">
                        <label>Year Graduated</label>
                        <input type="text" name="education_year[]" placeholder="2024">
                    </div>
                    <div class="form-group">
                        <label>Year Level</label>
                        <input type="text" name="education_level_reached[]" placeholder="e.g. 3rd year">
                    </div>
                </div>
            </div>

            <button type="button" class="secondary-button" id="addEducationBtn">Add Education</button>
        </div>

        <div class="section-card">
            <div class="section-header">
                <h3>Training and Experience</h3>
            </div>

            <div class="mini-card">
                <h4>Training / Vocational Course</h4>
                <div class="grid-4">
                    <div class="form-group">
                        <label>Course / Training</label>
                        <input type="text" name="training_course[]" placeholder="Course name">
                    </div>
                    <div class="form-group">
                        <label>Hours</label>
                        <input type="text" name="training_hours[]" placeholder="e.g. 120">
                    </div>
                    <div class="form-group">
                        <label>Institution</label>
                        <input type="text" name="training_institution[]" placeholder="Training provider">
                    </div>
                    <div class="form-group">
                        <label>Certificate</label>
                        <input type="text" name="training_certificate[]" placeholder="N/A">
                    </div>
                </div>
            </div>

            <div class="mini-card">
                <h4>Work Experience</h4>
                <div class="grid-5">
                    <div class="form-group">
                        <label>Company</label>
                        <input type="text" name="company_name[]" placeholder="Employer name">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="company_address[]" placeholder="Company address">
                    </div>
                    <div class="form-group">
                        <label>Position</label>
                        <input type="text" name="position[]" placeholder="Position">
                    </div>
                    <div class="form-group">
                        <label>Months</label>
                        <input type="text" name="months[]" placeholder="e.g. 12">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="work_status[]">
                            <option value="">Select</option>
                            <option>Permanent</option>
                            <option>Contractual</option>
                            <option>Part-time</option>
                            <option>Probationary</option>
                            <option>Other</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mini-card">
                <h4>Skills</h4>
                <div class="check-grid compact">
                    <label class="checkbox-wrap"><input type="checkbox" name="skills_list[]" value="Auto Mechanic"><span>Auto Mechanic</span></label>
                    <label class="checkbox-wrap"><input type="checkbox" name="skills_list[]" value="Beautician"><span>Beautician</span></label>
                    <label class="checkbox-wrap"><input type="checkbox" name="skills_list[]" value="Carpentry Work"><span>Carpentry Work</span></label>
                    <label class="checkbox-wrap"><input type="checkbox" name="skills_list[]" value="Computer Literate"><span>Computer Literate</span></label>
                    <label class="checkbox-wrap"><input type="checkbox" name="skills_list[]" value="Domestic Chores"><span>Domestic Chores</span></label>
                    <label class="checkbox-wrap"><input type="checkbox" name="skills_list[]" value="Driver"><span>Driver</span></label>
                    <label class="checkbox-wrap"><input type="checkbox" name="skills_list[]" value="Electrician"><span>Electrician</span></label>
                    <label class="checkbox-wrap"><input type="checkbox" name="skills_list[]" value="Embroider"><span>Embroider</span></label>
                    <label class="checkbox-wrap"><input type="checkbox" name="skills_list[]" value="Gardening"><span>Gardening</span></label>
                    <label class="checkbox-wrap"><input type="checkbox" name="skills_list[]" value="Masonry"><span>Masonry</span></label>
                    <label class="checkbox-wrap"><input type="checkbox" name="skills_list[]" value="Photography"><span>Photography</span></label>
                    <label class="checkbox-wrap"><input type="checkbox" name="skills_list[]" value="Plumbing"><span>Plumbing</span></label>
                </div>
            </div>

            <div class="mini-card">
                <h4>Language / Dialect Proficiency</h4>
                <div class="language-grid">
                    <div class="language-item">
                        <label>English</label>
                        <div class="lang-flags">
                            <label><input type="checkbox" name="language_english[]" value="Read"> Read</label>
                            <label><input type="checkbox" name="language_english[]" value="Write"> Write</label>
                            <label><input type="checkbox" name="language_english[]" value="Speak"> Speak</label>
                            <label><input type="checkbox" name="language_english[]" value="Understand"> Understand</label>
                        </div>
                    </div>
                    <div class="language-item">
                        <label>Filipino</label>
                        <div class="lang-flags">
                            <label><input type="checkbox" name="language_filipino[]" value="Read"> Read</label>
                            <label><input type="checkbox" name="language_filipino[]" value="Write"> Write</label>
                            <label><input type="checkbox" name="language_filipino[]" value="Speak"> Speak</label>
                            <label><input type="checkbox" name="language_filipino[]" value="Understand"> Understand</label>
                        </div>
                    </div>
                    <div class="language-item">
                        <label>Mandarin</label>
                        <div class="lang-flags">
                            <label><input type="checkbox" name="language_mandarin[]" value="Read"> Read</label>
                            <label><input type="checkbox" name="language_mandarin[]" value="Write"> Write</label>
                            <label><input type="checkbox" name="language_mandarin[]" value="Speak"> Speak</label>
                            <label><input type="checkbox" name="language_mandarin[]" value="Understand"> Understand</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-card">
            <div class="section-header">
                <h3>Program Application</h3>
            </div>

            <div class="program-cards">
                <label class="program-card">
                    <input type="radio" name="program_id" value="{{ $programs->firstWhere('code', 'GIP')?->id ?? '' }}" {{ old('program_id') == ($programs->firstWhere('code', 'GIP')?->id ?? '') ? 'checked' : '' }} required>
                    <span class="program-pill blue">GIP</span>
                    <strong>Government Internship Program</strong>
                </label>
                <label class="program-card">
                    <input type="radio" name="program_id" value="{{ $programs->firstWhere('code', 'SPES')?->id ?? '' }}" {{ old('program_id') == ($programs->firstWhere('code', 'SPES')?->id ?? '') ? 'checked' : '' }} required>
                    <span class="program-pill yellow">SPES</span>
                    <strong>Special Program for Employment of Students</strong>
                </label>
                <label class="program-card">
                    <input type="radio" name="program_id" value="{{ $programs->firstWhere('code', 'JOB')?->id ?? '' }}" {{ old('program_id') == ($programs->firstWhere('code', 'JOB')?->id ?? '') ? 'checked' : '' }} required>
                    <span class="program-pill red">JOB</span>
                    <strong>Job Seeker / National Skills Registration Program</strong>
                </label>
            </div>

            <div class="mini-card">
                <h4>Program-Specific Fields</h4>
                <div class="program-specific-block" data-program-block="GIP">
                    <div class="grid-2">
                        <div class="form-group">
                            <label for="purpose_or_position">Purpose / Position Requested <span>*</span></label>
                            <input type="text" name="purpose_or_position" id="purpose_or_position" value="{{ old('purpose_or_position') }}" placeholder="e.g. Administrative Support, OJT, Student employability" required>
                        </div>
                        <div class="form-group">
                            <label for="place_or_agency">Preferred Place / Agency</label>
                            <input type="text" name="place_or_agency" id="place_or_agency" value="{{ old('place_or_agency') }}" placeholder="Optional">
                        </div>
                    </div>
                </div>

                <div class="program-specific-block" data-program-block="SPES">
                    <div class="grid-2">
                        <div class="form-group">
                            <label>GSIS Beneficiary</label>
                            <input type="text" name="spes_gsis_beneficiary" value="{{ old('spes_gsis_beneficiary') }}" placeholder="Name / Relationship">
                        </div>
                        <div class="form-group">
                            <label>Previous SPES Availment</label>
                            <input type="text" name="spes_previous" value="{{ old('spes_previous') }}" placeholder="Yes / No">
                        </div>
                    </div>
                </div>

                <div class="program-specific-block" data-program-block="JOB">
                    <div class="grid-2">
                        <div class="form-group">
                            <label>Preferred Occupation</label>
                            <input type="text" name="preferred_occupation" value="{{ old('preferred_occupation') }}" placeholder="e.g. Encoder, Sales Clerk">
                        </div>
                        <div class="form-group">
                            <label>Preferred Work Location</label>
                            <input type="text" name="preferred_work_location" value="{{ old('preferred_work_location') }}" placeholder="Local / Overseas">
                        </div>
                    </div>
                </div>
            </div>

            <div class="consent-box">
                <div id="consentError" class="error-message" role="alert" aria-live="polite" hidden></div>

                <label class="checkbox-wrap consent-check">
                    <input type="checkbox" name="consent_certified" value="1" {{ old('consent_certified') == '1' || old('consent_certified') === 1 || old('consent_certified') === true ? 'checked' : '' }} required>
                    <span>I certify that the information I have provided is true and correct to the best of my knowledge.</span>
                </label>
                <label class="checkbox-wrap consent-check">
                    <input type="checkbox" name="data_privacy_consent" value="1" {{ old('data_privacy_consent') == '1' || old('data_privacy_consent') === 1 || old('data_privacy_consent') === true ? 'checked' : '' }} required>
                    <span>I acknowledge and agree to the PESO data privacy and consent terms for this application.</span>
                </label>
            </div>
        </div>

        <div class="submit-wrap">
            <button type="submit" class="primary-button" id="submitBtn">Submit Application</button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
.unified-form-shell {
        max-width: 1080px;
        margin: 0 auto;
        padding: 8px 0 40px;
    }

    .form-intro {
        text-align: center;
        margin-bottom: 24px;
        padding: 0 12px;
    }

    .eyebrow {
        font-size: 11px;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--peso-blue);
        font-weight: 800;
    }

    .form-intro h2 {
        font-size: clamp(26px, 3vw, 36px);
        font-weight: 800;
        color: var(--peso-blue-dark);
        margin: 8px 0 0;
        letter-spacing: -0.03em;
    }

    .form-intro p {
        color: var(--text-secondary);
        max-width: 720px;
        margin: 10px auto 0;
        line-height: 1.6;
    }

    .address-block {
        background: #F8FAFC;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 18px;
        margin-top: 14px;
    }

    .address-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 16px;
    }

    .loading-text {
        font-size: 12px;
        color: var(--peso-blue);
        font-weight: 700;
        margin-top: 6px;
        display: inline-block;
    }

    .section-card {
        background: transparent;
        border: 0;
        border-top: 1px solid var(--border-color);
        border-radius: 0;
        padding: 26px 0 0;
        box-shadow: none;
        margin-bottom: 0;
    }

    .section-header {
        margin-bottom: 18px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border-color);
        display: block;
    }

    .section-header h3 {
        color: var(--peso-blue-dark);
        font-size: 14px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin: 0;
    }

    .grid-3, .grid-4, .grid-5, .grid-2 {
        display: grid;
        gap: 18px;
    }

    .grid-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    .grid-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
    .grid-5 { grid-template-columns: repeat(5, minmax(0, 1fr)); }
    .grid-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        display: flex;
        align-items: flex-start;
        gap: 6px;
        font-weight: 700;
        color: var(--peso-blue-dark);
        font-size: 13px;
        min-height: 20px;
        line-height: 1.4;
    }

    .form-group label span {
        color: var(--peso-red);
        display: inline-block;
        margin-left: 2px;
        flex-shrink: 0;
    }

    .field-hint {
        font-size: 11px;
        color: var(--text-secondary);
        line-height: 1.4;
        margin-top: 0;
    }

    .contact-row {
        align-items: stretch;
    }

    .contact-group {
        justify-content: flex-start;
    }

    .contact-group input,
    .contact-group select,
    .contact-group textarea {
        margin-top: auto;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        min-height: 48px;
        height: 48px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 12px 14px;
        font: inherit;
        background: #fff;
        color: var(--text-primary);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-group textarea {
        min-height: 120px;
        height: auto;
        resize: vertical;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--peso-blue);
        box-shadow: 0 0 0 3px rgba(13, 59, 102, 0.08);
    }

    .form-group input.invalid,
    .form-group select.invalid,
    .form-group textarea.invalid,
    .form-group .invalid {
        border-color: #dc2626 !important;
        background: #fff5f5;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.08) !important;
    }

    .checkbox-row, .check-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 12px 18px;
        margin-top: 10px;
    }

    .checkbox-wrap {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--text-primary);
        font-weight: 600;
        line-height: 1.4;
    }

    .checkbox-wrap input {
        accent-color: var(--peso-blue);
    }

    .consent-box {
        margin-top: 20px;
        padding: 16px;
        background: #F8FAFC;
        border: 1px solid rgba(13, 59, 102, 0.1);
        border-radius: 12px;
    }

    .consent-check {
        margin-bottom: 12px;
    }

    .error-message {
        background: #fff5f5;
        border: 1px solid rgba(220, 38, 38, 0.18);
        border-left: 4px solid var(--peso-red);
        color: var(--peso-red-dark);
        border-radius: 10px;
        padding: 10px 12px;
        margin-bottom: 12px;
        font-size: 12px;
        font-weight: 700;
    }

    .alert-error {
        background: #fff5f5;
        border: 1px solid rgba(220, 38, 38, 0.18);
        border-left: 4px solid var(--peso-red);
        color: var(--peso-red-dark);
        border-radius: 10px;
        padding: 12px 14px;
        margin-bottom: 20px;
    }

    .alert-error ul {
        margin: 8px 0 0 18px;
    }

    .secondary-button, .primary-button {
        border: none;
        border-radius: 10px;
        padding: 12px 20px;
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition);
    }

    .secondary-button {
        background: #EEF2F7;
        color: var(--peso-blue-dark);
    }

    .primary-button {
        background: linear-gradient(135deg, var(--peso-blue), var(--peso-blue-dark));
        color: #fff;
    }

    .hidden {
        display: none !important;
    }

    .submit-wrap {
        display: flex;
        justify-content: center;
        margin-top: 18px;
        margin-bottom: 30px;
    }

    .primary-button {
        min-width: 220px;
    }

    .mini-card {
        background: #F8FAFC;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 18px;
        margin-top: 16px;
    }

    .mini-card h4 {
        margin: 0 0 14px;
        color: var(--peso-blue-dark);
        font-size: 16px;
        font-weight: 700;
    }

    .compact {
        gap: 8px 14px;
    }

    .education-block {
        display: grid;
        gap: 18px;
        padding: 18px;
        background: #F8FAFC;
        border: 1px solid var(--border-color);
        border-radius: 12px;
    }

    .education-meta-row {
        margin-top: 2px;
    }

    .language-grid {
        display: grid;
        gap: 16px;
    }

    .language-item {
        padding: 12px 14px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        background: #fff;
    }

    .language-item label {
        display: block;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .lang-flags {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .lang-flags label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
        margin-bottom: 0;
    }

    .program-cards {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .program-card {
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 10px;
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 18px 16px;
        min-height: 140px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .program-card input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    .program-card:hover {
        border-color: var(--peso-blue);
        box-shadow: 0 4px 12px rgba(13, 59, 102, 0.08);
    }

    .program-card.selected {
        border-color: var(--peso-blue);
        box-shadow: 0 0 0 3px rgba(13, 59, 102, 0.08);
        background: #f8fbff;
    }

    .program-card strong {
        font-size: 18px;
        color: var(--peso-blue-dark);
    }

    .program-pill {
        display: inline-flex;
        align-self: flex-start;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .program-pill.blue { background: var(--peso-blue-light); color: var(--peso-blue); }
    .program-pill.yellow { background: var(--peso-yellow-light); color: var(--peso-yellow-dark); }
    .program-pill.red { background: var(--peso-red-light); color: var(--peso-red-dark); }

    .program-specific-block {
        display: none;
        margin-top: 14px;
    }

    .program-specific-block.active {
        display: block;
    }

    @media (max-width: 960px) {
        .grid-5, .grid-4, .grid-3, .grid-2, .program-cards {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 640px) {
        .grid-5, .grid-4, .grid-3, .grid-2, .program-cards, .address-row {
            grid-template-columns: 1fr;
        }

        .primary-button {
            width: 100%;
        }

        .public-card {
            border-radius: 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('unifiedApplicantForm');
        const sameAsPresent = document.getElementById('same_as_present_address');
        const oldSameAsPresentValue = @json(old('same_as_present_address'));
        const programCards = document.querySelectorAll('.program-card input[name="program_id"]');
        const programBlocks = document.querySelectorAll('.program-specific-block');
        const addEducationBtn = document.getElementById('addEducationBtn');
        const mobileInputs = document.querySelectorAll('[data-mobile-input]');
        const consentError = document.getElementById('consentError');

        if (sameAsPresent && String(oldSameAsPresentValue) !== '1') {
            sameAsPresent.checked = false;
        }

        function showConsentError(message) {
            if (!consentError) return;
            consentError.textContent = message;
            consentError.hidden = false;
        }

        function hideConsentError() {
            if (!consentError) return;
            consentError.textContent = '';
            consentError.hidden = true;
        }

        mobileInputs.forEach(function (input) {
            input.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '').slice(0, 11);
            });
        });

        const addressConfig = {
            present: {
                country: document.getElementById('present_country'),
                region: document.getElementById('present_region'),
                province: document.getElementById('present_province'),
                cityMunicipality: document.getElementById('present_city_municipality'),
                barangay: document.getElementById('present_barangay'),
                street: document.getElementById('present_street')
            },
            permanent: {
                country: document.getElementById('permanent_country'),
                region: document.getElementById('permanent_region'),
                province: document.getElementById('permanent_province'),
                cityMunicipality: document.getElementById('permanent_city_municipality'),
                barangay: document.getElementById('permanent_barangay'),
                street: document.getElementById('permanent_street')
            }
        };

        const oldAddressValues = {
            present: {
                country: @json(old('present_country', 'Philippines')),
                region: @json(old('present_region')),
                province: @json(old('present_province')),
                cityMunicipality: @json(old('present_city_municipality')),
                barangay: @json(old('present_barangay')),
                street: @json(old('present_street'))
            },
            permanent: {
                country: @json(old('permanent_country', 'Philippines')),
                region: @json(old('permanent_region')),
                province: @json(old('permanent_province')),
                cityMunicipality: @json(old('permanent_city_municipality')),
                barangay: @json(old('permanent_barangay')),
                street: @json(old('permanent_street'))
            }
        };

        function setLoading(select, text) {
            if (!select) return;
            select.disabled = true;
            select.innerHTML = '<option value="">' + text + '</option>';
        }

        function populateSelect(select, placeholder, items, selectedValue = null) {
            if (!select) return;

            const options = ['<option value="">' + placeholder + '</option>'];
            items.forEach(function (item) {
                options.push('<option value="' + item.value + '">' + item.label + '</option>');
            });
            select.innerHTML = options.join('');
            select.disabled = false;

            if (selectedValue !== null && selectedValue !== '') {
                const exists = Array.from(select.options).some(function (option) {
                    return String(option.value) === String(selectedValue);
                });
                if (exists) {
                    select.value = selectedValue;
                }
            }
        }

        function clearDependentChain(type, level) {
            const chain = ['region', 'province', 'cityMunicipality', 'barangay'];
            const index = chain.indexOf(level);
            for (let i = index + 1; i < chain.length; i++) {
                const key = chain[i];
                const field = addressConfig[type][key === 'cityMunicipality' ? 'cityMunicipality' : key];
                if (!field) continue;
                field.innerHTML = '<option value="">Select ' + (key === 'cityMunicipality' ? 'City / Municipality' : key === 'barangay' ? 'Barangay' : key.charAt(0).toUpperCase() + key.slice(1)) + '</option>';
                field.disabled = true;
            }
        }

        function setSelectOptions(target, source) {
            if (!target || !source) return;
            const options = Array.from(source.options).map(function (option) {
                return {
                    value: option.value,
                    text: option.textContent
                };
            });

            target.innerHTML = options.map(function (option) {
                return '<option value="' + option.value + '">' + option.text + '</option>';
            }).join('');

            if (source.value) {
                target.value = source.value;
            }
        }

        async function loadRegions(select, selectedValue) {
            select.disabled = true;
            setLoading(select, 'Loading regions...');
            try {
                const response = await fetch('/api/geography/regions?country=Philippines');
                if (!response.ok) {
                    throw new Error('Region request failed');
                }
                const data = await response.json();
                const items = Array.isArray(data) ? data : [];
                populateSelect(select, 'Select Region', items.map(function (item) {
                    return { value: String(item.id), label: item.name };
                }), selectedValue || '');
                select.disabled = false;
            } catch (error) {
                populateSelect(select, 'Select Region', []);
                select.disabled = false;
            }
        }

        async function loadProvinces(regionId, select, selectedValue) {
            select.disabled = true;
            setLoading(select, 'Loading provinces...');
            try {
                const response = await fetch('/api/geography/provinces?region_id=' + encodeURIComponent(regionId));
                if (!response.ok) {
                    throw new Error('Province request failed');
                }
                const data = await response.json();
                const items = Array.isArray(data) ? data : [];
                populateSelect(select, 'Select Province', items.map(function (item) {
                    return { value: String(item.id), label: item.name };
                }), selectedValue || '');
                select.disabled = false;
            } catch (error) {
                populateSelect(select, 'Select Province', []);
                select.disabled = false;
            }
        }

        async function loadCities(provinceId, select, selectedValue) {
            select.disabled = true;
            setLoading(select, 'Loading cities/municipalities...');
            try {
                const response = await fetch('/api/geography/cities-municipalities?province_id=' + encodeURIComponent(provinceId));
                if (!response.ok) {
                    throw new Error('City request failed');
                }
                const data = await response.json();
                const items = Array.isArray(data) ? data : [];
                populateSelect(select, 'Select City / Municipality', items.map(function (item) {
                    return { value: String(item.id), label: item.name + (item.type ? ' (' + item.type + ')' : '') };
                }), selectedValue || '');
                select.disabled = false;
            } catch (error) {
                populateSelect(select, 'Select City / Municipality', []);
                select.disabled = false;
            }
        }

        async function loadBarangays(cityId, select, selectedValue) {
            select.disabled = true;
            setLoading(select, 'Loading barangays...');
            try {
                const response = await fetch('/api/geography/barangays?city_municipality_id=' + encodeURIComponent(cityId));
                if (!response.ok) {
                    throw new Error('Barangay request failed');
                }
                const data = await response.json();
                const items = Array.isArray(data) ? data : [];
                populateSelect(select, 'Select Barangay', items.map(function (item) {
                    return { value: String(item.id), label: item.name };
                }), selectedValue || '');
                select.disabled = false;
            } catch (error) {
                populateSelect(select, 'Select Barangay', []);
                select.disabled = false;
            }
        }

        function bindAddress(type) {
            const selected = addressConfig[type];
            if (!selected.country || !selected.region || !selected.province || !selected.cityMunicipality || !selected.barangay) return;

            selected.country.addEventListener('change', function () {
                if (this.value !== 'Philippines') {
                    selected.region.disabled = true;
                    selected.province.disabled = true;
                    selected.cityMunicipality.disabled = true;
                    selected.barangay.disabled = true;
                    return;
                }
                clearDependentChain(type, 'region');
                loadRegions(selected.region, '');
            });

            selected.region.addEventListener('change', function () {
                const regionId = this.value;
                clearDependentChain(type, 'region');
                if (!regionId) return;
                loadProvinces(regionId, selected.province, '');
            });

            selected.province.addEventListener('change', function () {
                const provinceId = this.value;
                clearDependentChain(type, 'province');
                if (!provinceId) return;
                loadCities(provinceId, selected.cityMunicipality, '');
            });

            selected.cityMunicipality.addEventListener('change', function () {
                const cityId = this.value;
                clearDependentChain(type, 'cityMunicipality');
                if (!cityId) return;
                loadBarangays(cityId, selected.barangay, '');
            });
        }

        function initializeAddress(type) {
            const selected = addressConfig[type];
            if (!selected.country) return;

            selected.country.value = 'Philippines';
            bindAddress(type);
            loadRegions(selected.region, oldAddressValues[type].region || '');
        }

        initializeAddress('present');
        initializeAddress('permanent');

        function updatePermanentAddressState() {
            const permanent = addressConfig.permanent;
            const present = addressConfig.present;
            const usePresent = !!(sameAsPresent && sameAsPresent.checked);

            ['country', 'region', 'province', 'cityMunicipality', 'barangay', 'street'].forEach(function (fieldName) {
                const field = permanent[fieldName === 'cityMunicipality' ? 'cityMunicipality' : fieldName];
                if (!field) return;
                field.disabled = usePresent;
                field.required = !usePresent;
            });

            if (usePresent) {
                permanent.country.value = present.country.value || 'Philippines';
                if (present.region && present.region.options.length) {
                    setSelectOptions(permanent.region, present.region);
                }
                if (present.province && present.province.options.length) {
                    setSelectOptions(permanent.province, present.province);
                }
                if (present.cityMunicipality && present.cityMunicipality.options.length) {
                    setSelectOptions(permanent.cityMunicipality, present.cityMunicipality);
                }
                if (present.barangay && present.barangay.options.length) {
                    setSelectOptions(permanent.barangay, present.barangay);
                }
                permanent.street.value = present.street.value || oldAddressValues.permanent.street || '';
            } else {
                permanent.street.value = oldAddressValues.permanent.street || permanent.street.value || '';
                if (!oldAddressValues.permanent.street) {
                    permanent.street.value = '';
                }
            }
        }

        if (sameAsPresent) {
            sameAsPresent.addEventListener('change', function () {
                updatePermanentAddressState();
            });
        }

        updatePermanentAddressState();

        function updateSelectedProgramCard() {
            const selectedValue = form.querySelector('input[name="program_id"]:checked')?.value;
            const gipValue = String('{{ $programs->firstWhere("code", "GIP")?->id ?? "" }}');
            const spesValue = String('{{ $programs->firstWhere("code", "SPES")?->id ?? "" }}');
            const jobValue = String('{{ $programs->firstWhere("code", "JOB")?->id ?? "" }}');

            programCards.forEach(function (radio) {
                const card = radio.closest('.program-card');
                if (!card) return;
                card.classList.toggle('selected', radio.checked);
            });

            programBlocks.forEach(function (block) {
                const matches = (block.dataset.programBlock === 'GIP' && String(selectedValue) === gipValue) ||
                    (block.dataset.programBlock === 'SPES' && String(selectedValue) === spesValue) ||
                    (block.dataset.programBlock === 'JOB' && String(selectedValue) === jobValue);

                block.classList.toggle('active', matches);
            });
        }

        programCards.forEach(function (radio) {
            radio.addEventListener('change', function () {
                updateSelectedProgramCard();
            });
        });

        updateSelectedProgramCard();

        if (addEducationBtn) {
            addEducationBtn.addEventListener('click', function () {
                const block = document.querySelector('.education-block');
                if (block) {
                    const clone = block.cloneNode(true);
                    block.parentNode.insertBefore(clone, addEducationBtn);
                }
            });
        }

        function clearValidationStates() {
            form.querySelectorAll('input, select, textarea').forEach(function (field) {
                field.classList.remove('invalid');
            });
        }

        function markInvalid(field, message) {
            if (!field) return;
            field.classList.add('invalid');
            field.focus();
            field.scrollIntoView({ behavior: 'smooth', block: 'center' });
            field.setCustomValidity(message);
            field.reportValidity();
            field.setCustomValidity('');
        }

        if (form) {
            form.addEventListener('submit', function (event) {
                clearValidationStates();
                hideConsentError();

                const selectedProgram = form.querySelector('input[name="program_id"]:checked');
                const isipGip = selectedProgram && String(selectedProgram.value) === String('{{ $programs->firstWhere("code", "GIP")?->id ?? "" }}');
                const purposeField = form.querySelector('#purpose_or_position');
                if (isipGip && purposeField && !purposeField.value.trim()) {
                    event.preventDefault();
                    markInvalid(purposeField, 'Purpose or position is required. Please fill it out before submitting.');
                    return false;
                }

                const requiredFields = Array.from(form.querySelectorAll('[required]'));
                let invalid = null;

                for (const field of requiredFields) {
                    if (field.id === 'purpose_or_position' && !isipGip) {
                        continue;
                    }

                    if (field.type === 'checkbox') {
                        if (!field.checked) {
                            invalid = field;
                            break;
                        }
                        continue;
                    }
                    if (!field.value.trim()) {
                        invalid = field;
                        break;
                    }
                }

                if (invalid) {
                    event.preventDefault();
                    markInvalid(invalid, 'This field is required. Please fill it in before submitting.');
                    return false;
                }

                const consentChecked = form.querySelector('input[name="consent_certified"]:checked') && form.querySelector('input[name="data_privacy_consent"]:checked');
                if (!consentChecked) {
                    event.preventDefault();
                    const consentBox = document.querySelector('.consent-box');
                    if (consentBox) {
                        consentBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    showConsentError('Please check the required consent and privacy declaration before submitting.');
                    return false;
                }
            });
        }
    });
</script>
@endpush

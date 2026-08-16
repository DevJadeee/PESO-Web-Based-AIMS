<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Applicant;
use App\Models\EmploymentProgram;
use App\Models\Application;
use App\Models\ActivityLog;
use App\Models\Region;
use App\Models\Province;
use App\Models\CityMunicipality;
use App\Models\Barangay;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@pesoagoo.gov.ph'],
            [
                'name' => 'PESO Administrator',
                'username' => 'admin',
                'role' => 'super_admin',
                'contact_number' => '09171234567',
                'password' => Hash::make('password123'),
            ]
        );

        $this->seedPhilippineGeography();

        // 2. Create Employment Programs
        $gip = EmploymentProgram::updateOrCreate(
            ['code' => 'GIP'],
            [
                'name' => 'Government Internship Program',
                'description' => 'Provides opportunities to young workers to demonstrate their talents and skills in public service.',
                'badge_color' => 'blue',
                'is_active' => true,
            ]
        );

        $job = EmploymentProgram::updateOrCreate(
            ['code' => 'JOB'],
            [
                'name' => 'Job Placement & Referral',
                'description' => 'Connects jobseekers with local, regional, and national employment opportunities.',
                'badge_color' => 'red',
                'is_active' => true,
            ]
        );

        $spes = EmploymentProgram::updateOrCreate(
            ['code' => 'SPES'],
            [
                'name' => 'Special Program for Employment of Students',
                'description' => 'Assists poor but deserving students and out-of-school youth in pursuing their education by providing employment during summer or Christmas vacations.',
                'badge_color' => 'green',
                'is_active' => true,
            ]
        );

        // 3. Create Sample Applicants
        $sampleApplicantsData = [
            [
                'applicant_code' => 'PESO-AGOO-2026-0001',
                'first_name' => 'Juan',
                'middle_name' => 'Santos',
                'last_name' => 'Dela Cruz',
                'suffix' => null,
                'birth_date' => '2001-05-14',
                'gender' => 'Male',
                'civil_status' => 'Single',
                'contact_number' => '09171234567',
                'email' => 'juan.delacruz@example.com',
                'barangay' => 'Poblacion',
                'address' => '123 Main Street, Brgy. Poblacion, Agoo, La Union',
                'educational_attainment' => 'College Graduate',
                'course_or_major' => 'BS Information Technology',
                'skills' => 'Computer Troubleshooting, Web Development, Data Entry',
                'emergency_contact_name' => 'Maria Dela Cruz',
                'emergency_contact_number' => '09189876543',
            ],
            [
                'applicant_code' => 'PESO-AGOO-2026-0002',
                'first_name' => 'Maria',
                'middle_name' => 'Clara',
                'last_name' => 'Valdez',
                'suffix' => null,
                'birth_date' => '2003-08-22',
                'gender' => 'Female',
                'civil_status' => 'Single',
                'contact_number' => '09283456789',
                'email' => 'maria.valdez@example.com',
                'barangay' => 'San Antonio',
                'address' => '45 Beach View, Brgy. San Antonio, Agoo, La Union',
                'educational_attainment' => 'College Undergraduate',
                'course_or_major' => 'BS Business Administration',
                'skills' => 'Customer Service, Records Management, Excel',
                'emergency_contact_name' => 'Pedro Valdez',
                'emergency_contact_number' => '09201112233',
            ],
            [
                'applicant_code' => 'PESO-AGOO-2026-0003',
                'first_name' => 'Mark',
                'middle_name' => 'Anthony',
                'last_name' => 'Flores',
                'suffix' => 'Jr.',
                'birth_date' => '2002-11-10',
                'gender' => 'Male',
                'civil_status' => 'Single',
                'contact_number' => '09395556677',
                'email' => 'mark.flores@example.com',
                'barangay' => 'Consolacion',
                'address' => '88 Mabini St, Brgy. Consolacion, Agoo, La Union',
                'educational_attainment' => 'High School',
                'course_or_major' => 'STEM Strand',
                'skills' => 'Encoder, Driver, Communication',
                'emergency_contact_name' => 'Rosa Flores',
                'emergency_contact_number' => '09398889900',
            ],
            [
                'applicant_code' => 'PESO-AGOO-2026-0004',
                'first_name' => 'Angelica',
                'middle_name' => 'Reyes',
                'last_name' => 'Ramos',
                'suffix' => null,
                'birth_date' => '2000-02-18',
                'gender' => 'Female',
                'civil_status' => 'Married',
                'contact_number' => '09456667788',
                'email' => 'angelica.ramos@example.com',
                'barangay' => 'Santa Barbara',
                'address' => '12 Highway Lane, Brgy. Santa Barbara, Agoo, La Union',
                'educational_attainment' => 'College Graduate',
                'course_or_major' => 'BS Education',
                'skills' => 'Teaching, Administrative Support, Public Speaking',
                'emergency_contact_name' => 'Jose Ramos',
                'emergency_contact_number' => '09451122334',
            ],
            [
                'applicant_code' => 'PESO-AGOO-2026-0005',
                'first_name' => 'Christian',
                'middle_name' => 'Gomez',
                'last_name' => 'Bautista',
                'suffix' => null,
                'birth_date' => '2004-09-05',
                'gender' => 'Male',
                'civil_status' => 'Single',
                'contact_number' => '09567778899',
                'email' => 'christian.bautista@example.com',
                'barangay' => 'San Nicolas East',
                'address' => '77 Market St, Brgy. San Nicolas East, Agoo, La Union',
                'educational_attainment' => 'High School',
                'course_or_major' => 'TVL Strand',
                'skills' => 'Electrical Wiring, Aircon Technician, Encoding',
                'emergency_contact_name' => 'Grace Bautista',
                'emergency_contact_number' => '09564455667',
            ]
        ];

        foreach ($sampleApplicantsData as $index => $data) {
            $applicant = Applicant::updateOrCreate(['applicant_code' => $data['applicant_code']], $data);

            // Seed Applications
            if ($index == 0) {
                // Juan has GIP and JOB
                Application::create([
                    'application_number' => 'APP-GIP-2026-001',
                    'applicant_id' => $applicant->id,
                    'program_id' => $gip->id,
                    'purpose_or_position' => 'IT Support Intern',
                    'place_or_agency' => 'Municipal Hall Agoo - IT Department',
                    'time_in' => '08:15 AM',
                    'status' => 'Approved',
                    'submission_date' => Carbon::now()->subDays(5),
                    'remarks' => 'Complete requirements submitted.',
                ]);

                Application::create([
                    'application_number' => 'APP-JOB-2026-001',
                    'applicant_id' => $applicant->id,
                    'program_id' => $job->id,
                    'purpose_or_position' => 'Software Developer Specialist',
                    'place_or_agency' => 'Subcontracted IT Firm',
                    'time_in' => '09:30 AM',
                    'status' => 'Under Review',
                    'submission_date' => Carbon::now()->subDays(1),
                    'remarks' => 'Referred for technical assessment.',
                ]);
            } elseif ($index == 1) {
                // Maria has SPES
                Application::create([
                    'application_number' => 'APP-SPES-2026-001',
                    'applicant_id' => $applicant->id,
                    'program_id' => $spes->id,
                    'purpose_or_position' => 'Administrative Assistant - Student Trainee',
                    'place_or_agency' => 'PESO Office Agoo',
                    'time_in' => '08:00 AM',
                    'status' => 'Approved',
                    'submission_date' => Carbon::now()->subDays(8),
                    'remarks' => 'Student ID and Indigency Certificate verified.',
                ]);
            } elseif ($index == 2) {
                // Mark has SPES
                Application::create([
                    'application_number' => 'APP-SPES-2026-002',
                    'applicant_id' => $applicant->id,
                    'program_id' => $spes->id,
                    'purpose_or_position' => 'Library Assistant - SPES Youth',
                    'place_or_agency' => 'Agoo Municipal Library',
                    'time_in' => '08:45 AM',
                    'status' => 'Pending',
                    'submission_date' => Carbon::now()->subDays(2),
                    'remarks' => 'Awaiting evaluation of report card.',
                ]);
            } elseif ($index == 3) {
                // Angelica has GIP
                Application::create([
                    'application_number' => 'APP-GIP-2026-002',
                    'applicant_id' => $applicant->id,
                    'program_id' => $gip->id,
                    'purpose_or_position' => 'Government Records Intern',
                    'place_or_agency' => 'Municipal Assessor Office',
                    'time_in' => '08:10 AM',
                    'status' => 'Completed',
                    'submission_date' => Carbon::now()->subDays(15),
                    'remarks' => 'Internship rendered successfully.',
                ]);
            } else {
                // Christian has JOB Placement
                Application::create([
                    'application_number' => 'APP-JOB-2026-002',
                    'applicant_id' => $applicant->id,
                    'program_id' => $job->id,
                    'purpose_or_position' => 'Technician / Driver Referral',
                    'place_or_agency' => 'Local Cooperative Agoo',
                    'time_in' => '01:30 PM',
                    'status' => 'Approved',
                    'submission_date' => Carbon::now()->subDays(3),
                    'remarks' => 'Qualified for initial interview.',
                ]);
            }
        }

        // Log initial activity
        ActivityLog::create([
            'user_id' => $admin->id,
            'action' => 'SYSTEM_INIT',
            'description' => 'System seeded with administrative user and initial program records.',
            'ip_address' => '127.0.0.1',
        ]);
    }

    protected function seedPhilippineGeography(): void
    {
        $data = require database_path('data/philippine_locations.php');

        $regionMap = [];
        foreach (($data['regions'] ?? []) as $region) {
            $regionModel = Region::updateOrCreate(
                ['code' => $region['code']],
                ['name' => $region['name'], 'country' => $region['country'] ?? 'Philippines']
            );
            $regionMap[(string) $region['code']] = $regionModel->id;
        }

        $provinceMap = [];
        foreach (($data['provinces'] ?? []) as $province) {
            $regionId = $regionMap[(string) $province['region_code']] ?? null;
            if ($regionId === null) {
                continue;
            }

            $provinceModel = Province::updateOrCreate(
                ['code' => $province['code']],
                [
                    'region_id' => $regionId,
                    'name' => $province['name'],
                ]
            );
            $provinceMap[(string) $province['code']] = $provinceModel->id;
        }

        $cityMap = [];
        foreach (($data['cities_municipalities'] ?? []) as $city) {
            $regionId = $regionMap[(string) $city['region_code']] ?? null;
            if ($regionId === null) {
                continue;
            }

            $provinceId = null;
            if (!empty($city['province_code'])) {
                $provinceId = $provinceMap[(string) $city['province_code']] ?? null;
            }

            $cityModel = CityMunicipality::updateOrCreate(
                ['code' => $city['code']],
                [
                    'region_id' => $regionId,
                    'province_id' => $provinceId,
                    'name' => $city['name'],
                    'type' => $city['type'] ?? null,
                ]
            );
            $cityMap[(string) $city['code']] = $cityModel->id;
        }

        foreach (($data['barangays'] ?? []) as $barangay) {
            $cityId = $cityMap[(string) $barangay['city_municipality_code']] ?? null;
            if ($cityId === null) {
                continue;
            }

            Barangay::updateOrCreate(
                ['code' => $barangay['code']],
                [
                    'city_municipality_id' => $cityId,
                    'name' => $barangay['name'],
                ]
            );
        }
    }
}

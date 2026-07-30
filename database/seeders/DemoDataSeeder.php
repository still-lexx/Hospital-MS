<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Specialization;
use App\Models\Ward;
use App\Models\Bed;
use App\Models\OTRoom;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\InventoryItem;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Appointment;
use App\Models\OpdVisit;
use App\Models\OpdVital;
use App\Models\OpdConsultation;
use App\Models\IpdAdmission;
use App\Models\Surgery;
use App\Models\SurgeryTeam;
use App\Models\SurgeryReport;
use App\Models\LabTest;
use App\Models\LabTestRequest;
use App\Models\LabResult;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\PharmacySale;
use App\Models\PharmacySaleItem;
use App\Models\Billing;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\InsuranceClaim;
use App\Models\Hospital;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // ─────────────────────────────────────────
        // 1. HOSPITAL PROFILE
        // Schema: id, name, address, phone, email, logo, footer_text
        // ─────────────────────────────────────────
        Hospital::firstOrCreate(['id' => 1], [
            'name'        => 'Greenfield General Hospital',
            'address'     => '12 Health Avenue, Greenfield City',
            'phone'       => '+234-800-555-0100',
            'email'       => 'info@greenfieldhosp.com',
            'logo'        => null,
            'footer_text' => 'Providing compassionate, world-class healthcare since 2005.',
        ]);

        // ─────────────────────────────────────────
        // 2. DEPARTMENTS
        // Schema: id, name, description, status
        // ─────────────────────────────────────────
        $departmentData = [
            ['name' => 'Cardiology',     'description' => 'Heart and cardiovascular care'],
            ['name' => 'Neurology',      'description' => 'Brain and nervous system disorders'],
            ['name' => 'Orthopedics',    'description' => 'Bones, joints and musculoskeletal system'],
            ['name' => 'Pediatrics',     'description' => 'Medical care for infants and children'],
            ['name' => 'Gynecology',     'description' => 'Female reproductive health and obstetrics'],
            ['name' => 'Oncology',       'description' => 'Cancer diagnosis and treatment'],
            ['name' => 'Dermatology',    'description' => 'Skin, hair and nail conditions'],
            ['name' => 'Emergency',      'description' => 'Acute trauma and emergency services'],
            ['name' => 'Radiology',      'description' => 'Medical imaging and diagnostics'],
            ['name' => 'Pharmacy',       'description' => 'Medication dispensing and management'],
            ['name' => 'Pathology',      'description' => 'Laboratory and diagnostic testing'],
            ['name' => 'Psychiatry',     'description' => 'Mental health and behavioural medicine'],
        ];
        foreach ($departmentData as $dept) {
            Department::firstOrCreate(['name' => $dept['name']], ['description' => $dept['description'], 'status' => 1]);
        }

        // ─────────────────────────────────────────
        // 3. WARDS & BEDS
        // Ward schema: id, name, description, capacity, status
        // Bed schema:  id, ward_id, bed_number, daily_charge, status
        // ─────────────────────────────────────────
        $wardData = [
            ['name' => 'General Ward',   'description' => 'General patient care ward',  'capacity' => 50, 'status' => 'active'],
            ['name' => 'ICU',            'description' => 'Intensive Care Unit',          'capacity' => 20, 'status' => 'active'],
            ['name' => 'Emergency Ward', 'description' => 'Emergency and trauma care',    'capacity' => 30, 'status' => 'active'],
            ['name' => 'Pediatric Ward', 'description' => 'Children and infant care',     'capacity' => 40, 'status' => 'active'],
            ['name' => 'Maternity Ward', 'description' => 'Maternity and obstetrics',     'capacity' => 35, 'status' => 'active'],
            ['name' => 'Cardiac Ward',   'description' => 'Cardiology patients',          'capacity' => 25, 'status' => 'active'],
            ['name' => 'Surgical Ward',  'description' => 'Post-surgical recovery',       'capacity' => 30, 'status' => 'active'],
        ];
        $bedDailyCharges = [2000, 15000, 3000, 2500, 5000, 8000, 4000];
        foreach ($wardData as $wi => $wd) {
            $ward = Ward::firstOrCreate(['name' => $wd['name']], $wd);
            if ($ward->beds()->count() === 0) {
                $prefix = strtoupper(substr($wd['name'], 0, 1));
                for ($b = 1; $b <= 10; $b++) {
                    Bed::firstOrCreate(
                        ['ward_id' => $ward->id, 'bed_number' => $prefix . '-' . str_pad($b, 3, '0', STR_PAD_LEFT)],
                        ['status' => $b <= 7 ? 'occupied' : 'available', 'daily_charge' => $bedDailyCharges[$wi]]
                    );
                }
            }
        }
        $wards = Ward::all()->values();
        $beds  = Bed::all()->values();

        // ─────────────────────────────────────────
        // 4. OT ROOMS
        // Schema: id, room_number, room_name, status, equipment, capacity
        // ─────────────────────────────────────────
        $otRoomData = [
            ['room_number' => 'OT-01', 'room_name' => 'Theatre One',   'status' => 'available',   'equipment' => 'Anaesthesia machine, surgical lights, electrocautery unit', 'capacity' => 8],
            ['room_number' => 'OT-02', 'room_name' => 'Theatre Two',   'status' => 'available',   'equipment' => 'Laparoscopic tower, high-definition camera, CO2 insufflator', 'capacity' => 6],
            ['room_number' => 'OT-03', 'room_name' => 'Cardiac Suite', 'status' => 'available',   'equipment' => 'Heart-lung bypass machine, defibrillator, perfusion unit', 'capacity' => 10],
            ['room_number' => 'OT-04', 'room_name' => 'Ortho Theatre', 'status' => 'occupied',    'equipment' => 'Fluoroscopy C-arm, oscillating saw, implant set', 'capacity' => 7],
            ['room_number' => 'OT-05', 'room_name' => 'Emergency OT',  'status' => 'maintenance', 'equipment' => 'Rapid infusion system, trauma drill set', 'capacity' => 5],
        ];
        foreach ($otRoomData as $otr) {
            OTRoom::firstOrCreate(['room_number' => $otr['room_number']], $otr);
        }
        $otRooms = OTRoom::where('status', 'available')->get();

        // ─────────────────────────────────────────
        // 5. STAFF USERS
        // Schema: id, name, email, password, role, email_verified_at
        // ─────────────────────────────────────────
        $staffData = [
            ['name' => 'Dr. James Okafor',   'email' => 'james.okafor@hms.test',   'spatie_role' => 'doctor',       'role' => 'doctor'],
            ['name' => 'Dr. Amaka Nwosu',    'email' => 'amaka.nwosu@hms.test',    'spatie_role' => 'doctor',       'role' => 'doctor'],
            ['name' => 'Dr. Emeka Eze',      'email' => 'emeka.eze@hms.test',      'spatie_role' => 'doctor',       'role' => 'doctor'],
            ['name' => 'Dr. Ngozi Adeyemi',  'email' => 'ngozi.adeyemi@hms.test',  'spatie_role' => 'doctor',       'role' => 'doctor'],
            ['name' => 'Dr. Chuka Obi',      'email' => 'chuka.obi@hms.test',      'spatie_role' => 'doctor',       'role' => 'doctor'],
            ['name' => 'Dr. Fatima Sule',    'email' => 'fatima.sule@hms.test',    'spatie_role' => 'doctor',       'role' => 'doctor'],
            ['name' => 'Dr. Bola Adeleke',   'email' => 'bola.adeleke@hms.test',   'spatie_role' => 'doctor',       'role' => 'doctor'],
            ['name' => 'Dr. Tunde Lawal',    'email' => 'tunde.lawal@hms.test',    'spatie_role' => 'doctor',       'role' => 'doctor'],
            ['name' => 'Nurse Chioma Agu',   'email' => 'chioma.agu@hms.test',     'spatie_role' => 'nurse',        'role' => 'nurse'],
            ['name' => 'Nurse Kemi Bello',   'email' => 'kemi.bello@hms.test',     'spatie_role' => 'nurse',        'role' => 'nurse'],
            ['name' => 'Nurse Ifeoma Obi',   'email' => 'ifeoma.obi@hms.test',     'spatie_role' => 'nurse',        'role' => 'nurse'],
            ['name' => 'Nurse Aisha Yusuf',  'email' => 'aisha.yusuf@hms.test',    'spatie_role' => 'nurse',        'role' => 'nurse'],
            ['name' => 'Grace Okeke',        'email' => 'grace.okeke@hms.test',    'spatie_role' => 'receptionist', 'role' => 'receptionist'],
            ['name' => 'Samuel Ibe',         'email' => 'samuel.ibe@hms.test',     'spatie_role' => 'receptionist', 'role' => 'receptionist'],
        ];
        $staffUsers = [];
        foreach ($staffData as $s) {
            $user = User::firstOrCreate(
                ['email' => $s['email']],
                ['name' => $s['name'], 'password' => Hash::make('password'), 'email_verified_at' => now(), 'role' => $s['role']]
            );
            $user->syncRoles([$s['spatie_role']]);
            $staffUsers[] = $user;
        }
        $doctorUsers = User::role('doctor')->get();
        $adminUser   = User::where('email', 'admin@admin.com')->first();

        // ─────────────────────────────────────────
        // 6. DOCTOR PROFILES
        // Schema: id, user_id, phone, address, specialization, qualification, experience,
        //         license_number, bio, photo, consultation_fee, is_available
        // ─────────────────────────────────────────
        $doctorProfiles = [
            ['email' => 'james.okafor@hms.test',  'specialization' => 'Cardiology',      'qualification' => 'MBBS, FMCP',      'experience' => 12, 'fee' => 15000, 'available' => true],
            ['email' => 'amaka.nwosu@hms.test',   'specialization' => 'Pediatrics',      'qualification' => 'MBBS, FWACP',     'experience' => 8,  'fee' => 12000, 'available' => true],
            ['email' => 'emeka.eze@hms.test',     'specialization' => 'Neurology',       'qualification' => 'MBBS, FMCPath',   'experience' => 15, 'fee' => 18000, 'available' => true],
            ['email' => 'ngozi.adeyemi@hms.test', 'specialization' => 'Gynecology',      'qualification' => 'MBBS, FMCOG',    'experience' => 10, 'fee' => 14000, 'available' => true],
            ['email' => 'chuka.obi@hms.test',     'specialization' => 'Orthopedics',     'qualification' => 'MBBS, FMCS',     'experience' => 9,  'fee' => 16000, 'available' => true],
            ['email' => 'fatima.sule@hms.test',   'specialization' => 'Dermatology',     'qualification' => 'MBBS, MSc',      'experience' => 6,  'fee' => 10000, 'available' => true],
            ['email' => 'bola.adeleke@hms.test',  'specialization' => 'General Medicine','qualification' => 'MBBS, FMCP',     'experience' => 7,  'fee' => 8000,  'available' => true],
            ['email' => 'tunde.lawal@hms.test',   'specialization' => 'Psychiatry',      'qualification' => 'MBBS, FMCPsych', 'experience' => 11, 'fee' => 13000, 'available' => false],
        ];
        foreach ($doctorProfiles as $dp) {
            $user = User::where('email', $dp['email'])->first();
            if (!$user) continue;
            $spec = Specialization::where('name', $dp['specialization'])->first();
            $doctor = Doctor::firstOrCreate(['user_id' => $user->id], [
                'specialization'   => $dp['specialization'],
                'qualification'    => $dp['qualification'],
                'experience'       => $dp['experience'],
                'consultation_fee' => $dp['fee'],
                'is_available'     => $dp['available'],
                'phone'            => '0801' . rand(1000000, 9999999),
                'bio'              => 'Experienced specialist in ' . $dp['specialization'] . ' with ' . $dp['experience'] . ' years of clinical practice.',
            ]);
            if ($spec) {
                $doctor->specializations()->syncWithoutDetaching([$spec->id]);
            }
        }
        $doctors = Doctor::with('user')->get();

        // ─────────────────────────────────────────
        // 7. DOCTOR SCHEDULES
        // Schema: id, doctor_id, day_of_week, start_time, end_time, slot_duration, is_available, max_patients
        // ─────────────────────────────────────────
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        foreach ($doctors as $doctor) {
            $existingDays = $doctor->schedules()->pluck('day_of_week')->toArray();
            $scheduleDays = array_slice(array_diff($days, $existingDays), 0, 3);
            foreach ($scheduleDays as $day) {
                \App\Models\DoctorSchedule::firstOrCreate(
                    ['doctor_id' => $doctor->id, 'day_of_week' => $day],
                    ['start_time' => '08:00:00', 'end_time' => '14:00:00', 'slot_duration' => 30, 'is_available' => true]
                );
            }
        }

        // ─────────────────────────────────────────
        // 8. PATIENTS
        // Schema: user_id, name, phone, address, gender, date_of_birth, blood_group,
        //         genotype, marital_status, emergency_contact, allergies, conditions, ward_id, admitted, photo
        // ─────────────────────────────────────────
        $streets = ['Aba Road', 'Lagos Street', 'Abuja Crescent', 'Kano Close', 'Enugu Avenue', 'Ogun Way', 'Delta Drive', 'Cross River Lane'];
        $patientsRaw = [
            ['name' => 'Obiageli Nnamdi',     'gender' => 'female', 'dob' => '1985-03-12', 'bg' => 'A+',  'geno' => 'AA', 'ms' => 'married',  'phone' => '08012345671', 'allergy' => 'Penicillin',    'condition' => 'Hypertension'],
            ['name' => 'Chukwuemeka Okonkwo', 'gender' => 'male',   'dob' => '1978-07-20', 'bg' => 'O+',  'geno' => 'AS', 'ms' => 'married',  'phone' => '08012345672', 'allergy' => 'None',          'condition' => 'Diabetes Type 2'],
            ['name' => 'Adaeze Obi',          'gender' => 'female', 'dob' => '1995-11-05', 'bg' => 'B+',  'geno' => 'AA', 'ms' => 'single',   'phone' => '08012345673', 'allergy' => 'Sulfa drugs',   'condition' => 'Asthma'],
            ['name' => 'Babatunde Afolabi',   'gender' => 'male',   'dob' => '1990-01-30', 'bg' => 'AB+', 'geno' => 'AS', 'ms' => 'married',  'phone' => '08012345674', 'allergy' => 'None',          'condition' => 'Malaria (recurrent)'],
            ['name' => 'Halima Garba',        'gender' => 'female', 'dob' => '2002-09-14', 'bg' => 'O-',  'geno' => 'SS', 'ms' => 'single',   'phone' => '08012345675', 'allergy' => 'Aspirin',       'condition' => 'Sickle Cell Disease'],
            ['name' => 'Emmanuel Ugwu',       'gender' => 'male',   'dob' => '1965-06-08', 'bg' => 'A+',  'geno' => 'AA', 'ms' => 'married',  'phone' => '08012345676', 'allergy' => 'None',          'condition' => 'Coronary Artery Disease'],
            ['name' => 'Ngozi Ihejirika',     'gender' => 'female', 'dob' => '1988-04-22', 'bg' => 'B-',  'geno' => 'AC', 'ms' => 'widowed',  'phone' => '08012345677', 'allergy' => 'Codeine',       'condition' => 'Fibroid'],
            ['name' => 'Musa Abdullahi',      'gender' => 'male',   'dob' => '1955-12-01', 'bg' => 'O+',  'geno' => 'AA', 'ms' => 'married',  'phone' => '08012345678', 'allergy' => 'None',          'condition' => 'Chronic Kidney Disease'],
            ['name' => 'Chidinma Okafor',     'gender' => 'female', 'dob' => '1999-08-17', 'bg' => 'A-',  'geno' => 'AS', 'ms' => 'single',   'phone' => '08012345679', 'allergy' => 'Latex',         'condition' => 'Anxiety Disorder'],
            ['name' => 'Rotimi Adesanya',     'gender' => 'male',   'dob' => '1983-02-27', 'bg' => 'AB-', 'geno' => 'AA', 'ms' => 'divorced', 'phone' => '08012345680', 'allergy' => 'None',          'condition' => 'Hypertension, Obesity'],
            ['name' => 'Aisha Mohammed',      'gender' => 'female', 'dob' => '1975-10-10', 'bg' => 'B+',  'geno' => 'AS', 'ms' => 'married',  'phone' => '08012345681', 'allergy' => 'Ibuprofen',     'condition' => 'Breast Cancer (Stage 2)'],
            ['name' => 'Onyeka Ejike',        'gender' => 'male',   'dob' => '2010-05-03', 'bg' => 'O+',  'geno' => 'AA', 'ms' => 'single',   'phone' => '08012345682', 'allergy' => 'None',          'condition' => 'Sickle Cell Trait'],
            ['name' => 'Funke Olawale',       'gender' => 'female', 'dob' => '1970-07-16', 'bg' => 'A+',  'geno' => 'AA', 'ms' => 'married',  'phone' => '08012345683', 'allergy' => 'Penicillin',    'condition' => 'Type 2 Diabetes, Glaucoma'],
            ['name' => 'Ikenna Okereke',      'gender' => 'male',   'dob' => '1992-03-09', 'bg' => 'O+',  'geno' => 'AS', 'ms' => 'married',  'phone' => '08012345684', 'allergy' => 'None',          'condition' => 'Post-Appendectomy'],
            ['name' => 'Yetunde Adeyemi',     'gender' => 'female', 'dob' => '1980-11-25', 'bg' => 'B+',  'geno' => 'AA', 'ms' => 'married',  'phone' => '08012345685', 'allergy' => 'Sulfonamides',  'condition' => 'Rheumatoid Arthritis'],
            ['name' => 'Solomon Dike',        'gender' => 'male',   'dob' => '1967-08-12', 'bg' => 'A+',  'geno' => 'AA', 'ms' => 'married',  'phone' => '08012345686', 'allergy' => 'None',          'condition' => 'Prostate Hypertrophy'],
            ['name' => 'Chinwe Eze',          'gender' => 'female', 'dob' => '2000-06-30', 'bg' => 'O-',  'geno' => 'AS', 'ms' => 'single',   'phone' => '08012345687', 'allergy' => 'None',          'condition' => 'Irregular Menstruation'],
            ['name' => 'Gbenga Akindele',     'gender' => 'male',   'dob' => '1958-04-19', 'bg' => 'AB+', 'geno' => 'AA', 'ms' => 'married',  'phone' => '08012345688', 'allergy' => 'Aspirin',       'condition' => 'Atrial Fibrillation'],
            ['name' => 'Hauwa Ibrahim',       'gender' => 'female', 'dob' => '1993-01-07', 'bg' => 'A+',  'geno' => 'AS', 'ms' => 'married',  'phone' => '08012345689', 'allergy' => 'None',          'condition' => 'Gestational Diabetes'],
            ['name' => 'Tobechukwu Nweze',    'gender' => 'male',   'dob' => '2015-09-22', 'bg' => 'O+',  'geno' => 'AA', 'ms' => 'single',   'phone' => '08012345690', 'allergy' => 'Egg',           'condition' => 'Febrile Convulsion'],
        ];
        $patientModels = [];
        foreach ($patientsRaw as $i => $pd) {
            $patient = Patient::firstOrCreate(['phone' => $pd['phone']], [
                'user_id'           => $adminUser->id,
                'name'              => $pd['name'],
                'gender'            => $pd['gender'],
                'date_of_birth'     => $pd['dob'],
                'blood_group'       => $pd['bg'],
                'genotype'          => $pd['geno'],
                'marital_status'    => $pd['ms'],
                'address'           => rand(1, 99) . ' ' . $streets[array_rand($streets)],
                'emergency_contact' => '080' . rand(10000000, 99999999),
                'allergies'         => $pd['allergy'],
                'conditions'        => $pd['condition'],
                'ward_id'           => $wards[$i % $wards->count()]->id,
                'admitted'          => $i < 8 ? 1 : 0,
                'created_at'        => Carbon::now()->subDays(rand(30, 365)),
            ]);
            $patientModels[] = $patient;
        }

        // ─────────────────────────────────────────
        // 9. APPOINTMENTS
        // Schema: id, patient_id, doctor_id, appointment_date, appointment_time,
        //         appointment_type, status, reason, duration, consultation_fee, notes
        // ─────────────────────────────────────────
        $apptStatuses = ['completed', 'completed', 'completed', 'confirmed', 'pending', 'cancelled'];
        $apptTypes    = ['consultation', 'follow-up', 'emergency', 'checkup'];
        $apptTimes    = ['08:00:00', '09:00:00', '10:00:00', '11:00:00', '14:00:00', '15:00:00', '16:00:00'];
        foreach ($patientModels as $i => $patient) {
            $doctor = $doctors[$i % $doctors->count()];
            foreach (range(1, 3) as $a) {
                Appointment::firstOrCreate(
                    ['patient_id' => $patient->id, 'doctor_id' => $doctor->id, 'appointment_date' => Carbon::now()->subDays(rand(1, 120))->format('Y-m-d')],
                    [
                        'appointment_time' => $apptTimes[array_rand($apptTimes)],
                        'appointment_type' => $apptTypes[array_rand($apptTypes)],
                        'status'           => $apptStatuses[array_rand($apptStatuses)],
                        'reason'           => 'Review and management of ' . $patient->conditions,
                        'duration'         => [15, 20, 30, 45][array_rand([15, 20, 30, 45])],
                        'consultation_fee' => $doctor->consultation_fee,
                        'notes'            => 'Patient presents with complaints related to ' . $patient->conditions,
                    ]
                );
            }
        }
        $appointments = Appointment::all()->values();

        // ─────────────────────────────────────────
        // 10. OPD VISITS + VITALS + CONSULTATIONS
        // OpdVisit schema: id, patient_id, doctor_id(→users), visit_date, reason, status, token_number
        // OpdVital schema:  id, opd_visit_id, weight, height, bp_systolic, bp_diastolic, temperature, pulse, respiratory_rate, spo2
        // OpdConsultation: id, opd_visit_id, diagnosis, symptoms, examination_notes, advice, next_visit_date
        // ─────────────────────────────────────────
        $visitStatuses = ['completed', 'completed', 'in-consultation', 'waiting', 'cancelled'];
        foreach ($patientModels as $i => $patient) {
            $doctorUser = $doctorUsers[$i % $doctorUsers->count()];
            $visitDate  = Carbon::now()->subDays(rand(1, 90));
            $visit = OpdVisit::firstOrCreate(
                ['patient_id' => $patient->id, 'doctor_id' => $doctorUser->id],
                [
                    'visit_date'   => $visitDate->format('Y-m-d H:i:s'),
                    'reason'       => 'Presenting complaint: ' . $patient->conditions,
                    'status'       => $visitStatuses[array_rand($visitStatuses)],
                    'token_number' => 'OPD-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                ]
            );
            OpdVital::firstOrCreate(['opd_visit_id' => $visit->id], [
                'weight'           => round(rand(45, 110) + (rand(0, 9) / 10), 1),
                'height'           => round(rand(155, 195) + (rand(0, 9) / 10), 1),
                'bp_systolic'      => rand(100, 160),
                'bp_diastolic'     => rand(60, 100),
                'temperature'      => round(36 + (rand(0, 20) / 10), 1),
                'pulse'            => rand(60, 100),
                'respiratory_rate' => rand(12, 20),
                'spo2'             => rand(94, 100),
            ]);
            OpdConsultation::firstOrCreate(['opd_visit_id' => $visit->id], [
                'diagnosis'         => 'Confirmed: ' . $patient->conditions,
                'symptoms'          => 'Fatigue, headache, general malaise related to ' . $patient->conditions,
                'examination_notes' => 'Patient appears ' . ['well', 'moderately ill', 'in mild distress'][array_rand(['well', 'moderately ill', 'in mild distress'])],
                'advice'            => 'Prescribed medications, rest and follow-up in 2 weeks.',
                'next_visit_date'   => $visitDate->addDays(14)->format('Y-m-d'),
            ]);
        }

        // ─────────────────────────────────────────
        // 11. IPD ADMISSIONS
        // Schema: id, patient_id, doctor_id(→users), bed_id, admission_date, discharge_date,
        //         reason, status, discharge_summary, deposit_amount
        // ─────────────────────────────────────────
        $admitReasons = [
            'Acute chest pain requiring cardiac monitoring and evaluation',
            'Post-operative recovery following appendectomy',
            'Diabetic ketoacidosis management and stabilisation',
            'Severe malaria with cerebral involvement',
            'Sickle cell vaso-occlusive crisis requiring IV fluids and analgesia',
            'Hypertensive emergency stabilisation',
            'Pre-operative preparation for elective fibroid removal',
            'Severe asthma exacerbation requiring nebulisation therapy',
        ];
        $availableBeds = $beds->filter(fn ($b) => $b->status === 'available')->values();
        if ($availableBeds->isEmpty()) {
            $availableBeds = $beds;
        }
        foreach (array_slice($patientModels, 0, min(8, count($patientModels))) as $i => $patient) {
            $doctorUser = $doctorUsers[$i % $doctorUsers->count()];
            $admitDate  = Carbon::now()->subDays(rand(5, 30));
            IpdAdmission::firstOrCreate(
                ['patient_id' => $patient->id],
                [
                    'doctor_id'        => $doctorUser->id,
                    'bed_id'           => $availableBeds[$i % $availableBeds->count()]->id,
                    'admission_date'   => $admitDate->format('Y-m-d H:i:s'),
                    'discharge_date'   => $i < 4 ? $admitDate->copy()->addDays(rand(3, 10))->format('Y-m-d H:i:s') : null,
                    'reason'           => $admitReasons[$i],
                    'status'           => $i < 4 ? 'discharged' : 'admitted',
                    'discharge_summary'=> $i < 4 ? 'Patient responded well to treatment and discharged in stable condition. Advised follow-up in 2 weeks.' : null,
                    'deposit_amount'   => rand(5000, 50000),
                ]
            );
        }

        // ─────────────────────────────────────────
        // 12. LAB TESTS + REQUESTS + RESULTS
        // LabTest schema: id, name, description, price, category, normal_range, unit, status
        // LabTestRequest: id, patient_id, doctor_id(→users), lab_test_id, request_date, status, priority, notes
        // LabResult: id, lab_test_request_id, result_value, result_date, performed_by(→users), remarks, status
        // ─────────────────────────────────────────
        $labTestsData = [
            ['name' => 'Full Blood Count (FBC)',       'cat' => 'Haematology',   'price' => 3500, 'range' => '4.5-11 x10^9/L',       'unit' => 'x10^9/L'],
            ['name' => 'Fasting Blood Glucose',        'cat' => 'Biochemistry',  'price' => 1500, 'range' => '3.9-5.5 mmol/L',       'unit' => 'mmol/L'],
            ['name' => 'Malaria Parasite (MP)',         'cat' => 'Parasitology',  'price' => 2000, 'range' => 'Negative',              'unit' => ''],
            ['name' => 'Liver Function Test (LFT)',     'cat' => 'Biochemistry',  'price' => 5500, 'range' => 'ALT 7-56 IU/L',        'unit' => 'IU/L'],
            ['name' => 'Kidney Function Test (KFT)',    'cat' => 'Biochemistry',  'price' => 5000, 'range' => 'Creatinine 62-115 µmol/L', 'unit' => 'µmol/L'],
            ['name' => 'Urinalysis',                   'cat' => 'Urinalysis',    'price' => 1200, 'range' => 'No abnormality detected','unit' => ''],
            ['name' => 'HbA1c (Glycated Haemoglobin)', 'cat' => 'Biochemistry',  'price' => 7500, 'range' => '< 5.7%',               'unit' => '%'],
            ['name' => 'Lipid Profile',                'cat' => 'Biochemistry',  'price' => 6000, 'range' => 'Total Chol <5.2 mmol/L','unit' => 'mmol/L'],
            ['name' => 'Thyroid Function Test (TFT)',   'cat' => 'Endocrinology', 'price' => 8000, 'range' => 'TSH 0.4-4.0 mIU/L',   'unit' => 'mIU/L'],
            ['name' => 'HIV Screening (ELISA)',         'cat' => 'Serology',      'price' => 4500, 'range' => 'Non-reactive',          'unit' => ''],
            ['name' => 'Hepatitis B Surface Antigen',  'cat' => 'Serology',      'price' => 3500, 'range' => 'Negative',              'unit' => ''],
            ['name' => 'Genotype (Haemoglobin Type)',  'cat' => 'Haematology',   'price' => 2500, 'range' => 'AA / AS',              'unit' => ''],
            ['name' => 'Blood Group & Rhesus Factor',  'cat' => 'Haematology',   'price' => 1500, 'range' => 'N/A',                  'unit' => ''],
            ['name' => 'Sputum Culture & Sensitivity', 'cat' => 'Microbiology',  'price' => 9500, 'range' => 'No growth',            'unit' => ''],
            ['name' => 'Widal Test',                   'cat' => 'Serology',      'price' => 3000, 'range' => 'Negative',             'unit' => ''],
        ];
        foreach ($labTestsData as $lt) {
            LabTest::firstOrCreate(['name' => $lt['name']], [
                'description' => 'Standard ' . $lt['cat'] . ' test',
                'price'       => $lt['price'],
                'category'    => $lt['cat'],
                'normal_range'=> $lt['range'],
                'unit'        => $lt['unit'],
                'status'      => 'active',
            ]);
        }
        $labTests       = LabTest::all()->values();
        $reqStatuses    = ['completed', 'completed', 'in-progress', 'pending', 'cancelled'];
        $resultStatuses = ['normal', 'normal', 'abnormal', 'critical'];
        foreach ($patientModels as $i => $patient) {
            $labTest   = $labTests[$i % $labTests->count()];
            $reqStatus = $reqStatuses[array_rand($reqStatuses)];
            $request   = LabTestRequest::firstOrCreate(
                ['patient_id' => $patient->id, 'lab_test_id' => $labTest->id],
                [
                    'doctor_id'    => $doctorUsers[$i % $doctorUsers->count()]->id,
                    'request_date' => Carbon::now()->subDays(rand(1, 60))->format('Y-m-d'),
                    'status'       => $reqStatus,
                    'priority'     => ['normal', 'normal', 'urgent'][array_rand(['normal', 'normal', 'urgent'])],
                    'notes'        => 'Requested as part of routine diagnostic workup for ' . $patient->conditions,
                ]
            );
            if ($reqStatus === 'completed') {
                LabResult::firstOrCreate(['lab_test_request_id' => $request->id], [
                    'result_value' => $labTest->normal_range ?? 'Within normal limits',
                    'result_date'  => Carbon::now()->subDays(rand(1, 55))->format('Y-m-d H:i:s'),
                    'performed_by' => $adminUser->id,
                    'remarks'      => 'Result reviewed and documented by attending clinician.',
                    'status'       => $resultStatuses[array_rand($resultStatuses)],
                ]);
            }
        }

        // ─────────────────────────────────────────
        // 13. MEDICAL RECORDS
        // Schema: id, patient_id, doctor_id, appointment_id, record_date, diagnosis, treatment, prescription, notes
        // ─────────────────────────────────────────
        foreach ($patientModels as $i => $patient) {
            $doctor = $doctors[$i % $doctors->count()];
            MedicalRecord::firstOrCreate(
                ['patient_id' => $patient->id, 'doctor_id' => $doctor->id],
                [
                    'appointment_id' => $appointments[$i % $appointments->count()]->id,
                    'record_date'    => Carbon::now()->subDays(rand(10, 180))->format('Y-m-d'),
                    'diagnosis'      => $patient->conditions,
                    'treatment'      => 'Prescribed relevant pharmacological therapy and lifestyle modification.',
                    'prescription'   => 'See attached prescription record.',
                    'notes'          => 'Patient counselled on self-management of ' . $patient->conditions,
                ]
            );
        }

        // ─────────────────────────────────────────
        // 14. PRESCRIPTIONS + PRESCRIPTION ITEMS
        // Prescription schema: id, patient_id, doctor_id(→users), appointment_id, prescription_date, notes, status
        // PrescriptionItem: id, prescription_id, medicine_name, dosage, frequency, duration, quantity, instructions
        // ─────────────────────────────────────────
        $medicines = [
            ['name' => 'Amlodipine 5mg',            'dosage' => '5mg',   'freq' => 'Once daily',         'duration' => '30 days', 'qty' => 30],
            ['name' => 'Metformin 500mg',            'dosage' => '500mg', 'freq' => 'Twice daily',        'duration' => '30 days', 'qty' => 60],
            ['name' => 'Lisinopril 10mg',            'dosage' => '10mg',  'freq' => 'Once daily',         'duration' => '30 days', 'qty' => 30],
            ['name' => 'Artemether/Lumefantrine',    'dosage' => '4 tabs','freq' => 'Twice daily x 3 days','duration' => '3 days', 'qty' => 24],
            ['name' => 'Hydroxyurea 500mg',          'dosage' => '500mg', 'freq' => 'Once daily',         'duration' => '30 days', 'qty' => 30],
            ['name' => 'Salbutamol Inhaler 100mcg',  'dosage' => '2 puffs','freq' => 'As needed (PRN)',   'duration' => '30 days', 'qty' => 1],
            ['name' => 'Ibuprofen 400mg',            'dosage' => '400mg', 'freq' => 'Three times daily',  'duration' => '7 days',  'qty' => 21],
            ['name' => 'Amoxicillin 500mg',          'dosage' => '500mg', 'freq' => 'Three times daily',  'duration' => '7 days',  'qty' => 21],
            ['name' => 'Omeprazole 20mg',            'dosage' => '20mg',  'freq' => 'Once daily (before breakfast)', 'duration' => '14 days', 'qty' => 14],
            ['name' => 'Atorvastatin 20mg',          'dosage' => '20mg',  'freq' => 'Once daily at bedtime','duration' => '30 days','qty' => 30],
        ];
        foreach ($patientModels as $i => $patient) {
            $doctorUser = $doctorUsers[$i % $doctorUsers->count()];
            $rx = Prescription::firstOrCreate(
                ['patient_id' => $patient->id, 'doctor_id' => $doctorUser->id],
                [
                    'appointment_id'    => $appointments[$i % $appointments->count()]->id,
                    'prescription_date' => Carbon::now()->subDays(rand(1, 90))->format('Y-m-d'),
                    'status'            => ['active', 'completed', 'cancelled'][array_rand(['active', 'completed', 'cancelled'])],
                    'notes'             => 'Take all medications as directed. Do not self-medicate.',
                ]
            );
            if ($rx->items()->count() === 0) {
                foreach (array_slice($medicines, $i % count($medicines), 2) as $med) {
                    PrescriptionItem::create([
                        'prescription_id' => $rx->id,
                        'medicine_name'   => $med['name'],
                        'dosage'          => $med['dosage'],
                        'frequency'       => $med['freq'],
                        'duration'        => $med['duration'],
                        'quantity'        => $med['qty'],
                        'instructions'    => 'Take after meals with plenty of water.',
                    ]);
                }
            }
        }

        // ─────────────────────────────────────────
        // 15. SUPPLIERS, CATEGORIES, INVENTORY ITEMS, STOCKS
        // InventoryItem schema: id, category_id, name, sku, description, unit, reorder_level, status
        // Stock schema: id, inventory_item_id, quantity, unit_price, batch_number, expiry_date, location
        // ─────────────────────────────────────────
        $suppliersData = [
            ['name' => 'MedPlus Pharmaceutical',  'contact_person' => 'Chidi Okafor',  'phone' => '08021111001', 'email' => 'sales@medplus.ng',      'address' => '5 Pharmaceutical Ave, Lagos'],
            ['name' => 'HealthBridge Supplies',   'contact_person' => 'Amina Bello',   'phone' => '08021111002', 'email' => 'orders@healthbridge.ng', 'address' => '12 Supply Road, Abuja'],
            ['name' => 'Global Med Distributors', 'contact_person' => 'Emeka Nwosu',   'phone' => '08021111003', 'email' => 'info@globalmed.ng',     'address' => '7 Trade Lane, Port Harcourt'],
            ['name' => 'Lifeline Medical Stores', 'contact_person' => 'Ngozi Adaeze',  'phone' => '08021111004', 'email' => 'info@lifeline.ng',      'address' => '3 Health Close, Enugu'],
            ['name' => 'Apex Surgical Supplies',  'contact_person' => 'Tunde Fashola', 'phone' => '08021111005', 'email' => 'apex@surgical.ng',      'address' => '19 Surgical Blvd, Ibadan'],
        ];
        foreach ($suppliersData as $s) {
            Supplier::firstOrCreate(['email' => $s['email']], array_merge($s, ['status' => 'active']));
        }
        $suppliers = Supplier::all()->values();

        $categoriesData = [
            ['name' => 'Antibiotics'],
            ['name' => 'Analgesics'],
            ['name' => 'Antihypertensives'],
            ['name' => 'Antidiabetics'],
            ['name' => 'Surgical Supplies'],
            ['name' => 'Diagnostics'],
            ['name' => 'IV Fluids'],
            ['name' => 'PPE'],
        ];
        foreach ($categoriesData as $cat) {
            Category::firstOrCreate(['name' => $cat['name']], ['description' => $cat['name'] . ' supplies']);
        }
        $categories = Category::all()->values();

        $inventoryItemsData = [
            ['name' => 'Amoxicillin 500mg Capsules',      'sku' => 'AMX-500',  'cat' => 'Antibiotics',       'unit' => 'box',  'reorder' => 50,  'price' => 850],
            ['name' => 'Ciprofloxacin 500mg Tablets',     'sku' => 'CPF-500',  'cat' => 'Antibiotics',       'unit' => 'box',  'reorder' => 40,  'price' => 1200],
            ['name' => 'Amoxicillin 250mg Syrup',         'sku' => 'AMX-SYP',  'cat' => 'Antibiotics',       'unit' => 'bottle','reorder' => 30, 'price' => 650],
            ['name' => 'Paracetamol 500mg Tablets',       'sku' => 'PCM-500',  'cat' => 'Analgesics',        'unit' => 'box',  'reorder' => 100, 'price' => 350],
            ['name' => 'Ibuprofen 400mg Tablets',         'sku' => 'IBU-400',  'cat' => 'Analgesics',        'unit' => 'box',  'reorder' => 80,  'price' => 600],
            ['name' => 'Tramadol 50mg Capsules',          'sku' => 'TRM-050',  'cat' => 'Analgesics',        'unit' => 'box',  'reorder' => 20,  'price' => 2500],
            ['name' => 'Amlodipine 5mg Tablets',          'sku' => 'AML-005',  'cat' => 'Antihypertensives', 'unit' => 'box',  'reorder' => 60,  'price' => 900],
            ['name' => 'Lisinopril 10mg Tablets',         'sku' => 'LSN-010',  'cat' => 'Antihypertensives', 'unit' => 'box',  'reorder' => 50,  'price' => 1100],
            ['name' => 'Atorvastatin 20mg Tablets',       'sku' => 'ATV-020',  'cat' => 'Antihypertensives', 'unit' => 'box',  'reorder' => 40,  'price' => 1600],
            ['name' => 'Metformin 500mg Tablets',         'sku' => 'MET-500',  'cat' => 'Antidiabetics',     'unit' => 'box',  'reorder' => 70,  'price' => 750],
            ['name' => 'Insulin Glargine (Lantus) 100U/mL','sku' => 'INS-LAG', 'cat' => 'Antidiabetics',    'unit' => 'vial', 'reorder' => 20,  'price' => 8500],
            ['name' => 'Glibenclamide 5mg Tablets',       'sku' => 'GLB-005',  'cat' => 'Antidiabetics',     'unit' => 'box',  'reorder' => 30,  'price' => 600],
            ['name' => 'Surgical Gloves Size L',          'sku' => 'SGL-LRG',  'cat' => 'Surgical Supplies', 'unit' => 'box',  'reorder' => 30,  'price' => 3500],
            ['name' => 'Surgical Gloves Size M',          'sku' => 'SGL-MED',  'cat' => 'Surgical Supplies', 'unit' => 'box',  'reorder' => 30,  'price' => 3500],
            ['name' => 'Disposable Syringes 5ml',         'sku' => 'SYR-005',  'cat' => 'Surgical Supplies', 'unit' => 'box',  'reorder' => 50,  'price' => 1800],
            ['name' => 'Urine Dipstick Strips',           'sku' => 'UDP-001',  'cat' => 'Diagnostics',       'unit' => 'pack', 'reorder' => 15,  'price' => 4500],
            ['name' => 'Blood Glucose Test Strips',       'sku' => 'BGT-001',  'cat' => 'Diagnostics',       'unit' => 'pack', 'reorder' => 20,  'price' => 3800],
            ['name' => 'Normal Saline 0.9% 500ml',        'sku' => 'NS-500ML', 'cat' => 'IV Fluids',         'unit' => 'bag',  'reorder' => 40,  'price' => 1200],
            ['name' => "Ringer's Lactate 500ml",          'sku' => 'RL-500ML', 'cat' => 'IV Fluids',         'unit' => 'bag',  'reorder' => 30,  'price' => 1500],
            ['name' => 'N95 Respirator Masks',            'sku' => 'N95-MASK', 'cat' => 'PPE',               'unit' => 'box',  'reorder' => 20,  'price' => 7500],
        ];
        $inventoryModels = [];
        $stockQuantities = [0, 5, 120, 8, 200, 3, 85, 60, 0, 95, 12, 70, 45, 30, 0, 9, 55, 80, 40, 25];
        foreach ($inventoryItemsData as $ii => $item) {
            $cat  = Category::where('name', $item['cat'])->first();
            $invItem = InventoryItem::firstOrCreate(['sku' => $item['sku']], [
                'name'         => $item['name'],
                'category_id'  => $cat->id,
                'description'  => $item['name'] . ' — standard hospital supply',
                'unit'         => $item['unit'],
                'reorder_level'=> $item['reorder'],
                'status'       => 'active',
            ]);
            $inventoryModels[] = $invItem;

            $qty = $stockQuantities[$ii] ?? rand(20, 100);
            Stock::firstOrCreate(['inventory_item_id' => $invItem->id], [
                'quantity'     => $qty,
                'unit_price'   => $item['price'],
                'batch_number' => 'BATCH-' . strtoupper(substr($item['sku'], 0, 3)) . '-' . rand(1000, 9999),
                'expiry_date'  => Carbon::now()->addMonths(rand(6, 36))->format('Y-m-d'),
                'location'     => ['Store A', 'Store B', 'Pharmacy', 'Ward Store'][array_rand(['Store A', 'Store B', 'Pharmacy', 'Ward Store'])],
            ]);
            if ($qty > 0) {
                StockMovement::firstOrCreate(
                    ['inventory_item_id' => $invItem->id, 'type' => 'in', 'reference_type' => 'Initial Stock'],
                    ['quantity' => $qty, 'notes' => 'Opening stock entry', 'user_id' => $adminUser->id]
                );
            }
        }
        $inventoryCollection = collect($inventoryModels);

        // ─────────────────────────────────────────
        // 16. PURCHASE ORDERS + ITEMS
        // Schema: id, supplier_id, order_number, order_date, expected_delivery, received_date, status, total_amount, notes
        // ─────────────────────────────────────────
        $poStatuses = ['received', 'received', 'received', 'pending', 'cancelled'];
        foreach (range(1, 8) as $p) {
            $supplier  = $suppliers[$p % $suppliers->count()];
            $status    = $poStatuses[array_rand($poStatuses)];
            $orderDate = Carbon::now()->subDays(rand(10, 120));
            $po = PurchaseOrder::firstOrCreate(
                ['order_number' => 'PO-' . $orderDate->format('Ymd') . '-' . str_pad($p, 4, '0', STR_PAD_LEFT)],
                [
                    'supplier_id'       => $supplier->id,
                    'order_date'        => $orderDate->format('Y-m-d'),
                    'expected_delivery' => $orderDate->copy()->addDays(7)->format('Y-m-d'),
                    'received_date'     => $status === 'received' ? $orderDate->copy()->addDays(rand(3, 8))->format('Y-m-d') : null,
                    'status'            => $status,
                    'total_amount'      => 0,
                    'notes'             => 'Routine stock replenishment order #' . $p,
                ]
            );
            if ($po->items()->count() === 0) {
                $total = 0;
                $itemsForPO = $inventoryCollection->slice(($p - 1) * 2, 3)->values();
                foreach ($itemsForPO as $invItem) {
                    $qty   = rand(20, 100);
                    $price = Stock::where('inventory_item_id', $invItem->id)->value('unit_price') ?? 1000;
                    PurchaseOrderItem::create([
                        'purchase_order_id' => $po->id,
                        'inventory_item_id' => $invItem->id,
                        'quantity'          => $qty,
                        'unit_price'        => $price,
                        'total'             => $qty * $price,
                    ]);
                    $total += $qty * $price;
                }
                $po->update(['total_amount' => $total]);
            }
        }

        // ─────────────────────────────────────────
        // 17. PHARMACY SALES + SALE ITEMS
        // PharmacySale schema: id, prescription_id, patient_id, sale_date, total_amount, payment_method, status
        // PharmacySaleItem: id, pharmacy_sale_id, inventory_item_id, quantity, unit_price, total
        // ─────────────────────────────────────────
        $payMethods = ['cash', 'card', 'insurance', 'transfer'];
        $prescriptions = Prescription::all()->values();
        foreach ($patientModels as $i => $patient) {
            $saleDate = Carbon::now()->subDays(rand(1, 90));
            $prescription = $prescriptions[$i % $prescriptions->count()] ?? null;
            $sale = PharmacySale::firstOrCreate(
                ['patient_id' => $patient->id, 'sale_date' => $saleDate->format('Y-m-d')],
                [
                    'prescription_id' => $prescription?->id,
                    'total_amount'    => 0,
                    'payment_method'  => $payMethods[array_rand($payMethods)],
                    'status'          => 'completed',
                ]
            );
            if ($sale->items()->count() === 0) {
                $total = 0;
                $saleItems = $inventoryCollection->slice($i % $inventoryCollection->count(), 2)->values();
                foreach ($saleItems as $invItem) {
                    $qty   = rand(1, 5);
                    $price = Stock::where('inventory_item_id', $invItem->id)->value('unit_price') ?? 1000;
                    PharmacySaleItem::create([
                        'pharmacy_sale_id'  => $sale->id,
                        'inventory_item_id' => $invItem->id,
                        'quantity'          => $qty,
                        'unit_price'        => $price,
                        'total'             => $qty * $price,
                    ]);
                    $total += $qty * $price;
                }
                $sale->update(['total_amount' => $total]);
            }
        }

        // ─────────────────────────────────────────
        // 18. SURGERIES + SURGERY TEAM + SURGERY REPORTS
        // Surgery schema: id, patient_id, doctor_id(→users), ot_room_id, surgery_name, surgery_date,
        //                 start_time, end_time, status, type, notes
        // SurgeryTeam: id, surgery_id, user_id, role
        // SurgeryReport: id, surgery_id, pre_operative_diagnosis, post_operative_diagnosis,
        //                procedure_details, complications, blood_loss, report_date, reported_by(→users)
        // ─────────────────────────────────────────
        $surgeryList = [
            ['name' => 'Appendectomy',              'type' => 'emergency', 'status' => 'completed'],
            ['name' => 'Cholecystectomy',           'type' => 'elective',  'status' => 'completed'],
            ['name' => 'Knee Replacement (Right)',  'type' => 'elective',  'status' => 'completed'],
            ['name' => 'Caesarean Section',         'type' => 'emergency', 'status' => 'completed'],
            ['name' => 'Fibroid Myomectomy',        'type' => 'elective',  'status' => 'completed'],
            ['name' => 'Coronary Artery Bypass',    'type' => 'elective',  'status' => 'scheduled'],
            ['name' => 'Hip Replacement',           'type' => 'elective',  'status' => 'scheduled'],
            ['name' => 'Modified Radical Mastectomy','type' => 'elective', 'status' => 'completed'],
        ];
        $otRoom = $otRooms->first();
        $teamUsers = collect($staffUsers);
        foreach (array_slice($patientModels, 0, 8) as $i => $patient) {
            $surgDoctorUser = $doctorUsers[$i % $doctorUsers->count()];
            $surg           = $surgeryList[$i];
            $surgDate       = Carbon::now()->subDays(rand(5, 60));
            $surgery = Surgery::firstOrCreate(
                ['patient_id' => $patient->id, 'surgery_name' => $surg['name']],
                [
                    'doctor_id'    => $surgDoctorUser->id,
                    'ot_room_id'   => $otRoom?->id,
                    'surgery_date' => $surgDate->format('Y-m-d'),
                    'start_time'   => '08:00:00',
                    'end_time'     => '11:30:00',
                    'status'       => $surg['status'],
                    'type'         => $surg['type'],
                    'notes'        => 'Pre-operative assessment completed. Patient consented and fit for procedure.',
                ]
            );
            // Surgery team (surgeon, assistant, anesthetist, nurse)
            $teamRoles = ['surgeon', 'assistant', 'anesthetist', 'nurse'];
            foreach (array_slice($teamUsers->toArray(), 0, 4) as $ti => $member) {
                $member = (object) $member;
                SurgeryTeam::firstOrCreate(
                    ['surgery_id' => $surgery->id, 'user_id' => $member->id],
                    ['role' => $teamRoles[$ti % count($teamRoles)]]
                );
            }
            // Surgery report for completed surgeries
            if ($surg['status'] === 'completed') {
                SurgeryReport::firstOrCreate(['surgery_id' => $surgery->id], [
                    'pre_operative_diagnosis'  => 'Preoperative: ' . $surg['name'] . ' confirmed, requiring surgical intervention',
                    'post_operative_diagnosis' => 'Postoperative: Procedure completed successfully without major intraoperative complications',
                    'procedure_details'        => 'Standard ' . $surg['name'] . ' performed under general anaesthesia. Haemostasis achieved. Wound closed in anatomical layers with absorbable sutures.',
                    'complications'            => $i % 4 === 0 ? 'Minor intraoperative bleeding; managed with electrocautery.' : 'No significant complications encountered.',
                    'blood_loss'               => rand(50, 500) . ' mL',
                    'report_date'              => $surgDate->copy()->addHours(3)->format('Y-m-d H:i:s'),
                    'reported_by'              => $surgDoctorUser->id,
                ]);
            }
        }

        // ─────────────────────────────────────────
        // 19. BILLINGS
        // Schema: id, patient_id, appointment_id, invoice_number, amount, paid_amount,
        //         status, payment_method, billing_date, description
        // ─────────────────────────────────────────
        $billPayMethods = ['cash', 'card', 'bank_transfer', 'insurance'];
        $billStatuses   = ['paid', 'paid', 'partially_paid', 'unpaid'];
        foreach ($patientModels as $i => $patient) {
            $amount = rand(5000, 80000);
            $status = $billStatuses[array_rand($billStatuses)];
            $paid   = match($status) {
                'paid'          => $amount,
                'partially_paid'=> round($amount * 0.5),
                default         => 0,
            };
            Billing::firstOrCreate(
                ['invoice_number' => 'BILL-' . str_pad($i + 1, 6, '0', STR_PAD_LEFT)],
                [
                    'patient_id'     => $patient->id,
                    'appointment_id' => $appointments[$i % $appointments->count()]->id,
                    'amount'         => $amount,
                    'paid_amount'    => $paid,
                    'status'         => $status,
                    'payment_method' => $billPayMethods[array_rand($billPayMethods)],
                    'billing_date'   => Carbon::now()->subDays(rand(1, 90))->format('Y-m-d'),
                    'description'    => 'Charges for consultation, investigations and treatment services rendered',
                ]
            );
        }

        // ─────────────────────────────────────────
        // 20. INVOICES + INVOICE ITEMS + PAYMENTS + INSURANCE CLAIMS
        // Invoice schema: id, patient_id, doctor_id, invoice_date, due_date, total_amount,
        //                 tax_amount, discount_amount, status, notes
        // InvoiceItem: id, invoice_id, description, quantity, unit_price, total
        // Payment: id, invoice_id, payment_date, amount, payment_method, transaction_reference, notes
        // InsuranceClaim: id, patient_id, invoice_id, provider_name, policy_number, claim_number,
        //                 status, claim_amount, approved_amount
        // ─────────────────────────────────────────
        $invoiceStatuses = ['paid', 'paid', 'unpaid', 'partial', 'draft'];
        $serviceItems = [
            ['description' => 'Consultation Fee',           'qty' => 1, 'price' => 15000],
            ['description' => 'Full Blood Count (FBC)',     'qty' => 1, 'price' => 3500],
            ['description' => 'Chest X-Ray (PA View)',      'qty' => 1, 'price' => 12000],
            ['description' => 'Nursing Care — 3 days',      'qty' => 3, 'price' => 5000],
            ['description' => 'IV Fluids & Consumables',    'qty' => 5, 'price' => 1500],
            ['description' => 'Operating Theatre Fee',      'qty' => 1, 'price' => 80000],
            ['description' => 'Anaesthesia Services',       'qty' => 1, 'price' => 30000],
            ['description' => 'Prescribed Medications',     'qty' => 1, 'price' => 25000],
            ['description' => 'Electrocardiogram (ECG)',    'qty' => 1, 'price' => 8000],
            ['description' => 'Abdominal Ultrasound',       'qty' => 1, 'price' => 15000],
        ];
        $invoicePayMethods = ['cash', 'card', 'bank_transfer', 'insurance'];
        $hmoProviders      = ['NHIS', 'AXA Mansard Health', 'Leadway Health', 'Hygeia HMO', 'Reliance HMO'];
        foreach ($patientModels as $i => $patient) {
            $doctor      = $doctors[$i % $doctors->count()];
            $invoiceDate = Carbon::now()->subDays(rand(5, 90));
            $invStatus   = $invoiceStatuses[array_rand($invoiceStatuses)];
            $chosen      = array_slice($serviceItems, $i % count($serviceItems), rand(2, 4));
            $subtotal    = array_sum(array_map(fn ($si) => $si['qty'] * $si['price'], $chosen));
            $tax         = round($subtotal * 0.075, 2);
            $discount    = $i % 5 === 0 ? round($subtotal * 0.05, 2) : 0;
            $total       = $subtotal + $tax - $discount;

            $invoice = Invoice::firstOrCreate(
                ['patient_id' => $patient->id, 'invoice_date' => $invoiceDate->format('Y-m-d')],
                [
                    'doctor_id'       => $doctor->id,
                    'due_date'        => $invoiceDate->copy()->addDays(30)->format('Y-m-d'),
                    'total_amount'    => $total,
                    'tax_amount'      => $tax,
                    'discount_amount' => $discount,
                    'status'          => $invStatus,
                    'notes'           => 'Invoice for inpatient and outpatient services rendered at Greenfield General Hospital.',
                ]
            );
            if ($invoice->items()->count() === 0) {
                foreach ($chosen as $si) {
                    InvoiceItem::create([
                        'invoice_id'  => $invoice->id,
                        'description' => $si['description'],
                        'quantity'    => $si['qty'],
                        'unit_price'  => $si['price'],
                        'total'       => $si['qty'] * $si['price'],
                    ]);
                }
            }
            // Payment record
            if (in_array($invStatus, ['paid', 'partial'])) {
                $paidAmt = $invStatus === 'paid' ? $total : round($total * 0.5, 2);
                Payment::firstOrCreate(
                    ['invoice_id' => $invoice->id],
                    [
                        'payment_date'          => $invoiceDate->copy()->addDays(rand(1, 7))->format('Y-m-d'),
                        'amount'                => $paidAmt,
                        'payment_method'        => $invoicePayMethods[array_rand($invoicePayMethods)],
                        'transaction_reference' => 'TXN-' . strtoupper(substr(md5($invoice->id . $i), 0, 10)),
                        'notes'                 => 'Payment received and recorded at hospital billing desk',
                    ]
                );
            }
            // Insurance claim (every 3rd patient)
            if ($i % 3 === 0) {
                InsuranceClaim::firstOrCreate(
                    ['invoice_id' => $invoice->id],
                    [
                        'patient_id'     => $patient->id,
                        'provider_name'  => $hmoProviders[array_rand($hmoProviders)],
                        'policy_number'  => 'POL-' . rand(1000000, 9999999),
                        'claim_number'   => 'CLM-' . str_pad($i + 1, 6, '0', STR_PAD_LEFT),
                        'status'         => ['pending', 'approved', 'rejected'][array_rand(['pending', 'approved', 'rejected'])],
                        'claim_amount'   => round($total * 0.7, 2),
                        'approved_amount'=> $i % 2 === 0 ? round($total * 0.65, 2) : null,
                    ]
                );
            }
        }

        // ─────────────────────────────────────────
        // Summary
        // ─────────────────────────────────────────
        $this->command->info('');
        $this->command->info('✅  Full demo data seeded successfully!');
        $this->command->info('   Hospital:          ' . Hospital::count() . ' record');
        $this->command->info('   Departments:       ' . Department::count());
        $this->command->info('   Wards:             ' . Ward::count() . ' | Beds: ' . Bed::count());
        $this->command->info('   OT Rooms:          ' . OTRoom::count());
        $this->command->info('   Users (staff):     ' . User::count() . ' total');
        $this->command->info('   Doctor profiles:   ' . Doctor::count());
        $this->command->info('   Patients:          ' . Patient::count());
        $this->command->info('   Appointments:      ' . Appointment::count());
        $this->command->info('   OPD Visits:        ' . OpdVisit::count());
        $this->command->info('   IPD Admissions:    ' . IpdAdmission::count());
        $this->command->info('   Surgeries:         ' . Surgery::count());
        $this->command->info('   Lab Tests:         ' . LabTest::count() . ' | Requests: ' . LabTestRequest::count());
        $this->command->info('   Medical Records:   ' . MedicalRecord::count());
        $this->command->info('   Prescriptions:     ' . Prescription::count());
        $this->command->info('   Inventory Items:   ' . InventoryItem::count() . ' | Stocks: ' . Stock::count());
        $this->command->info('   Purchase Orders:   ' . PurchaseOrder::count());
        $this->command->info('   Pharmacy Sales:    ' . PharmacySale::count());
        $this->command->info('   Invoices:          ' . Invoice::count() . ' | Payments: ' . Payment::count());
        $this->command->info('   Insurance Claims:  ' . InsuranceClaim::count());
        $this->command->info('   Billings:          ' . Billing::count());
        $this->command->info('');
        $this->command->info('   Default staff password: password');
        $this->command->info('   Admin: admin@admin.com / admin');
    }
}

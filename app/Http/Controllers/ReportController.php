<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display patient reports
     */
    public function patientReports(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $departmentId = $request->input('department_id');

        // Total patients
        $totalPatients = Patient::count();
        
        // New patients in date range
        $newPatients = Patient::whereBetween('created_at', [$startDate, $endDate])->count();
        
        // Patients by gender
        $patientsByGender = Patient::select('gender', DB::raw('count(*) as count'))
            ->groupBy('gender')
            ->get();
        
        // Patients by blood group
        $patientsByBloodGroup = Patient::select('blood_group', DB::raw('count(*) as count'))
            ->whereNotNull('blood_group')
            ->groupBy('blood_group')
            ->orderBy('count', 'desc')
            ->get();
        
        // Recent patients
        $recentPatients = Patient::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Age distribution
        $ageRanges = [
            '0-18' => Patient::whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 0 AND 18')->count(),
            '19-35' => Patient::whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 19 AND 35')->count(),
            '36-50' => Patient::whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 36 AND 50')->count(),
            '51-65' => Patient::whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 51 AND 65')->count(),
            '65+' => Patient::whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) > 65')->count(),
        ];

        $departments = Department::all();

        return view('reports.patients', compact(
            'totalPatients',
            'newPatients',
            'patientsByGender',
            'patientsByBloodGroup',
            'recentPatients',
            'ageRanges',
            'departments',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Display financial reports
     */
    public function financialReports(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Appointments in date range (as proxy for revenue)
        $totalAppointments = Appointment::whereBetween('appointment_date', [$startDate, $endDate])->count();
        
        // Completed appointments
        $completedAppointments = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->count();
        
        // Cancelled appointments
        $cancelledAppointments = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->where('status', 'cancelled')
            ->count();
        
        // Revenue by specialization (based on appointments)
        $revenueBySpecialization = Appointment::join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
            ->whereBetween('appointments.appointment_date', [$startDate, $endDate])
            ->where('appointments.status', 'completed')
            ->whereNotNull('doctors.specialization')
            ->select('doctors.specialization', DB::raw('count(*) as count'))
            ->groupBy('doctors.specialization')
            ->get();
        
        // Monthly trend (last 6 months)
        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyTrend[] = [
                'month' => $month->format('M Y'),
                'count' => Appointment::whereYear('appointment_date', $month->year)
                    ->whereMonth('appointment_date', $month->month)
                    ->where('status', 'completed')
                    ->count()
            ];
        }

        // Estimated revenue (assuming fixed consultation fee)
        $consultationFee = 1000; // Example fee
        $estimatedRevenue = $completedAppointments * $consultationFee;

        return view('reports.financial', compact(
            'totalAppointments',
            'completedAppointments',
            'cancelledAppointments',
            'revenueBySpecialization',
            'monthlyTrend',
            'estimatedRevenue',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Display inventory reports
     */
    public function inventoryReports(Request $request)
    {
        // Placeholder data - to be replaced with actual inventory models
        $totalItems = 0;
        $lowStockItems = 0;
        $outOfStockItems = 0;
        $inventoryValue = 0;
        
        $stockByCategory = [];
        $recentActivity = [];
        $expiringItems = [];

        return view('reports.inventory', compact(
            'totalItems',
            'lowStockItems',
            'outOfStockItems',
            'inventoryValue',
            'stockByCategory',
            'recentActivity',
            'expiringItems'
        ));
    }

    /**
     * Display analytics dashboard
     */
    public function analytics(Request $request)
    {
        // Key Performance Indicators
        $kpis = [
            'total_patients' => Patient::count(),
            'total_doctors' => Doctor::count(),
            'total_departments' => Department::count(),
            'today_appointments' => Appointment::whereDate('appointment_date', Carbon::today())->count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'completed_appointments_month' => Appointment::whereMonth('appointment_date', Carbon::now()->month)
                ->where('status', 'completed')
                ->count(),
        ];

        // Patient growth (last 12 months)
        $patientGrowth = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $patientGrowth[] = [
                'month' => $month->format('M Y'),
                'count' => Patient::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count()
            ];
        }

        // Appointment status distribution
        $appointmentStatus = Appointment::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Top specializations by doctor count
        $topSpecializations = Doctor::select('specialization', DB::raw('count(*) as doctors_count'))
            ->whereNotNull('specialization')
            ->groupBy('specialization')
            ->orderBy('doctors_count', 'desc')
            ->limit(5)
            ->get();

        // Doctor utilization (appointments per doctor)
        $doctorUtilization = Doctor::withCount(['appointments' => function($query) {
                $query->whereMonth('appointment_date', Carbon::now()->month);
            }])
            ->orderBy('appointments_count', 'desc')
            ->limit(10)
            ->get();

        return view('reports.analytics', compact(
            'kpis',
            'patientGrowth',
            'appointmentStatus',
            'topSpecializations',
            'doctorUtilization'
        ));
    }
}

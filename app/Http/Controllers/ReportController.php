<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\InventoryItem;
use App\Models\Stock;
use App\Models\Category;
use App\Models\StockMovement;
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

        // Actual revenue: sum of consultation fees for completed appointments in range
        $estimatedRevenue = Appointment::join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
            ->whereBetween('appointments.appointment_date', [$startDate, $endDate])
            ->where('appointments.status', 'completed')
            ->whereNotNull('doctors.consultation_fee')
            ->sum('doctors.consultation_fee');

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
        $totalItems = InventoryItem::count();
        $outOfStockItems = Stock::where('quantity', 0)->count();
        $lowStockItems = Stock::join('inventory_items', 'stocks.inventory_item_id', '=', 'inventory_items.id')
            ->whereColumn('stocks.quantity', '<', 'inventory_items.reorder_level')
            ->where('stocks.quantity', '>', 0)
            ->count();
        $inventoryValue = Stock::selectRaw('SUM(quantity * unit_price) as val')->value('val') ?? 0;
        
        $stockByCategory = Category::withCount('inventoryItems')->paginate(5, ['*'], 'category_page');
        
        $recentActivity = StockMovement::with(['inventoryItem', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        $expiringItems = Stock::with('inventoryItem')
            ->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '<', Carbon::now()->addMonths(6))
            ->orderBy('expiry_date')
            ->limit(10)
            ->get();

        $lowStockList = Stock::with('inventoryItem')
            ->join('inventory_items', 'stocks.inventory_item_id', '=', 'inventory_items.id')
            ->whereColumn('stocks.quantity', '<', 'inventory_items.reorder_level')
            ->select('stocks.*')
            ->limit(10)
            ->get();

        return view('reports.inventory', compact(
            'totalItems',
            'lowStockItems',
            'outOfStockItems',
            'inventoryValue',
            'stockByCategory',
            'recentActivity',
            'expiringItems',
            'lowStockList'
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

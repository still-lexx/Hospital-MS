<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\IpdAdmission;
use App\Models\PharmacySale;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Fetch hospital analytics
        $totalPharmacySales = PharmacySale::sum('total_amount');
        $totalBillingRevenue = \App\Models\Billing::sum('paid_amount');
        $totalHospitalPayments = \App\Models\Payment::sum('amount');
        $totalHospitalRevenue = $totalPharmacySales + $totalBillingRevenue + $totalHospitalPayments;

        $stats = [
            'total_patients' => Patient::count(),
            'admitted_patients' => Patient::where('admitted', 1)->count(),
            'todays_appointments' => Appointment::whereDate('appointment_date', Carbon::today())->count(),
            'monthly_sales' => PharmacySale::whereMonth('sale_date', Carbon::now()->month)
                ->whereYear('sale_date', Carbon::now()->year)
                ->sum('total_amount'),
            'total_sales' => $totalPharmacySales,
            'total_revenue' => $totalHospitalRevenue,
            'recent_appointments' => Appointment::with(['patient', 'doctor'])
                ->latest()
                ->take(10)
                ->get(),
        ];

        // Monthly Revenue for Chart (Current Year) - broken down by source
        $monthlyRevenue = [];
        $monthlyPharmacy = [];
        $monthlyBilling = [];
        $monthlyPayments = [];
        for ($m = 1; $m <= 12; $m++) {
            $pharmacyRev = PharmacySale::whereYear('sale_date', Carbon::now()->year)
                ->whereMonth('sale_date', $m)
                ->sum('total_amount');
            $billingRev = \App\Models\Billing::whereYear('billing_date', Carbon::now()->year)
                ->whereMonth('billing_date', $m)
                ->sum('paid_amount');
            $paymentRev = \App\Models\Payment::whereYear('payment_date', Carbon::now()->year)
                ->whereMonth('payment_date', $m)
                ->sum('amount');
            $monthlyPharmacy[]  = round($pharmacyRev, 2);
            $monthlyBilling[]   = round($billingRev, 2);
            $monthlyPayments[]  = round($paymentRev, 2);
            $monthlyRevenue[]   = round($pharmacyRev + $billingRev + $paymentRev, 2);
        }
        $stats['chart_earnings']  = json_encode($monthlyRevenue);
        $stats['chart_pharmacy']  = json_encode($monthlyPharmacy);
        $stats['chart_billing']   = json_encode($monthlyBilling);
        $stats['chart_payments']  = json_encode($monthlyPayments);

        // Sparkline: Appointments (Last 14 Days)
        $stats['sparkline_appointments'] = $this->getDailyTrend(Appointment::class, 'appointment_date');
        
        // Sparkline: Revenue (Last 14 Days)
        $stats['sparkline_revenue'] = $this->getDailyTrend(PharmacySale::class, 'sale_date', 'sum', 'total_amount');

        // Sparkline: New Patients (Last 14 Days)
        $stats['sparkline_patients'] = $this->getDailyTrend(Patient::class, 'created_at');
        
        return view('home', compact('stats'));
    }

    /**
     * Get daily trend data for sparklines
     */
    private function getDailyTrend($model, $dateColumn, $aggregate = 'count', $sumColumn = null, $days = 14)
    {
        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $query = $model::whereDate($dateColumn, $date);
            
            if ($aggregate == 'sum' && $sumColumn) {
                $data[] = $query->sum($sumColumn);
            } else {
                $data[] = $query->count();
            }
        }
        return json_encode($data);
    }
}

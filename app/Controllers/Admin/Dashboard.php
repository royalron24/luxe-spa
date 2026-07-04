<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MemberModel;
use App\Models\PaymentModel;
use App\Models\BookingModel;
use App\Models\StaffModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $memberModel  = new MemberModel();
        $paymentModel = new PaymentModel();
        $bookingModel = new BookingModel();
        $staffModel   = new StaffModel();

        // Stat cards
        $data['totalMembers']  = $memberModel->countAll();
        $data['activeMembers'] = $memberModel->where('status', 'Active')->countAllResults();
        $data['newMembers']    = $memberModel->where('MONTH(join_date)', date('m'))->countAllResults();
        $data['revenue']       = $paymentModel->selectSum('amount')->where('payment_status', 'Completed')->first()['amount'] ?? 0;
        $data['totalStaff']    = $staffModel->where('status', 'Active')->countAllResults();
        $data['totalBookings'] = $bookingModel->countAll();
        $data['pendingBookings'] = $bookingModel->where('status', 'Pending')->countAllResults();

        // Recent members
        $data['members'] = $memberModel->orderBy('member_id', 'DESC')->findAll(5);

        // Monthly revenue chart (current year)
        $months   = [];
        $revenues = [];
        $year     = date('Y');
        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('M', mktime(0, 0, 0, $i, 1));
            $row = $paymentModel
                ->selectSum('amount')
                ->where('payment_status', 'Completed')
                ->where('MONTH(payment_date)', $i)
                ->where('YEAR(payment_date)', $year)
                ->first();
            $revenues[] = (float)($row['amount'] ?? 0);
        }
        $data['chartMonths']   = $months;
        $data['chartRevenues'] = $revenues;

        // Membership distribution
        $membershipTypes = ['Bronze', 'Silver', 'Gold'];
        $membershipCounts = [];
        $totalWithPlan = 0;
        foreach ($membershipTypes as $type) {
            $count = $memberModel->where('membership', $type)->countAllResults();
            $membershipCounts[$type] = $count;
            $totalWithPlan += $count;
        }
        $data['membershipCounts'] = $membershipCounts;
        $data['totalWithPlan']    = $totalWithPlan;

        return view('admin/dashboard/index', $data);
    }
}






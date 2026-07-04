<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RevenueModel;

class Revenue extends BaseController
{
    protected $revenueModel;

    public function __construct()
    {
        $this->revenueModel = new RevenueModel();
    }

    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $paymentModel = new \App\Models\RevenueModel();

        // Get filter date
        $from = $this->request->getGet('from');
        $to = $this->request->getGet('to');

        $query = $paymentModel
            ->select('payments.*, members.full_name')
            ->join('members', 'members.member_id = payments.member_id');

        if (!empty($from) && !empty($to)) {

            $query->where('payment_date >=', $from)
                ->where('payment_date <=', $to);

        }

        $data['payments'] = $query
            ->orderBy('payment_date', 'DESC')
            ->findAll();

        $totalQuery = $paymentModel
            ->selectSum('amount')
            ->where('payment_status', 'Completed');

        if (!empty($from) && !empty($to)) {

            $totalQuery->where('payment_date >=', $from)
                ->where('payment_date <=', $to);

        }

        $data['totalRevenue'] = $totalQuery->first()['amount'] ?? 0;

        $completedQuery = $paymentModel
            ->where('payment_status', 'Completed');

        if (!empty($from) && !empty($to)) {

            $completedQuery->where('payment_date >=', $from)
                ->where('payment_date <=', $to);

        }

        $data['completedPayment'] = $completedQuery->countAllResults();

        $pendingQuery = $paymentModel
            ->where('payment_status', 'Pending');

        if (!empty($from) && !empty($to)) {

            $pendingQuery->where('payment_date >=', $from)
                ->where('payment_date <=', $to);

        }

        $data['pendingPayment'] = $pendingQuery->countAllResults();

        // =======================
        // Revenue Chart
        // =======================

        $months = [];
        $revenues = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('M', mktime(0, 0, 0, $i, 1));

            $row = $paymentModel
                ->selectSum('amount')
                ->where('payment_status', 'Completed')
                ->where('MONTH(payment_date)', $i)
                ->first();

            $revenues[] = $row['amount'] ?? 0;
        }

        $data['months'] = $months;
        $data['revenues'] = $revenues;

        // ===============================
// Revenue by Membership
// ===============================

        $membership = $this->revenueModel
            ->select('members.membership, SUM(payments.amount) AS total')
            ->join('members', 'members.member_id = payments.member_id')
            ->where('payments.payment_status', 'Completed')
            ->groupBy('members.membership')
            ->findAll();

        $data['membership'] = $membership;

        // ===============================
// Monthly Average
// ===============================

        $data['monthlyAverage'] = ($data['totalRevenue'] ?? 0) / 12;


        // ===============================
// Highest Month
// ===============================

        $highest = $paymentModel
            ->select('MONTHNAME(payment_date) AS month, SUM(amount) AS total')
            ->where('payment_status', 'Completed')
            ->groupBy('MONTH(payment_date)')
            ->orderBy('total', 'DESC')
            ->first();

        $data['highestMonth'] = $highest;


        // ===============================
// Total Transactions
// ===============================

        $data['totalTransaction'] = $paymentModel->countAll();

        return view('admin/revenue/index', $data);


    }
}





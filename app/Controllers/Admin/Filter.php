<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MemberModel;

class Filter extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $model = new MemberModel();

        $query = $model
            ->select('members.*, payments.payment_status')
            ->join('payments', 'payments.member_id = members.member_id', 'left');

        $name = $this->request->getGet('name');
        $membership = $this->request->getGet('membership');
        $paymentStatus = $this->request->getGet('payment_status');

        if (!empty($name)) {
            $query->like('members.full_name', $name);
        }

        if (!empty($membership)) {
            $query->where('members.membership', $membership);
        }

        if (!empty($paymentStatus)) {
            $query->where('payments.payment_status', $paymentStatus);
        }

        $data['members'] = $query
            ->orderBy('members.member_id', 'DESC')
            ->findAll();

        return view('admin/filter/index', $data);
    }
}





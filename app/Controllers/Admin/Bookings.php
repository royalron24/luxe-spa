<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\MemberModel;

class Bookings extends BaseController
{
    protected $bookingModel;
    protected $memberModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->memberModel  = new MemberModel();
    }

    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $status   = $this->request->getGet('status');
        $search   = $this->request->getGet('search');
        $dateFrom = $this->request->getGet('date_from');
        $dateTo   = $this->request->getGet('date_to');

        $builder = $this->bookingModel
            ->select('bookings.*, members.full_name, members.email, members.membership')
            ->join('members', 'members.member_id = bookings.member_id', 'left')
            ->orderBy('bookings.booking_date', 'DESC')
            ->orderBy('bookings.booking_time', 'DESC');

        if (!empty($status)) {
            $builder->where('bookings.status', $status);
        }
        if (!empty($search)) {
            $builder->groupStart()
                ->like('members.full_name', $search)
                ->orLike('bookings.service', $search)
                ->groupEnd();
        }
        if (!empty($dateFrom)) {
            $builder->where('bookings.booking_date >=', $dateFrom);
        }
        if (!empty($dateTo)) {
            $builder->where('bookings.booking_date <=', $dateTo);
        }

        $data = [
            'bookings'      => $builder->findAll(),
            'totalBookings' => $this->bookingModel->countAll(),
            'pending'       => $this->bookingModel->where('status', 'Pending')->countAllResults(),
            'confirmed'     => $this->bookingModel->where('status', 'Confirmed')->countAllResults(),
            'completed'     => $this->bookingModel->where('status', 'Completed')->countAllResults(),
            'cancelled'     => $this->bookingModel->where('status', 'Cancelled')->countAllResults(),
            'filters'       => ['status' => $status, 'search' => $search, 'date_from' => $dateFrom, 'date_to' => $dateTo],
        ];

        return view('admin/bookings/index', $data);
    }

    public function updateStatus(int $bookingId)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $newStatus = $this->request->getPost('status');
        $allowed   = ['Pending', 'Confirmed', 'Completed', 'Cancelled'];

        if (!in_array($newStatus, $allowed, true)) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        $booking = $this->bookingModel->find($bookingId);
        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found.');
        }

        $this->bookingModel->update($bookingId, ['status' => $newStatus]);

        return redirect()->to('/admin/bookings')->with('success', 'Booking #' . $bookingId . ' updated to ' . $newStatus . '.');
    }

    public function delete(int $bookingId)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $this->bookingModel->delete($bookingId);

        return redirect()->to('/admin/bookings')->with('success', 'Booking deleted.');
    }
}

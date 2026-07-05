<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\MemberModel;
use App\Models\PaymentModel;
use App\Models\BookingModel;

class MemberAuth extends BaseController
{
    protected $memberModel;
    protected $paymentModel;
    protected $bookingModel;

    public function __construct()
    {
        $this->memberModel  = new MemberModel();
        $this->paymentModel = new PaymentModel();
        $this->bookingModel = new BookingModel();
    }

    private function requireMember()
    {
        if (!session()->get('member_logged_in') || !session()->get('member_id')) {
            return redirect()->to('/login')->with('error', 'Please log in to access that page.');
        }

        return null;
    }

    public function login()
    {
        if (session()->get('member_logged_in')) {
            return redirect()->to('/member/dashboard');
        }

        if (session()->get('admin_id') && session()->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard');
        }

        echo view('user/templates/header');
        echo view('user/login');
        echo view('user/templates/footer');
    }

    public function register()
    {
        if (session()->get('member_logged_in')) {
            return redirect()->to('/member/dashboard');
        }

        echo view('user/templates/header');
        echo view('user/register');
        echo view('user/templates/footer');
    }

    public function loginProcess()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $adminModel = new \App\Models\AdminModel();
        $admin = $adminModel->where('email', $email)->first();

        if ($admin) {
            if (!password_verify($password, $admin['password'])) {
                return redirect()->back()->with('error', 'Incorrect password.');
            }

            session()->remove([
                'member_id',
                'membership',
                'member_type',
                'member_logged_in',
            ]);

            session()->set([
                'admin_id' => $admin['admin_id'],
                'full_name' => $admin['full_name'],
                'email' => $admin['email'],
                'isLoggedIn' => true,
            ]);

            return redirect()->to('/admin/dashboard');
        }

        $member = $this->memberModel->where('email', $email)->first();

        if (!$member) {
            return redirect()->back()->with('error', 'Email not found.');
        }

        if (!password_verify($password, $member['password'])) {
            return redirect()->back()->with('error', 'Incorrect password.');
        }

        session()->remove([
            'admin_id',
            'isLoggedIn',
        ]);

        session()->set([
            'member_id' => $member['member_id'],
            'full_name' => $member['full_name'],
            'email' => $member['email'],
            'membership' => $member['membership'],
            'member_type' => $member['member_type'],
            'member_logged_in' => true,
        ]);

        return redirect()->to('/member/dashboard');
    }

    public function registerProcess()
    {
        $fullName = $this->request->getPost('full_name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');
        $memberType = $this->request->getPost('member_type');

        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Passwords do not match.');
        }

        if ($this->memberModel->where('email', $email)->first()) {
            return redirect()->back()->with('error', 'Email already registered.');
        }

        $memberCode = 'M' . str_pad((int) ($this->memberModel->selectMax('member_id')->first()['member_id'] ?? 0) + 1, 3, '0', STR_PAD_LEFT);

        $this->memberModel->insert([
            'member_code' => $memberCode,
            'full_name' => $fullName,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'member_type' => $memberType ?: 'Individual',
            'membership' => null,
            'status' => 'Inactive',
            'join_date' => null,
        ]);

        return redirect()->to('/login')->with('success', 'Account created. Complete membership payment after login to activate your membership.');
    }

    public function dashboard()
    {
        if ($redirect = $this->requireMember()) {
            return $redirect;
        }

        $member = $this->memberModel->find(session()->get('member_id'));

        $data = [
            'member' => $member,
            'payments' => $this->paymentModel->where('member_id', $member['member_id'])->orderBy('payment_date', 'DESC')->findAll(),
        ];

        echo view('user/templates/header');
        echo view('user/dashboard', $data);
        echo view('user/templates/footer');
    }

    public function profile()
    {
        if ($redirect = $this->requireMember()) {
            return $redirect;
        }

        $memberId = session()->get('member_id');
        $data['member'] = $this->memberModel->find($memberId);
        $data['payments'] = $this->paymentModel->where('member_id', $memberId)->orderBy('payment_date', 'DESC')->findAll();

        echo view('user/templates/header');
        echo view('user/profile', $data);
        echo view('user/templates/footer');
    }

    public function updateProfile()
    {
        if ($redirect = $this->requireMember()) {
            return $redirect;
        }

        $memberId = session()->get('member_id');
        $updateData = [
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
            'gender' => $this->request->getPost('gender'),
            'member_type' => $this->request->getPost('member_type'),
        ];

        $profileImage = $this->request->getFile('profile_picture');
        if ($profileImage && $profileImage->isValid() && !$profileImage->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/profile/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $newName = $profileImage->getRandomName();
            $profileImage->move($uploadPath, $newName);
            $updateData['profile_picture'] = 'uploads/profile/' . $newName;
        }

        $this->memberModel->update($memberId, $updateData);

        session()->set([
            'full_name' => $this->request->getPost('full_name'),
            'member_type' => $this->request->getPost('member_type'),
        ]);

        return redirect()->to('/member/profile')->with('success', 'Profile updated successfully.');
    }

    public function subscription()
    {
        if ($redirect = $this->requireMember()) {
            return $redirect;
        }

        $memberId = session()->get('member_id');
        $data = [
            'member' => $this->memberModel->find($memberId),
            'payments' => $this->paymentModel->where('member_id', $memberId)->orderBy('payment_date', 'DESC')->findAll(),
            'plans' => [
                ['name' => 'Bronze', 'price' => 120.00, 'benefits' => 'Basic access, essential discounts, and member support.'],
                ['name' => 'Silver', 'price' => 180.00, 'benefits' => 'Priority booking, extra perks, and expanded wellness services.'],
                ['name' => 'Gold', 'price' => 260.00, 'benefits' => 'Premium access, VIP benefits, and the best spa experiences.'],
            ],
        ];

        echo view('user/templates/header');
        echo view('user/subscription', $data);
        echo view('user/templates/footer');
    }

    public function paymentHistory()
    {
        if ($redirect = $this->requireMember()) {
            return $redirect;
        }

        $memberId = session()->get('member_id');
        $data = [
            'member' => $this->memberModel->find($memberId),
            'payments' => $this->paymentModel->where('member_id', $memberId)->orderBy('payment_date', 'DESC')->findAll(),
        ];

        echo view('user/templates/header');
        echo view('user/history_payment', $data);
        echo view('user/templates/footer');
    }

    public function treatmentHistory()
    {
        if ($redirect = $this->requireMember()) {
            return $redirect;
        }

        $memberId = session()->get('member_id');
        $data = [
            'member'   => $this->memberModel->find($memberId),
            'bookings' => $this->bookingModel
                ->where('member_id', $memberId)
                ->orderBy('booking_date', 'DESC')
                ->orderBy('booking_time', 'DESC')
                ->findAll(),
        ];

        echo view('user/templates/header');
        echo view('user/history_treatment', $data);
        echo view('user/templates/footer');
    }

    public function paySubscription()
    {
        if ($redirect = $this->requireMember()) {
            return $redirect;
        }

        $memberId = session()->get('member_id');
        $plan = $this->request->getPost('plan');
        $amount = $this->request->getPost('amount');
        $paymentMethod = $this->request->getPost('payment_method');

        $member = $this->memberModel->find($memberId);
        $membershipPlan = in_array($plan, ['Bronze', 'Silver', 'Gold']) ? $plan : 'Bronze';

        $this->memberModel->update($memberId, [
            'membership' => $membershipPlan,
            'status' => 'Active',
            'join_date' => $member['join_date'] ?? date('Y-m-d'),
        ]);

        session()->set([
            'membership' => $membershipPlan,
        ]);

        $this->paymentModel->save([
            'member_id' => $memberId,
            'service' => 'Membership Upgrade',
            'amount' => $amount,
            'payment_date' => date('Y-m-d'),
            'payment_method' => $paymentMethod,
            'payment_status' => 'Completed',
        ]);

        return redirect()->to('/member/subscription')->with('success', 'Membership payment completed. Your membership is now active.');
    }

    public function logout()
    {
        $session = session();
        $session->remove([
            'member_id',
            'full_name',
            'email',
            'membership',
            'member_type',
            'member_logged_in',
            'admin_id',
            'isLoggedIn',
        ]);

        return redirect()->to('/login');
    }

    public function booking()
    {
        if ($redirect = $this->requireMember()) {
            return $redirect;
        }

        $memberId = session()->get('member_id');
        $data = [
            'member'   => $this->memberModel->find($memberId),
            'bookings' => $this->bookingModel
                ->where('member_id', $memberId)
                ->orderBy('booking_date', 'ASC')
                ->orderBy('booking_time', 'ASC')
                ->findAll(),
        ];

        echo view('user/templates/header');
        echo view('user/booking', $data);
        echo view('user/templates/footer');
    }

    public function bookingStore()
    {
        if ($redirect = $this->requireMember()) {
            return $redirect;
        }

        $memberId  = session()->get('member_id');
        $service   = $this->request->getPost('service');
        $date      = $this->request->getPost('booking_date');
        $time      = $this->request->getPost('booking_time');
        $therapist = $this->request->getPost('therapist');
        $notes     = $this->request->getPost('notes');

        $allowedServices = [
            'Rose Petal Massage', 'Cherry Blossom Facial', 'Hydrating Body Ritual',
            'Aromatherapy Body Wrap', 'Velvet Hair Spa', 'Couples Retreat Package',
            'Pedicure & Manicure',
        ];

        if (!in_array($service, $allowedServices, true)) {
            return redirect()->back()->with('error', 'Invalid service selected.');
        }

        if (empty($date) || strtotime($date) < strtotime('today')) {
            return redirect()->back()->with('error', 'Please select a valid future date.');
        }

        $this->bookingModel->insert([
            'member_id'    => $memberId,
            'service'      => $service,
            'booking_date' => $date,
            'booking_time' => $time . ':00',
            'therapist'    => $therapist,
            'notes'        => strip_tags($notes ?? ''),
            'status'       => 'Pending',
        ]);

        $bookingId    = $this->bookingModel->getInsertID();
        $servicePrices = $this->getServicePrices();
        $servicePrice  = $servicePrices[$service] ?? 0.00;
        $duration      = $this->getServiceDuration($service);

        session()->set('payment_intent', [
            'type'         => 'booking',
            'service'      => $service,
            'booking_id'   => $bookingId,
            'booking_date' => $date,
            'booking_time' => $time . ':00',
            'duration'     => $duration,
            'base_amount'  => $servicePrice,
            'discount'     => 0.00,
            'total'        => $servicePrice,
        ]);

        return redirect()->to('/member/payment');
    }

    public function bookingCancel(int $bookingId)
    {
        if ($redirect = $this->requireMember()) {
            return $redirect;
        }

        $memberId = session()->get('member_id');
        $booking  = $this->bookingModel->find($bookingId);

        if (!$booking || (int) $booking['member_id'] !== (int) $memberId) {
            return redirect()->to('/member/booking')->with('error', 'Booking not found.');
        }

        $this->bookingModel->update($bookingId, ['status' => 'Cancelled']);

        return redirect()->to('/member/booking')->with('success', 'Booking cancelled successfully.');
    }

    // ─── Payment page ────────────────────────────────────────────────────────

    /**
     * Prepare payment intent and redirect to the payment page.
     * Accepts POST from the subscription or booking pages.
     */
    public function preparePayment()
    {
        if ($redirect = $this->requireMember()) {
            return $redirect;
        }

        $type = $this->request->getPost('type');

        if ($type === 'membership') {
            $plan       = $this->request->getPost('plan');
            $validPlans = ['Bronze' => 120.00, 'Silver' => 180.00, 'Gold' => 260.00];

            if (!array_key_exists($plan, $validPlans)) {
                return redirect()->to('/member/subscription')->with('error', 'Invalid membership plan.');
            }

            $baseAmount = $validPlans[$plan];
            $member     = $this->memberModel->find(session()->get('member_id'));
            $isRenewal  = !empty($member['membership']);
            $discount   = $isRenewal ? round($baseAmount * 0.10, 2) : 0.00;
            $total      = $baseAmount - $discount;

            session()->set('payment_intent', [
                'type'        => 'membership',
                'plan'        => $plan,
                'base_amount' => $baseAmount,
                'discount'    => $discount,
                'total'       => $total,
            ]);

            return redirect()->to('/member/payment');
        }

        return redirect()->to('/member/subscription')->with('error', 'Invalid payment type.');
    }

    /**
     * Show the unified payment page (GET).
     */
    public function showPayment()
    {
        if ($redirect = $this->requireMember()) {
            return $redirect;
        }

        $intent = session()->get('payment_intent');
        if (!$intent) {
            return redirect()->to('/member/dashboard')->with('error', 'No payment in progress. Please start from the booking or subscription page.');
        }

        $memberId = session()->get('member_id');
        $data = [
            'member'   => $this->memberModel->find($memberId),
            'payments' => $this->paymentModel->where('member_id', $memberId)->orderBy('payment_date', 'DESC')->findAll(),
            'intent'   => $intent,
        ];

        echo view('user/templates/header');
        echo view('user/payment', $data);
        echo view('user/templates/footer');
    }

    /**
     * Process the payment and save to the database (POST).
     */
    public function processPayment()
    {
        if ($redirect = $this->requireMember()) {
            return $redirect;
        }

        $memberId = session()->get('member_id');
        $intent   = session()->get('payment_intent');

        if (!$intent) {
            return redirect()->to('/member/dashboard')->with('error', 'Payment session expired. Please try again.');
        }

        $paymentMethod  = $this->request->getPost('payment_method');
        $allowedMethods = ['Credit Card', 'FPX Online Banking', 'E-Wallet', 'Bank Transfer'];

        if (!in_array($paymentMethod, $allowedMethods, true)) {
            return redirect()->to('/member/payment')->with('error', 'Invalid payment method selected.');
        }

        $type  = $intent['type'];
        $total = (float) $intent['total'];

        if ($type === 'membership') {
            $plan    = $intent['plan'];
            $service = $plan . ' Membership';
            $member  = $this->memberModel->find($memberId);

            $this->memberModel->update($memberId, [
                'membership' => $plan,
                'status'     => 'Active',
                'join_date'  => $member['join_date'] ?? date('Y-m-d'),
            ]);

            session()->set('membership', $plan);
            $redirectTo     = '/member/subscription';
            $successMessage = ucfirst($plan) . ' Membership activated. Payment of RM ' . number_format($total, 2) . ' completed.';

        } elseif ($type === 'booking') {
            $service   = $intent['service'];
            $bookingId = (int) ($intent['booking_id'] ?? 0);

            if ($bookingId > 0) {
                $booking = $this->bookingModel->find($bookingId);
                if ($booking && (int) $booking['member_id'] === (int) $memberId) {
                    $this->bookingModel->update($bookingId, ['status' => 'Confirmed']);
                }
            }

            $redirectTo     = '/member/booking';
            $successMessage = 'Booking payment of RM ' . number_format($total, 2) . ' completed. Your session is confirmed!';

        } else {
            return redirect()->to('/member/dashboard')->with('error', 'Invalid payment type.');
        }

        $this->paymentModel->save([
            'member_id'      => $memberId,
            'service'        => $service,
            'amount'         => $total,
            'payment_date'   => date('Y-m-d'),
            'payment_method' => $paymentMethod,
            'payment_status' => 'Completed',
        ]);

        session()->remove('payment_intent');

        return redirect()->to($redirectTo)->with('success', $successMessage);
    }

    // ─── Private helpers ─────────────────────────────────────────────────────

    private function getServicePrices(): array
    {
        return [
            'Rose Petal Massage'      => 185.00,
            'Cherry Blossom Facial'   => 150.00,
            'Hydrating Body Ritual'   => 140.00,
            'Aromatherapy Body Wrap'  => 120.00,
            'Velvet Hair Spa'         => 90.00,
            'Couples Retreat Package' => 380.00,
            'Pedicure & Manicure'     => 85.00,
        ];
    }

    private function getServiceDuration(string $service): int
    {
        $durations = [
            'Rose Petal Massage'      => 90,
            'Cherry Blossom Facial'   => 60,
            'Hydrating Body Ritual'   => 75,
            'Aromatherapy Body Wrap'  => 60,
            'Velvet Hair Spa'         => 45,
            'Couples Retreat Package' => 120,
            'Pedicure & Manicure'     => 60,
        ];
        return $durations[$service] ?? 60;
    }
}












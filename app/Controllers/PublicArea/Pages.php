<?php

namespace App\Controllers\PublicArea;

use App\Controllers\BaseController;

class Pages extends BaseController
{
    public function home()
    {
        echo view('public/templates/header');
        echo view('public/home');
        echo view('public/templates/footer');
    }

    public function about()
    {
        echo view('public/templates/header');
        echo view('public/about');
        echo view('public/templates/footer');
    }

    public function facility()
    {
        echo view('public/templates/header');
        echo view('public/facility');
        echo view('public/templates/footer');
    }

    public function policy()
    {
        echo view('public/templates/header');
        echo view('public/policy');
        echo view('public/templates/footer');
    }

    public function book()
    {
        echo view('public/templates/header');
        echo view('public/book');
        echo view('public/templates/footer');
    }

    public function bookEnquire()
    {
        // Store enquiry or redirect to login for full booking
        $name    = $this->request->getPost('name');
        $email   = $this->request->getPost('email');
        $service = $this->request->getPost('service');
        $date    = $this->request->getPost('preferred_date');

        if (session()->get('member_logged_in')) {
            return redirect()->to('/member/booking')->with('success', 'Use the member booking form below to reserve your session.');
        }

        return redirect()->to('/login')->with('success', 'Log in or register to complete your booking for ' . esc($service) . '.');
    }

    public function contact()
    {
        echo view('public/templates/header');
        echo view('public/contact');
        echo view('public/templates/footer');
    }

    public function contactSend()
    {
        return redirect()->to('/contact')->with('success', 'Thank you for reaching out! We will get back to you within 24 hours.');
    }
}









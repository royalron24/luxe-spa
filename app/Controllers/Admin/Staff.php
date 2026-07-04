<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\StaffModel;

class Staff extends BaseController
{
    protected $staffModel;

    public function __construct()
    {
        $this->staffModel = new StaffModel();
    }

    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $keyword = $this->request->getGet('search');

        $builder = $this->staffModel->orderBy('staff_id', 'DESC');

        if ($keyword) {
            $builder->groupStart()
                ->like('full_name', $keyword)
                ->orLike('email', $keyword)
                ->orLike('position', $keyword)
                ->groupEnd();
        }

        $data['staff']   = $builder->findAll();
        $data['keyword'] = $keyword;
        $data['total']   = $this->staffModel->countAll();
        $data['active']  = $this->staffModel->where('status', 'Active')->countAllResults();

        return view('admin/staff/index', $data);
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('admin/staff/form', ['staff' => null, 'action' => base_url('admin/staff/store')]);
    }

    public function store()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'full_name' => 'required|min_length[2]|max_length[100]',
            'email'     => 'required|valid_email|is_unique[staff.email]',
            'phone'     => 'permit_empty|max_length[20]',
            'position'  => 'required',
            'status'    => 'required|in_list[Active,Inactive]',
            'join_date' => 'permit_empty|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $this->staffModel->insert([
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'phone'     => $this->request->getPost('phone'),
            'position'  => $this->request->getPost('position'),
            'status'    => $this->request->getPost('status'),
            'join_date' => $this->request->getPost('join_date') ?: null,
        ]);

        return redirect()->to('/admin/staff')->with('success', 'Staff member added successfully.');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $staff = $this->staffModel->find($id);
        if (!$staff) {
            return redirect()->to('/admin/staff')->with('error', 'Staff member not found.');
        }

        return view('admin/staff/form', ['staff' => $staff, 'action' => base_url('admin/staff/update/' . $id)]);
    }

    public function update(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $staff = $this->staffModel->find($id);
        if (!$staff) {
            return redirect()->to('/admin/staff')->with('error', 'Staff member not found.');
        }

        $rules = [
            'full_name' => 'required|min_length[2]|max_length[100]',
            'email'     => "required|valid_email|is_unique[staff.email,staff_id,{$id}]",
            'phone'     => 'permit_empty|max_length[20]',
            'position'  => 'required',
            'status'    => 'required|in_list[Active,Inactive]',
            'join_date' => 'permit_empty|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $this->staffModel->update($id, [
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'phone'     => $this->request->getPost('phone'),
            'position'  => $this->request->getPost('position'),
            'status'    => $this->request->getPost('status'),
            'join_date' => $this->request->getPost('join_date') ?: null,
        ]);

        return redirect()->to('/admin/staff')->with('success', 'Staff member updated successfully.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $staff = $this->staffModel->find($id);
        if (!$staff) {
            return redirect()->to('/admin/staff')->with('error', 'Staff member not found.');
        }

        $this->staffModel->delete($id);

        return redirect()->to('/admin/staff')->with('success', 'Staff member removed.');
    }
}

<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MemberModel;

class Member extends BaseController
{
    protected $memberModel;

    public function __construct()
    {
        $this->memberModel = new MemberModel();
    }

    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $keyword = $this->request->getGet('search');

        if ($keyword) {

            $data['members'] = $this->memberModel

                ->groupStart()
                ->like('member_code', $keyword)
                ->orLike('full_name', $keyword)
                ->orLike('email', $keyword)
                ->orLike('phone', $keyword)
                ->groupEnd()

                ->orderBy('member_id', 'DESC')
                ->findAll();

        } else {

            $data['members'] = $this->memberModel

                ->orderBy('member_id', 'DESC')
                ->findAll();

        }

        $data['keyword'] = $keyword;

        return view('admin/members/index', $data);
    }

    public function search()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $keyword = $this->request->getGet('keyword');

        $members = $this->memberModel

            ->groupStart()
            ->like('member_code', $keyword)
            ->orLike('full_name', $keyword)
            ->orLike('email', $keyword)
            ->orLike('phone', $keyword)
            ->groupEnd()

            ->orderBy('member_id', 'DESC')
            ->findAll();

        return $this->response->setJSON($members);
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('admin/members/create');
    }

    public function store()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $this->memberModel->save([

            'member_code' => $this->request->getPost('member_code'),

            'full_name' => $this->request->getPost('full_name'),

            'email' => $this->request->getPost('email'),

            'phone' => $this->request->getPost('phone'),

            'gender' => $this->request->getPost('gender'),

            'membership' => $this->request->getPost('membership'),

            'status' => $this->request->getPost('status'),

            'join_date' => $this->request->getPost('join_date')

        ]);

        return redirect()->to('/members');
    }

    public function edit($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $data['member'] = $this->memberModel->find($id);

        return view('admin/members/edit', $data);
    }

    public function update($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $this->memberModel->update($id, [

            'member_code' => $this->request->getPost('member_code'),

            'full_name' => $this->request->getPost('full_name'),

            'email' => $this->request->getPost('email'),

            'phone' => $this->request->getPost('phone'),

            'gender' => $this->request->getPost('gender'),

            'membership' => $this->request->getPost('membership'),

            'status' => $this->request->getPost('status'),

            'join_date' => $this->request->getPost('join_date')

        ]);

        return redirect()->to('/members');
    }

    public function delete($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $this->memberModel->delete($id);

        return redirect()->to('/members');
    }
}








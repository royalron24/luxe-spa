<?php

namespace App\Controllers;

use App\Models\MemberModel;

class Filter extends BaseController
{
    public function index()
    {
        $model = new MemberModel();

        $keyword = $this->request->getGet('keyword');
        $membership = $this->request->getGet('membership');
        $status = $this->request->getGet('status');

        $builder = $model;

        if ($keyword) {
            $builder->groupStart()
                ->like('full_name', $keyword)
                ->orLike('email', $keyword)
                ->groupEnd();
        }

        if ($membership) {
            $builder->where('membership', $membership);
        }

        if ($status) {
            $builder->where('status', $status);
        }

        $data['members'] = $builder->findAll();

        return view('filter/index', $data);
    }
}
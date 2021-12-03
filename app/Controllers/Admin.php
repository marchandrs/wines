<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        $data['content'] = view('admin');
		return view('template/admin_template', $data);
    }
}

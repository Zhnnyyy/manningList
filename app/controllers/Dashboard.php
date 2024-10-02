<?php

class Dashboard extends Controller
{
    public function index()
    {
        $data['title'] = "Dashboard | Manninglist";
        $data['styles'] = ['<link rel="stylesheet" href="' . ROOT_CSS . 'dashboard.css">'];
        $this->view('/dashboard', $data);
    }
}
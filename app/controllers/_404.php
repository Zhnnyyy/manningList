<?php


class _404 extends Controller
{

	public function index()
	{
		$data['title'] = "404 | Manninglist";
		$data['styles'] = ['<link rel="stylesheet" href="' . ROOT_CSS . '_404.css">'];
		$this->view("/404", $data);
	}
}

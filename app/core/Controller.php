<?php

class Controller
{
    public function view($view, $data = [])
    {
        // extract($data);
        $viewLayout = "../app/view/" . $view . ".view.php";
        if (file_exists($viewLayout)) {
            $view = $viewLayout;
            include "../app/view/layout.php";
        } else {
            $view = "../app/view/404.view.php";
            include $view;
            include "../app/view/layout.php";
        }
    }
}
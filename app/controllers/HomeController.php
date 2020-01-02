<?php


// namespace App\Controllers;


class HomeController extends Controller
{
    /**
     * Default method
     */
    public function index()
    {
        $this->view('home', ['title' => 'Dashboard']);
    }
}




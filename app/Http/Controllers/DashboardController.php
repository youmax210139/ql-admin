<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Show the dashboard view.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Dashboard/Index');
    }
}

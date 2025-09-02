<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    protected $adminController;

    public function __construct(AdminController $adminController)
    {
        $this->adminController = $adminController;
    }

    public function index()
    {
        // Get average score data
        $scoreData = $this->adminController->getAverageScore();
        
        return view('user.landing', [
            'averageScore' => $scoreData['average'],
            'scoreCategory' => $scoreData['category']
        ]);
    }
}

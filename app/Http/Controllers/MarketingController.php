<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Location;

class MarketingController extends Controller
{
    public function index()
    {
        $locationsCount = Location::count();
        $clientsCount = Client::count();
        return view('marketing.home', compact('locationsCount', 'clientsCount'));
    }

    public function features()
    {
        return view('marketing.features');
    }

    public function whiteLabelAgency()
    {
        return view('marketing.white-label-agency');
    }

    public function multiLocation()
    {
        return view('marketing.industry-multi-location');
    }

    public function reviewsManagement()
    {
        return view('marketing.reviews-management');
    }

    public function postsManagement()
    {
        return view('marketing.posts-management');
    }
}

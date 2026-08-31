<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

    public function pricing()
    {
        return view('marketing.pricing');
    }

    public function location($slug)
    {
        $location = Location::with('client', 'reviews')
            ->get()
            ->first(function ($loc) use ($slug) {
                return Str::slug($loc->name) === $slug;
            });

        if (! $location) {
            abort(404);
        }

        return view('marketing.location', compact('location'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class ToolsController extends Controller
{
    public function auditTool()
    {
        $locations = Location::all();
        return view('tools.gbp-audit-tool', compact('locations'));
    }

    public function reviewLink()
    {
        return view('tools.review-link');
    }

    public function reviewQrCode()
    {
        return view('tools.review-qr-code');
    }

    public function reviewCard()
    {
        return view('tools.review-card');
    }

    public function photoSizeGuide()
    {
        return view('tools.photo-size-guide');
    }
}

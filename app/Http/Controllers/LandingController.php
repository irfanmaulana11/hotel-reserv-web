<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Hotel;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function __invoke(): View
    {
        $destinations = Destination::where('is_active', true)
            ->orderBy('is_popular', 'desc')
            ->orderBy('name')
            ->get()
            ->map(fn ($dest) => [
                'city' => $dest->city,
                'hotels' => Hotel::where('city', $dest->city)->where('is_active', true)->count(),
                'rooms' => Hotel::where('city', $dest->city)->where('is_active', true)->sum('total_rooms'),
                'image' => $dest->image_url,
            ])
            ->take(6)
            ->all();

        $stayShowcase = Hotel::where('is_active', true)
            ->orderBy('star_rating', 'desc')
            ->limit(6)
            ->get()
            ->map(fn ($hotel) => [
                'label' => strtoupper($hotel->city).', '.$hotel->country,
                'title' => $hotel->name,
                'image' => $hotel->image_url,
                'slug' => $hotel->id,
                'rating' => $hotel->star_rating,
            ])
            ->all();

        return view('landing.index', [
            'destinations' => $destinations,
            'stayShowcase' => $stayShowcase,
        ]);
    }
}

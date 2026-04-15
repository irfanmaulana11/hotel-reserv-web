<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LandingController extends Controller
{
    public function __invoke(): View
    {
        $stayShowcase = collect(config('hotel.hotels'))
            ->map(fn (array $hotel) => [
                'label' => $hotel['showcase_label'] ?? strtoupper($hotel['city']).', INDONESIA',
                'title' => $hotel['name'],
                'image' => $hotel['image'],
                'slug' => $hotel['slug'],
            ])
            ->values()
            ->all();

        return view('landing.index', [
            'destinations' => config('hotel.destinations'),
            'stayShowcase' => $stayShowcase,
        ]);
    }
}

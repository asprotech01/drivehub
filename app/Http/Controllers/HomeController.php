<?php

namespace App\Http\Controllers;

use App\Models\Mobil;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCars = Mobil::where('status_mobil', 'Tersedia')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $brands = Mobil::where('status_mobil', 'Tersedia')
            ->select('merk')
            ->distinct()
            ->pluck('merk');

        return view('index', [
            'activePage' => 'home',
            'featuredCars' => $featuredCars,
            'brands' => $brands,
        ]);
    }

    public function jualMobil()
    {
        return view('jual-mobil', ['activePage' => 'jual']);
    }

    public function dealer()
    {
        return view('dealer', ['activePage' => 'selengkapnya']);
    }

    public function whyUs()
    {
        return view('why-us', ['activePage' => 'selengkapnya']);
    }

    public function about()
    {
        return view('about', ['activePage' => 'selengkapnya']);
    }

    public function contact()
    {
        return view('contact', ['activePage' => 'selengkapnya']);
    }

    public function help()
    {
        return view('help', ['activePage' => 'selengkapnya']);
    }

    public function faq()
    {
        return view('faq', ['activePage' => 'selengkapnya']);
    }

    public function privacy()
    {
        return view('privacy', ['activePage' => 'selengkapnya']);
    }
}

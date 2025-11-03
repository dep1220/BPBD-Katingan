<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\VisiMisi;
use Illuminate\Http\Request;

class VisiMisiController extends Controller
{
    /**
     * Display the visi misi page.
     */
    public function index()
    {
        $visiMisi = VisiMisi::getActive();
        
        return view('public.profile.visi-misi', compact('visiMisi'));
    }
}

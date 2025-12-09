<?php


namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class AIController extends Controller
{
    public function index(Request $request)
    {
        return view('backend.chat.index', [
            'request' => $request,
        ]);
    }
}

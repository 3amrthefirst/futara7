<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Policy;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function policy()
    {
        $record = Policy::all();
        return response()->json([
            'code'    => 200,
            'status'  => 1,
            'errors'  => null,
            'message' => 'success',
            'data'    => $record
        ]);
    }
    public function about()
    {
        $record = About::all();
        return response()->json([
            'code'    => 200,
            'status'  => 1,
            'errors'  => null,
            'message' => 'success',
            'data'    => $record
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\HistoryResource;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        return HistoryResource::collection($request->user()->histories);
    }
}

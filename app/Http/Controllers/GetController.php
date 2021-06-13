<?php

namespace App\Http\Controllers;

use App\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetController extends Controller
{
    public function getPointsUser(){
        $getPointsUser = DB::table('points')->sum('points');
        return response()->json(['data' => $getPointsUser]);
    }
}

<?php

namespace App\Http\Controllers;

use App\AuthUser;
use App\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetController extends Controller
{
    public function getPointsUser(){
        $getPointsUser = DB::table('points')->sum('points');
        return response()->json(['data' => $getPointsUser]);
    }

    public function getUsersAuth()
    {
        $data = AuthUser::select('users_auth')->first();
        $jsoData = json_decode($data->users_auth);
        return response()->json($jsoData);
    }
}

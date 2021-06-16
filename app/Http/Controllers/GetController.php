<?php

namespace App\Http\Controllers;

use App\AuthUser;
use App\Point;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetController extends Controller
{
    public function getPointsUser($email){
        $user = User::whereEmail($email)->first();
        //$getPointsUser = DB::table('points')->sum('points');
        $points = Point::where('user_id', $user->id)->sum('points');

        //return response()->json(['data' => $getPointsUser]);
        return response()->json(['data' => $points]);
    }

    public function getUsersAuth()
    {
        $data = AuthUser::select('users_auth')->first();
        $jsoData = json_decode($data->users_auth);
        return response()->json($jsoData);
    }
}

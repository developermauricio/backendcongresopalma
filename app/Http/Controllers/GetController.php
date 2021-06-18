<?php

namespace App\Http\Controllers;

use App\AuthUser;
use App\Point;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GetController extends Controller
{
    public function getPointsUser($email){
        $user = User::whereEmail($email)->first();
        $points = Point::where('user_id', $user->id)->sum('points');

        return response()->json(['data' => $points]);
    }

    public function getListPointsUser() {
        $listUserPoints = DB::table('points')
            ->select(DB::raw('user_id, SUM(points) as points'))
            ->with('user')
            ->groupBy('user_id')
            ->get();

        return response()->json(['data' => $listUserPoints]);
    }

    public function getUsersAuth()
    {
        $data = AuthUser::select('users_auth')->first();
        $jsoData = json_decode($data->users_auth);
        return response()->json($jsoData);
    }

    public function getPointsOfUser( $email ){
        $user = User::whereEmail($email)->first();

        $points = DB::table('points')
            ->where('user_id', $user->id)
            ->groupBy('click_name','click_id')
            ->select(DB::raw('click_name,SUM(points) as points'))
            ->get();

        return response()->json(['data' => $points]);
    }

}

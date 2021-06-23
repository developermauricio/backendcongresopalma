<?php

namespace App\Http\Controllers;

use App\AuthUser;
use App\Point;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;

class GetController extends Controller
{
    public function getPointsUser($email){
        $user = User::whereEmail($email)->first();
        $points = 0;

        if ($user) {
            $points = Point::where('user_id', $user->id)->sum('points');
        }

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
        $points = [];

        if ($user) {
            $points = DB::table('points')
                ->where('user_id', $user->id)
                ->groupBy('click_name','click_id')
                ->select(DB::raw('click_name,SUM(points) as points'))
                ->get();
        }

        return response()->json(['data' => $points]);
    }

    public function getRankingPointsUsers() {

        $rankingPoints = DB::table('users')
            ->join('points', 'users.id', '=', 'points.user_id')
            ->groupBy('user_id')
            ->select('name', DB::raw('SUM(points) as points'))
            ->orderBy('points', 'desc') 
            ->limit(10)       
            ->get();
        
        return response()->json(['data' => $rankingPoints]);
    }

    public function importData(Request $request) {
        $data = $request->file('data');
        
        try {       
            $user = (new FastExcel())->import( $data, function($line) {
                return User::create([
                    'name' => $line['name'],
                    'email' => $line['email'],
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                ]);
            });
        //} catch (\Throwable $th) {
        } catch (\Exception $exception) {
            return response()->json('Error al importar', $exception);
        }

        return response()->json('importacion correcta');
    }

}

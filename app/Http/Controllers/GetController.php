<?php

namespace App\Http\Controllers;

use App\AuthUser;
use App\Point;
use App\User;
use App\Conference;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;

class GetController extends Controller
{
    public function getDateFrom() {
        //$from = Carbon::parse("21-06-2021 06:00:00", 'America/Bogota');
        //$from = Carbon::parse("29-06-2021 06:00:00", 'America/Bogota');
        //$from = Carbon::parse("02-07-2021 06:00:00", 'America/Bogota');
        $from = Carbon::parse("06-07-2021 06:00:00", 'America/Bogota');
        //$from = Carbon::parse("09-07-2021 06:00:00", 'America/Bogota');
        //$from = Carbon::parse("13-07-2021 06:00:00", 'America/Bogota');
        //$from = Carbon::parse("16-07-2021 06:00:00", 'America/Bogota');
        //$from = Carbon::parse("20-07-2021 06:00:00", 'America/Bogota');
        //$from = Carbon::parse("23-07-2021 06:00:00", 'America/Bogota');
        //$from = Carbon::parse("27-07-2021 06:00:00", 'America/Bogota');
        return $from;
    }
    public function getDateTo() {
        //$to = Carbon::parse("28-06-2021 18:00:00", 'America/Bogota');
        //$to = Carbon::parse("01-07-2021 18:00:00", 'America/Bogota');
        //$to = Carbon::parse("05-07-2021 18:00:00", 'America/Bogota');
        $to = Carbon::parse("08-07-2021 18:00:00", 'America/Bogota');
        //$to = Carbon::parse("12-07-2021 18:00:00", 'America/Bogota');
        //$to = Carbon::parse("15-07-2021 18:00:00", 'America/Bogota');
        //$to = Carbon::parse("19-07-2021 18:00:00", 'America/Bogota');
        //$to = Carbon::parse("22-07-2021 18:00:00", 'America/Bogota');
        //$to = Carbon::parse("26-07-2021 18:00:00", 'America/Bogota');
        //$to = Carbon::parse("29-07-2021 18:00:00", 'America/Bogota');
        return $to;
    }

    public function getPointsUser($email){
        $user = User::whereEmail($email)->first();
        $points = 0;
        //Log::debug($user); 

        if ($user) {
            $from = $this->getDateFrom();
            $to = $this->getDateTo();

            /* $points = Point::where('user_id', $user->id)
                ->sum('points'); */

            $points = Point::where('user_id', $user->id)
                ->whereBetween('created_at', [$from, $to])
                ->sum('points');
                //->toSql(); // TODO: imprimir la consulta.
            
            //Log::debug($points); 
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
            $from = $this->getDateFrom();
            $to = $this->getDateTo();

            $points = DB::table('points')
                ->where('user_id', $user->id)
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('click_name','click_id')
                ->select(DB::raw('click_name,SUM(points) as points'))
                ->get();
        }

        return response()->json(['data' => $points]);
    }

    public function getRankingPointsUsers() {
        $from = $this->getDateFrom();
        $to = $this->getDateTo();

        $rankingPoints = DB::table('users')
            ->join('points', 'users.id', '=', 'points.user_id')
            ->whereBetween('points.created_at', [$from, $to])
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

    public function importDataConference($data) {
        
        try {       
            $conference = (new FastExcel())->import( $data, function($line) {
                $email = $line['email'];
                Log::debug($email); 
                $user = User::whereEmail($email)->first();
                Log::debug($user); 

                if ($user) {
                    return Conference::create([
                        'name' => $user->name,
                        'email' => $user->email,
                    ]);
                }                
            });
        } catch (\Exception $exception) {
            Log::debug($exception); 
            //return response()->json('Error al importar', $exception);
        }

        //return response()->json('importacion correcta');
    }

    public function getLinkeframe() {
       $link = 'https://vimeo.com/event/1126138/embed/a0f93f0e24';
       //$link = 'https://www.youtube.com/embed/J6tpmNPYVhc';

       //$change = 'si';
       $change = 'no';

       return response()->json(['change' => $change, 'link' => $link]);
    }

}

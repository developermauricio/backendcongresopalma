<?php

namespace App\Http\Controllers;

use App\AuthUser;
use App\LoginUser;
use App\Point;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getData(Request $request)
    {
        return $request->param;
    }

    public function setPoints(Request $request)
    {
        //Log::debug($request);
        $ok = false;
        $currentUser = User::whereEmail($request->email)->first();

        if (!$currentUser) {
            return response()->json(['status' => 400, 'msg' => 'El usuario no se encuentra registrado']);
        }

        $currentPoints = Point::where('user_id', $currentUser->id)->get();
        //Log::debug(json_encode($currentPoints));

        if ($currentPoints) {
            $dateNow = Carbon::now();
            $pointExits = true;

            foreach($currentPoints as $point) {
                $created_at = new Carbon($point->created_at);

                if ($dateNow->dayOfYear == $created_at->dayOfYear && $point->click_id == $request->clickId){
                    $pointExits = false;
                    break;
                }
            }

            if ($pointExits) {
                $ok = $this->insertPoints($request, $currentUser);         
            } else {
                return response()->json(['status' => 400, 'msg' => 'Ya se asignaron los puntos']);
            }

        } else {
            $ok = $this->insertPoints($request, $currentUser);            
        }
        
        if ($ok) {
            $points = Point::where('user_id', $currentUser->id)->sum('points');
            return response()->json(['status' => 200, 'msg' => $points]);
        } else {
            return response()->json(['status' => 500, 'msg' => 'Error al realizar la transaccion']);
        }
    }

    public function insertPoints($request, $currentUser) {
        DB::beginTransaction();
        try {
            $setPoints = new Point;
            $setPoints->points = $request->points;
            $setPoints->user_id = $currentUser->id;
            $setPoints->click_id = $request->clickId;
            $setPoints->click_name = $request->clickName;
            $setPoints->save();

            DB::commit();

            return true;

        } catch (\Exception $exception) {
            $msg = $exception->getMessage();
            DB::rollBack();
            return false;
        }
    }

    public function setUserAuth(Request $request)
    {
        /*$data = json_decode($request->param);*/
        $data = json_decode($request->param);
        $userAuth = AuthUser::select('users_auth')->first();
        $msg = '';
        if ($userAuth) {
            AuthUser::where('id', 1)->update(['users_auth' => $request->param]);
            $msg = 'UPDATE';
        } else {
            $authUser = new AuthUser;
            $authUser->users_auth = $request->param;
            $authUser->save();
            $msg = 'NEW';
        }
        return response()->json([
            'data' => $data,
            'msg' => $msg
        ]);
    }

    public function setLoginUser(Request $request)
    {
        $currentEmail = $request->email;
        $currentUser = User::whereEmail($currentEmail)->first();
        Log::debug($currentEmail);

        if (!$currentUser) {
            return response()->json('No se encuentra el usuario en la base de datos');;
        }
        DB::beginTransaction();

        $logiUserIsset = LoginUser::whereEmail($currentEmail)->first();
        if ($logiUserIsset) {
            $created_at = $logiUserIsset->created_at;
            $dateNow = Carbon::now();
            $created_at = new Carbon($created_at);

            if ($dateNow->dayOfYear !== $created_at->dayOfYear){
                $this->insertLoginUser($currentUser);
            }

        } else {

            $this->insertLoginUser($currentUser);
        }
    }

    public function insertLoginUser($currentUser){
        $success = true;
        try {
            $user = new LoginUser;
            $user->name = $currentUser->name;
            $user->email = $currentUser->email;
            $user->user_id = $currentUser->id;
            $user->save();

        } catch (\Exception $exception) {
            $success = $exception->getMessage();
            DB::rollBack();
        }

        if ($success === true) {
            DB::commit();
            return response()->json('La transacción se ha realizado exitosamente');
        } else {
            return response()->json('Error al realizar la transaccion', 500);
        }
    }

}

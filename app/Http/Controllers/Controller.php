<?php

namespace App\Http\Controllers;

use App\AuthUser;
use App\Point;
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
        $success = true;
        $poinst = $request->points;
        $click = $request->idClick;

        DB::beginTransaction();
        try {
            $setPoints = new Point;
            $setPoints->points = $poinst;
            $setPoints->user_id = 1;
            $setPoints->click_id = $click;
            $setPoints->save();
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

    public function setUserAuth(Request $request)
    {
        /*$data = json_decode($request->param);*/
        $data = json_decode($request->param);
        $userAuth = AuthUser::select('users_auth')->first();
        $userAuth->users_auth = $request->param;
        $userAuth->save();
//        if ($userAuth) {
//
//            $authUser = new AuthUser;
//            $authUser->users_auth = $request->param;
//            $authUser->update();
//        } else {
//            $authUser = new AuthUser;
//            $authUser->users_auth = $request->param;
//            $authUser->save();
//        }


        return response()->json(['data' => $data]);
    }

    public function getUsersAuth()
    {
        $data = AuthUser::select('users_auth')->first();
        $jsoData = json_decode($data->users_auth);
        return response()->json($jsoData);
    }
}

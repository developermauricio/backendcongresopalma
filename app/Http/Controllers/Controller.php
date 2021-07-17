<?php

namespace App\Http\Controllers;

use App\AuthUser;
use App\LoginUser;
use App\Point;
use App\User;
use App\GoConference;
use App\Conference;
use App\Certificate;
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
        //Log::debug($currentUser);

        if (!$currentUser) {
            return response()->json(['status' => 400, 'msg' => 'El usuario no se encuentra registrado']);
        }

        $currentPoints = Point::where('user_id', $currentUser->id)->get();
        //Log::debug($currentPoints);

        if ($currentPoints) {
            $dateNow = Carbon::now('America/Bogota');
            $pointExits = true;

            foreach($currentPoints as $point) {
                $created_at = new Carbon($point->created_at, 'America/Bogota');

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
            Log::debug($setPoints);

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

        if (!$currentUser) {
            return response()->json('No se encuentra el usuario en la base de datos');
        }

        $logiUserIsset = LoginUser::whereEmail($currentEmail)->get(); 
        $success = false;      

        if ($logiUserIsset) {
            $dateNow = Carbon::now('America/Bogota');
            $existRegister = false;

            foreach($logiUserIsset as $user) {
                $created_at = new Carbon($user->created_at, 'America/Bogota');

                if ($dateNow->dayOfYear == $created_at->dayOfYear){
                    $existRegister = true;
                    break;
                }
            }
            
            if ($existRegister) {
                //Log::debug('el dia es igual'); 
                return response()->json('El usuario ' . $currentUser->name . ' Ya inicio sesión.');
            } else {
                $success = $this->insertLoginUser($currentUser);
            }

        } else {
            $success = $this->insertLoginUser($currentUser);
        }

        if ($success == true) {            
            return response()->json('La transacción se ha realizado exitosamente');
        } else {
            return response()->json('Error al realizar la transaccion', 500);
        }        
    }

    public function insertLoginUser($currentUser){        
        DB::beginTransaction();
        try {
            $user = new LoginUser;
            $user->name = $currentUser->name;
            $user->email = $currentUser->email;
            $user->user_id = $currentUser->id;
            $user->save();

            DB::commit();
            return true;

        } catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }        
    }

    public function goConference(Request $request) {
        Log::debug($request); 
        $currentUser = User::whereEmail($request->email)->first();

        if (!$currentUser) {
            return response()->json(['status' => 400, 'msg' => 'El usuario no se encuentra registrado']);
        }

        //$currentGoConference = GoConference::where('user_id', $currentUser->id)->get();
        $currentConference = Conference::where('email', $currentUser->email)->get();


        if ($currentConference) {
            $dateNow = Carbon::now('America/Bogota');
            $conferenceExits = true;

            foreach($currentConference as $conference) {
                $created_at = new Carbon($conference->created_at, 'America/Bogota');

                if ($dateNow->dayOfYear == $created_at->dayOfYear){
                    $conferenceExits = false;
                    break;
                }
            }

            if ($conferenceExits) {
                $ok = $this->insertGoConference($currentUser);         
            } else {
                return response()->json(['status' => 400, 'msg' => 'Ya ingreso a la conferencia']);
            }

        } else {
            $ok = $this->insertGoConference($currentUser);            
        }
        
        if ($ok) {
            return response()->json(['status' => 200, 'msg' => 'Registro ok']);
        } else {
            return response()->json(['status' => 500, 'msg' => 'Error al realizar la transaccion']);
        }     
    }

    public function insertGoConference($currentUser) {
        DB::beginTransaction();
        try {
            /* $setConference = new GoConference;
            $setConference->user_id = $currentUser->id;
            $setConference->click_name = $request->clickName;
            $setConference->date_entry = Carbon::now('America/Bogota');
            $setConference->save(); */
            $setConference = new Conference;
            $setConference->name = $currentUser->name;
            $setConference->email = $currentUser->email;
            $setConference->save();
            
            DB::commit();
            Log::debug($setConference); 

            return true;

        } catch (\Exception $exception) {
            $msg = $exception->getMessage();
            Log::debug($msg); 
            DB::rollBack();
            return false;
        }
    }

    public function insertDataCertificate(Request $request) {
        $currentUser = User::whereEmail($request->email)->first();
        $newRegister = false;
        Log::debug($currentUser); 

        if ( $currentUser ) {

            $currentCertificate = Certificate::where('email_user', $currentUser->email)->first();
            Log::debug($currentCertificate); 

            if ( $currentCertificate ) {
                if ($currentCertificate->intentos == 1) {
                    return response()->json(['status' => 'fail', 'msg' => 'Lo sentimos usted ya genero un certificado, Comuniquese con el administrador en caso de alguna duda.']);
                } else {
                    $newRegister = $this->createRegisterDB($request, $currentUser);
                }
            } else {
                $newRegister = $this->createRegisterDB($request, $currentUser);
            }
            
        } else {
            return response()->json(['status' => 'fail', 'msg' => 'El usuario no se encuentra registrado, por favor verifique su correo y vuelva a intentarlo.']);
        }

        if ($newRegister) {
            return response()->json(['status' => 'ok', 'msg' => 'Muchas gracias por participar en el evento, su certificado hacido generado.']);
        } 
    }

    public function createRegisterDB($request, $currentUser) {
        DB::beginTransaction();

        try {
            $certificate = new Certificate;
            $certificate->name_user = $request->name;
            $certificate->email_user = $currentUser->email;
            $certificate->username = $currentUser->name;
            $certificate->intentos = 1;
            $certificate->date_entry = Carbon::now('America/Bogota');
            $certificate->save();
            
            DB::commit();
            Log::debug($certificate); 

            return true;

        } catch (\Exception $exception) {
            $msg = $exception->getMessage();
            Log::debug($msg); 
            DB::rollBack();
            return false;
        }
    }

}

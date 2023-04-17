<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RessetPassword\saveResetPasswordRequest;
use App\Http\Traits\apiResponseTrait;
use App\Mail\ResetPassword;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller {


    use apiResponseTrait;


    public function register(Request $request) {
        $validator=$request->validate([ 'First_name'=> 'required',
            'Last_name'=> 'required',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|confirmed',

            ]);

        $user=User::create([ 'First_name'=> $validator['First_name'],
                'Last_name'=> $validator['Last_name'],
                'email'=> $validator['email'],
                'password'=>bcrypt($validator['password']),

                ]);

        $token=$user->createToken('myToken')->plainTextToken;
        $response=[ 'user'=>$user,
        'myToken'=>$token,

        ];

        return $this->apiResponse(1, 'success', $response);

    }

    public function login(Request $request) {
        $validator=$request->validate([ 'email'=> 'required|string',
            'password'=> 'required',
            ]);

        $user=User::where('email', $validator['email'])->first();
        $usepass=Hash::check($validator['password'], $user->password);

        if( !$user || !$usepass) {

            return response(["message"=>"bad login"], 401);
        }

        $token=$user->createToken('myToken')->plainTextToken;
        $response=[ 'user'=>$user,
        'myToken'=>$token,

        ];

        return $this->apiResponse(1, 'success', $response);

    }

    public function resetPassword(Request $request) {


        $user=User::where('email', $request->email)->first();

        if($user) {

            $code=rand(1111, 9999);
            $update=$user->update(['pin_code'=>$code]);


            if($update) {

                Mail::to($user->email) ->send(new ResetPassword($code));


                return $this->apiResponse(1, 'برجاء فحص هاتفك', ['pin_code_for_test'=>$code,
                    // 'mail_fails' => Mail::failures(),
                    'email'=>$user->email]);

            }

            else {
                return $this->apiResponse(0, 'حدث خطأ');
            }

        }

        else {
            return $this->apiResponse(0, 'لا يوجد حساب');
        }

    }

    public function password(saveResetPasswordRequest $request) {


        $user=User::where('pin_code', $request->pin_code)->where('pin_code', '!=', 0)->where('email', $request->email)->first();

        if($user) {
            $user->password=bcrypt($request->password);
            $user->pin_code=null;

            if($user->save()) {
                return $this->apiResponse(1, 'تم تغير كلمة المرور بنجاح');
            }

            else {
                return $this->apiResponse(0, 'حدث خطأ , حاول مرة اخري');

            }
        }

        else {
            return $this->apiResponse(0, 'هذا الكود غير صالح');
        }
    }




    public function logout() {
        auth()->user()->tokens()->delete();

        return ["message"=>"logout"];
    }


    public function registerInstractor(Request $request) {
        $validator=$request->validate([ 'First_name'=> 'required',
            'Last_name'=> 'required',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|confirmed',
            ]);

        $user=Instructor::create([ 'First_name'=> $validator['First_name'],
                'Last_name'=> $validator['Last_name'],
                'email'=> $validator['email'],
                'password'=>bcrypt($validator['password']),

                ]);

        $token=$user->createToken('myToken')->plainTextToken;
        $response=[ 'user'=>$user,
        'myToken'=>$token,

        ];

        return $this->apiResponse(1, 'success', $response);

    }


    public function loginInstractor(Request $request) {
        $validator=$request->validate([ 'email'=> 'required|string',
            'password'=> 'required',

            ]);

        $user=Instructor::where('email', $validator['email'])->first();
        $usepass=Hash::check($validator['password'], $user->password);

        if( !$user || !$usepass) {

            return response(["message"=>"bad login"], 401);
        }

        $token=$user->createToken('myToken')->plainTextToken;
        $response=[ 'user'=>$user,
        'myToken'=>$token,

        ];

        return $this->apiResponse(1, 'success', $response);

    }

    public function logoutInstructor() {
        auth()->user()->tokens()->delete();

        return ["message"=>"logout"];
    }



}

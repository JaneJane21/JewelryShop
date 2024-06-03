<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function Registration(Request $request){
        $valid = Validator::make($request->all(),[
        'fio'=>['required','regex:/[А-Яа-яЁё]/u'],
        'birthday'=>['date'],
        'email'=>['email:rfc, dns','required','unique:users'],
        'phone'=>['digits:11','required','unique:users'],
        'password'=>['required','confirmed','regex:/[0-9A-Za-z]/u','min:2','max:20'],
        'rule'=>['required']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $user = new User();
        $user->fio = $request->fio;
        if($request->birthday){
            $user->birthday = $request->birthday;
        }
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = md5($request->password);
        $user->save();
        return response()->json('вы успешно зарегистрированы',200);
    }

    public function LogUser(Request $request){
        $valid = Validator::make($request->all(),[
            'email'=>['required','email:rfc,dns'],
            'password'=>['required']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(), 400);
        };
        $user = User::query()->where('email',$request->email)->where('password',md5($request->password))->first();
        if($user){
            Auth::login($user);
            return redirect()->route('show_welcome')->with('success','Успешный вход');
        }
        else{
            return response()->json('Такой пользователь не найден', 404);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function update(Request $request){
        // dd($request->all());

        $valid = Validator::make($request->all(), [
            'fio'=>['required','regex:/[А-Яа-яЁё]/u'],
            'birthday'=>['date'],
            'email'=>['email:rfc, dns','required',Rule::unique('users')->ignore(Auth::id())],
            'phone'=>['digits:11','required',Rule::unique('users')->ignore(Auth::id())],
            ]);
            if($request->password){
                $valid = Validator::make($request->password,[
                    'password'=>['confirmed','regex:/[0-9A-Za-z]/u','min:2','max:20'],
                ]);
            }
            if($valid->fails()){
                return response()->json($valid->errors(),400);
            }
            $user = User::query()->where('id',Auth::id())->first();
            $user->fio = $request->fio;

            $user->birthday = $request->birthday;
            if($request->password){
                $user->password = md5($request->password);
            }
            $user->email = $request->email;
            $user->phone = $request->phone;

            $user->update();
            return response()->json('данные профиля изменены',200);
    }

    public function destroy(){
        $user = User::query()->where('id',Auth::id())->first();
        $user->delete();
        return redirect()->route('show_reg');
    }
}

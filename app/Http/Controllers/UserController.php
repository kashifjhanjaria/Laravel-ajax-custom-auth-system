<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function index()
    {
        return view('auth.login');
    }
    public function register()
    {
        if (session()->has('loggedInUser')) {
            # code...
            return redirect('profile');
        } else {
            # code...
            return view('auth.register');
        }

    }
    public function forget()
    {
        return view('auth.forget');
    }

    public function reset()
    {
        return view('auth.reset');
    }
    public function saveUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:25',
            'email' => 'required|email|unique:users|max:100',
            'password' => 'required|min:6|max:50',
            'cpassword' => 'required|min:6|max:50|same:password',
        ], [
            'cpassword.same' => 'Password did not matched!',
            'cpassword.required' => 'Confirm password is required!',

        ]);
        if ($validator->fails()) {
            # code...
            return response()->json([
                'status' => 400,
                'message' => $validator->getMessageBag(),
            ]);
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json([
                'status' => 200,
                'message' => 'Register Successfully',
            ]);
        }
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6|max:50',

        ]);
        if ($validator->fails()) {
            # code...
            return response()->json([
                'status' => 400,
                'message' => $validator->getMessageBag(),
            ]);
        } else {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    # code...
                    $request->session()->put('loggedInUser', $user->id);
                    return response()->json([
                        'status' => 200,
                        'message' => 'success',
                    ]);

                } else {
                    return response()->json([
                        'status' => 401,
                        'message' => 'E-mail Or Password incorect',
                    ]);
                }
            } else {

                return response()->json([
                    'status' => 401,
                    'message' => 'User not found!',
                ]);

            }
        }
    }
    public function profile()
    {

        $user = DB::table('users')->where('id', session('loggedInUser'))->first();

        return view('profile', compact('user'));
    }

    public function logout()
    {
        if (session()->has('loggedInUser')) {
            session()->pull('loggedInUser');
            return redirect('/');
        }
    }

    public function profileImageUpdate(Request $request)
    {
        $user_id = $request->user_id;
        $user = User::find($user_id);
        if ($request->hasFile('picture')) {
            # code...
            $file = $request->file('picture');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images/', $fileName);
            if ($user->picture) {
                # code...
                Storage::delete('public/images/' . $user->picture);
            }
        }
        User::where('id', $user_id)->update([
            'picture' => $fileName,
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Picture Updated Successfully',
        ]);
    }

    public function profileupdate(Request $request)
    {
        $user_id = $request->id;

        User::where('id', $user_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'phone' => $request->phone,

        ]);
        return response()->json([

            'status' => 200,
            'message' => 'Profile Updated Successfully',
        ]);
    }

}
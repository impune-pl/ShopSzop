<?php

namespace App\Http\Controllers;

use App\Mail\UniversalNotification;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::with(['orders'])->get());
    }

    public function login(Request $request)
    {
        $status = 401;
        $response = ['error' => 'Unauthorised'];

        if (Auth::attempt($request->only(['email', 'password']))) {
            $status = 200;
            $response = [
                'user' => Auth::user(),
                'token' => Auth::user()->createToken('ShopSzop')->accessToken,
            ];
        }

        return response()->json($response, $status);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:60',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $user->is_admin = 0;

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('SzopShop')->accessToken,
        ]);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function admin(User $user)
    {
        $user->isAdmin=TRUE;
        $user->save();
        return response()->json([
            'status' => (bool) $user,
            'data'   => $user,
            'message' => $user ? 'Order placed' : 'Error placing order'
        ]);
    }
    public function unadmin(User $user)
    {
        $user->isAdmin=FALSE;
        $user->save();
        return response()->json([
            'status' => (bool) $user,
            'data'   => $user,
            'message' => $user ? 'Order placed' : 'Error placing order'
        ]);
    }
    public function ban(User $user)
    {
        $user->isBanned=TRUE;
        $user->save();
        return response()->json([
            'status' => (bool) $user,
            'data'   => $user,
            'message' => $user ? 'Order placed' : 'Error placing order'
        ]);
    }
    public function unban(User $user)
    {
        $user->isBanned=FALSE;
        $user->save();
        return response()->json([
            'status' => (bool) $user,
            'data'   => $user,
            'message' => $user ? 'Order placed' : 'Error placing order'
        ]);
    }
    public function notify(Request $request)
    {
        $user = User::find($request->recipient_user_id);
        $data=['name'=>$user->name,'text'=>$request->text];
        Mail::to($user)->send(new UniversalNotification($data));
    }
    public function notifyAll(Request $request)
    {
        $data = ['text'=>$request->text];
        $users = User::all();
        Mail::bcc($users)->send(new UniversalNotification($data));
    }
}

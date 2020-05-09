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
    public function index(Request $request)
    {
        $id = $request->user()->id;
        return response()->json(User::where('user_id','=', $id)->get());
    }

    public function indexAll()
    {
        return response()->json(User::all());
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
        $data[ 'isAdmin']=FALSE;
        $data[ 'isBanned']=FALSE;
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

    public function admin(int $id)
    {
        $user=User::where('id','=',$id)->first();
        $user->isAdmin=TRUE;
        $user->save();
        return response()->json([
            'status' => (bool) $user,
            'data'   => $user,
            'message' => $user ? 'User granted admin privileges' : 'Error elevating user privileges'
        ]);
    }
    public function unadmin(int $id)
    {
        $user=User::where('id','=',$id)->first();
        $user->isAdmin=FALSE;
        $user->save();
        return response()->json([
            'status' => (bool) $user,
            'data'   => $user,
            'message' => $user ? 'User demoted' : 'Error demoting user'
        ]);
    }
    public function ban(int $id)
    {
        $user=User::where('id','=',$id)->first();
        $user->isBanned=TRUE;
        $user->save();
        return response()->json([
            'status' => (bool) $user,
            'data'   => $user,
            'message' => $user ? 'User banned' : 'Error banning user'
        ]);
    }
    public function unban(int $id)
    {
        $user=User::where('id','=',$id)->first();
        $user->isBanned=FALSE;
        $user->save();
        return response()->json([
            'status' => (bool) $user,
            'data'   => $user,
            'message' => $user ? 'User unbanned' : 'Error unbanning user'
        ]);
    }
    public function notify(Request $request, String $email)
    {
        $user = User::where('email','like',$email)->first();
        $data=['name'=>$user->name,'text'=>$request->text];
        Mail::to($user)->send(new UniversalNotification($data));
    }
    public function notifyAll(Request $request)
    {
        $data = ['text'=>$request->notificationText];
        $users = User::all();
        dump($users);
        Mail::bcc($users)->send(new UniversalNotification($data));
    }
}

<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller {
    public function __construct() {
        $this->middleware('can:read user', [
            'only' => ['index', 'show', 'internalUsers'],
        ]);
        $this->middleware('can:create user', [
            'only' => ['create', 'store'],
        ]);
        $this->middleware('can:update user', [
            'only' => ['update', 'edit'],
        ]);
        $this->middleware('can:delete user', [
            'only' => ['destroy'],
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $user = Auth::user();
        $data = User::with('roles')
        ->whereHas('roles', function (Builder $q) {
            $q->where('name', '=', 'partner', 'or');
            $q->where('name', 'user');
        })
        ->whereNot('id', auth()->id())
        ->latest()->paginate(paginateCount());

        return view('backend.users.view-users', compact('user', 'data'));
    }

    /**
     * Display a listing of the resource.
     */
    public function internalUsers() {
        $goBackUrl = route('users.internal');
        session()->put('go_back_url', $goBackUrl);

        $user = Auth::user();
        $data = User::with('roles')
        ->whereHas('roles', function (Builder $q) {
            $q->whereNot('name', 'partner', 'or');
            $q->whereNot('name', 'user');
        })
        ->whereNot('id', auth()->id())->latest()->latest()->paginate(paginateCount());

        return view('backend.users.view-users', compact('user', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $roles = Role::all();

        return view('backend.users.create-users', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'user_name' => 'required|unique:users,user_name',
            'email' => 'required|unique:users,email',
            'phone' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'admin_ref' => 'required',
            'user_image' => 'required|image',
        ]);

        $userData = new User();
        $userData->name = $request->name;
        $userData->user_name = $request->user_name;
        $userData->email = $request->email;
        $userData->email_verified_at = now();
        $userData->admin_ref = $request->admin_ref;
        $userData->phone = $request->phone;
        $userData->password = Hash::make($request->password);
        if ($request->hasFile('user_image')) {
            $userData->image_url = saveImage($request->user_image, 'profile', 'user-image');
        }
        $userData->save();
        $userData->assignRole($request->role_id);
        $userData->refresh();

        $notification = [
            'message' => 'User Profile Created',
            'alert-type' => 'success',
        ];
        if ('expert' == $userData->role_name) {
            return redirect(route('expert-profile.create')."?user_id=$userData->id")->with($notification);
        }

        if (session()->has('go_back_url')) {
            $goBackUrl = session('go_back_url');
            session()->forget('go_back_url');
        } else {
            $goBackUrl = route('users.index');
        }

        return redirect($goBackUrl)->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        $user = User::with('roles')->where('id', $id)->first();
        $roles = Role::all();

        return view('backend.users.edit-users', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            'user_name' => "unique:users,user_name,$id",
            'email' => "unique:users,email,$id",
            'phone' => 'required',
            'admin_ref' => 'required',
        ]);

        $userData = User::findOrFail($id);
        $userData->name = $request->name;
        $userData->user_name = $request->user_name;
        $userData->email = $request->email;
        $userData->admin_ref = $request->admin_ref;
        $userData->phone = $request->phone;
        if ($request->hasFile('user_image')) {
            $old_path = $userData->image_url;
            $userData->image_url = updateFile($request->user_image, $old_path, 'profile', 'user-image');
        }
        $userData->save();
        $userData->assignRole($request->role_id);

        $notification = [
            'message' => 'User Profile Updated',
            'alert-type' => 'success',
        ];
        if ('expert' == $userData->role_name) {
            $url = $userData->expertProfile ?
            route('expert-profile.edit', ['expert_profile' => $userData->expertProfile->id])."?user_id=$userData->id"
            :
            route('expert-profile.create')."?user_id=$userData->id";

            return redirect($url)->with($notification);
        }

        if (session()->has('go_back_url')) {
            $goBackUrl = session('go_back_url');
            session()->forget('go_back_url');
        } else {
            $goBackUrl = route('users.index');
        }

        return redirect($goBackUrl)->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $user = User::find($id);
        $explode = explode('/', $user->image_url);
        $imageName = end($explode);
        $path = 'public/uploads/profile/'.$imageName;
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
        User::where('id', $id)->delete();

        $notification = [
            'message' => 'User Profile Deleted Successfully',
            'alert-type' => 'success',
        ];
        if (session()->has('go_back_url')) {
            $goBackUrl = session('go_back_url');
            session()->forget('go_back_url');
        } else {
            $goBackUrl = route('users.index');
        }

        return redirect($goBackUrl)->with($notification);
    }
}

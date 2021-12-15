<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'workplace'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getEmail(Request $request) {
        $user = collect(User::find($request->input('id')));
        return $user->get('email');
    }

    public function uploadImg(Request $request, $id) {
        $path = $request->file('photo')
            ->storeAs('userphoto',$id.'_'.$request->input('email').'.jpg');
        return $path;
    }

    public function addNewUserInfo(Request $request, $id)
    {
        User::where('email', $id)->update([
            'name'=>$request->input('name'),
            'workplace'=>$request->input('workplace'),
            'mobile'=>$request->input('mobile'),
            'adress'=>$request->input('adress'),
            'status' => $request->input('status'),
            'vk' => $request->input('vk'),
            'telegram' => $request->input('telegram'),
            'instagram' => $request->input('istagram'),
            'photo' => $this->uploadImg($request, $id),
        ]);
    }

    public function editUserGeneralInfo(Request $request)
    {
        User::where('id', $request->input('id'))->update([
            'name'=>$request->input('name'),
            'workplace'=>$request->input('workplace'),
            'mobile'=>$request->input('mobile'),
            'adress'=>$request->input('adress')
        ]);
    }

    public function editUserStatusInfo(Request $request)
    {
        User::where('id', $request->input('id'))->update([
            'status'=>$request->input('status')
        ]);
    }

    public function editUserMediaInfo(Request $request)
    {
        if (!$request->file()) {
            return redirect('/users');
        }
        User::where('id', $request->input('id'))->update([
            'photo'=> $this->uploadImg($request, $request->input('id'))
        ]);
    }

    public function changePass (Request $request) {

        $request->validate([
            'newPassword' => 'required|string|min:6'
        ]);
        User::where('id', $request->input('id'))->update([
            'password'=>Hash::make($request->input('newPassword'))
        ]);
    }

    public function changeEmail(Request $request) {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users'
        ]);

        User::where('id', $request->input('id'))->update([
            'email'=>$request->input('email')
        ]);
    }

    public function allowAccess(Request $request) {
        if (Gate::denies('can-edit-info', [$request])) {
            $request->session()->flash('status', 'Доступ запрещен');
            return redirect('/users');
        }
    }



}

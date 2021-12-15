<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    private $register;
    private $user;

    public function __construct(User $user, RegisterController $register)
    {
        $this->register = $register;
        $this->user = $user;
    }

    public function addNewUser (Request $request, User $user)
    {
        if (Gate::denies('can-add-user', [$user])) {
            $request->session()->flash('status', 'Доступ запрещен');
            return redirect('/users');
        }
        $id = $this->register->regUser($request);
        $this->user->addNewUserInfo($request, $id);
        return redirect('/users');
    }

    public function editUserGeneralInfo(Request $request, User $user)
    {
        if  (Gate::denies('can-edit-info', [$request])) {
            $request->session()->flash('error', 'Доступ запрещен');
            return redirect('/users');
        };

        $user->editUserGeneralInfo($request);
        $request->session()->flash('status', 'Данные успешно обновленны');
        return redirect('/users');
    }

    public function editUserStatusInfo(Request $request)
    {
        if (Gate::denies('can-edit-info', [$request])) {
            $request->session()->flash('status', 'Доступ запрещен');
            return redirect('/users');
        }
        $this->user->editUserStatusInfo($request);
        return redirect('/users');
    }

    public function editUserMediaInfo(Request $request)
    {
        if (Gate::denies('can-edit-info', [$request])) {
            $request->session()->flash('status', 'Доступ запрещен');
            return redirect('/users');
        }
        $this->user->editUserMediaInfo($request);
        return redirect('/users');
    }

    public function editUserSecurInfo(Request $request)
    {
        if (Gate::denies('can-edit-info', [$request])) {
            $request->session()->flash('status', 'Доступ запрещен');
            return redirect('/users');
        }

        if ($request->input('newPassword') == '' and $this->user->getEmail($request) == $request->input('email')) {
            return redirect('/users');
        } elseif ($request->input('newPassword') != '' and $this->user->getEmail($request) == $request->input('email')) {
            if ($request->input('newPassword') != $request->input('oldPassword')) {
                return redirect("/security");
            } $this->user->changePass($request);
          return redirect('/users');
        } elseif($request->input('newPassword') == '' and $this->user->getEmail($request) != $request->input('email')) {
            $this->user->changeEmail($request);
            return redirect('/users');
        } elseif($request->input('newPassword') != '' and $this->user->getEmail($request) != $request->input('email')) {
            $this->user->changePass($request);
            $this->user->changeEmail($request);
            return redirect('/users');
        }
    }

    public function delUser($id, Request $request) {
        if (Gate::denies('can-edit-info', [$request])) {
            $request->session()->flash('status', 'Доступ запрещен');
            return redirect('/users');
        }
        $photo = User::all()->find($id)->getAttribute('photo');
        Storage::delete($photo);
        User::destroy($id);
        return redirect('/users');
    }

    public function showUserProfile($id)
    {
        $user = User::all()->find($id);
        return view('profile', ['user'=>$user]);
    }

    public function showUserSecurForm($id, Request $request)
    {
        if (Gate::denies('can-edit-info', [$request])) {
            $request->session()->flash('status', 'Доступ запрещен');
            return redirect('/users');
        }
        $user = User::all()->find($id);
        return view('security', ['user'=>$user]);
    }

    public function showUserGeneralForm($id, User $user, Request $request)
    {
        if  (Gate::denies('can-edit-info', [$request])) {
            $request->session()->flash('status', 'Доступ запрещен');
            return redirect('/users');
        };
        $user1 = User::all()->find($id);
        return view('general', ['user'=>$user1]);
    }

    public function showUserMediaForm(Request $request, $id)
    {
        if (Gate::denies('can-edit-info', [$request])) {
            $request->session()->flash('status', 'Доступ запрещен');
            return redirect('/users');
        }
        $user = User::all()->find($id);
        return view('media', ['user'=>$user]);
    }

    public function showUserStatusForm($id, Request $request)
    {
        if (Gate::denies('can-edit-info', [$request])) {
            $request->session()->flash('status', 'Доступ запрещен');
            return redirect('/users');
        }
        $user = User::all()->find($id);
        return view('status', ['user'=>$user]);
    }

    public function showCreateUserForm(User $user, Request $request)
    {
        if (Gate::denies('can-add-user', [$user])) {
            $request->session()->flash('status', 'Доступ запрещен');
            return redirect('/users');
        }
        return view('createuser');
    }

    public function showUsersList(Request $request)
    {
        $users = User::all();
        $request = $request->all();
        return view('users', ['users'=>$users, 'request'=>$request]);
    }

    public function test(User $user, Request $request)
    {
        $user = factory(User::class)->create();
    }


}

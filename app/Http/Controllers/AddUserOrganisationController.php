<?php

namespace App\Http\Controllers;

use App\Models\OrganisationEmployees;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Organisation;
class AddUserOrganisationController extends Controller
{
    public function getUsers()
    {
        return view('organisation.user.users',
            [
                'data' => OrganisationEmployees::where('id_organisation', '=', Organisation::where('id_user', session('user')->id)->first()->id)->join('users', 'organisation_employees.id_user', '=', 'users.id')->get(),
                'title' => 'Uporbaniki organizacije'
            ]
        );
    }

    public function getAddUser()
    {
        return view('organisation.user.userAdd',
            [
                'data' => User::where('role', 'ORG')->whereNot('id', session('user')->id)->whereNotIn('id', OrganisationEmployees::select('id_user')
                    ->where('id_organisation', Organisation::where('id_user', session('user')->id)->first()->id)
                )
                ->get(),
                'title' => 'Dodaj uporabnika'
            ]
        );
    }

    public function postAddUser(Request $request, User $userId)
    {
        OrganisationEmployees::create([
            'id_organisation' => Organisation::where('id_user', session('user')->id)->first()->id,
            'id_user' => $userId->id
        ]);
        return redirect()->route('organisation.users')->with('message', 'Uporabnik uspešno dodan!');
    }

    public function deleteUser(Request $request, User $userId)
    {
        OrganisationEmployees::where('id_user', $userId->id)->delete();
        return redirect()->route('organisation.users')->with('message', 'Uporabnik uspešno odstranjen!');
    }
}

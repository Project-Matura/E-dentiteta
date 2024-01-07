<?php

namespace App\Http\Controllers;

use App\Models\OrganisationUser;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Card;
use App\Models\UserCard;
use Illuminate\Support\Facades\Hash;

class AddUserController extends Controller
{
    public function getUsers()
    {
        return view(
            'admin.users.users',
            [
                'title' => 'Uporabniki',
                'data' => User::all()
            ]
        );
    }

    public function getUser(Request $request, User $userId)
    {
        return view(
            'admin.users.user',
            [
                'title' => 'Uporabnik',
                'existingDataa' => (object) User::select('users.*', 'id_user', 'id_card', 'user_cards.id')->leftJoin('user_cards', 'users.id', '=', 'user_cards.id_user')->where('users.id', '=', $userId->id)->get(),
                'cardInfo' => Card::all(),
                'userCards' => UserCard::where('id_user', $userId->id)->select('id_card')->get(),
                'existingData' => $userId,
                'roles' => User::distinct('role')->pluck('role'),
            ]
        );
    }

    public function postUser(Request $request, User $userId)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:255'],
            'surname' => ['required', 'max:255'],
            'role' => ['required', 'in:USR,ORG,ADM'],
        ]);
        if ($request->username != $userId->username) {
            $validatedUsername = $request->validate([
                'username' => ['required', 'max:255', 'unique:users'],
            ]);
            $userId->update([
                'username' => $validatedUsername['username'],
            ]);
        }
        if ($request->email != $userId->email) {
            $validatedEmail = $request->validate([
                'email' => ['required', 'email', 'max:255', 'unique:users'],
            ]);
            $userId->update([
                'email' => $validatedEmail['email'],
            ]);
        }
        $userId->update([
            'name' => $validated['name'],
            'surname' => $validated['surname'],
            'role' => $validated['role'],

        ]);
        $selectedCards = $request->input('cards', []);
        $userCards = UserCard::where('id_user', $userId->id)->get();
        foreach ($userCards as $userCard) {
            if (!in_array($userCard->id_card, $selectedCards)) {
                $userIds = $userId->id;
                $userCardId = $userCard->id_card;
                $idOrganisation = Card::where('id', $userCardId)->first()->id_organisation;
                if (
                    UserCard::where('id_user', $userIds)
                        ->whereIn('id_card', function ($query) use ($idOrganisation) {
                            $query->select('id')
                                ->from('cards')
                                ->where('id_organisation', $idOrganisation);
                        })
                        ->count() == 1
                ) {

                    $organisationUser = OrganisationUser::where('id_user', $userId->id)->where('id_organisation', Card::where('id', $userCard->id_card)->first()->id_organisation)->first();
                    $organisationUser->delete();
                }
                $userCard->delete();
            }
        }
        foreach ($selectedCards as $selectedCard) {
            if (!in_array($selectedCard, $userCards->pluck('id_card')->toArray())) {
                $userCard = new UserCard([
                    'id_user' => $userId->id,
                    'id_card' => $selectedCard,
                ]);
                $userIds = $userId->id;
                $selectedCardId = Card::where('id', $selectedCard)->first()->id_organisation;

                $isNotMember = OrganisationUser::where('id_user', $userIds)
                    ->where('id_organisation', $selectedCardId)
                    ->exists();
                if (!$isNotMember) {
                    $organisationUser = new OrganisationUser([
                        'id_user' => $userId->id,
                        'id_organisation' => Card::where('id', $selectedCard)->first()->id_organisation,
                    ]);
                    $organisationUser->save();
                }
                $userCard->save();
            }
        }
        return redirect()->route('admin.users')->with('message', 'Podatki o uporabniku so bili posodobljeni!');
    }

    public function getAddUser(Request $request, User $userId)
    {
        return view(
            'admin.users.userAdd',
            [
                'title' => 'Dodaj uporabnika',
                'cardInfo' => Card::all(),
                'existingData' => $userId,
                'roles' => User::distinct('role')->pluck('role'),
            ]
        );
    }

    public function postAddUser(Request $request, User $userId)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:255'],
            'surname' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'username' => ['required', 'max:255', 'unique:users'],
            'emso' => ['required', 'numeric', 'unique:users', 'digits:13'],
            'role' => ['required'],
        ]);
        $selectedCards = $request->input('cards', []);
        $user = new User([
            'name' => $validated['name'],
            'surname' => $validated['surname'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['emso']),
            'emso' => $validated['emso'],
            'role' => $validated['role'],
        ]);
        $user->save();
        $selectedCards = $request->input('cards', []);
        foreach ($selectedCards as $selectedCard) {
            $userCard = new UserCard([
                'id_user' => $user->id,
                'id_card' => $selectedCard,
            ]);
            $userCard->save();
            if (!(OrganisationUser::where('id_user', $user->id)->where('id_organisation', Card::where('id', $selectedCard))->exists())) {
                $organisationUser = new OrganisationUser([
                    'id_user' => $user->id,
                    'id_organisation' => Card::where('id', $selectedCard)->first()->id_organisation,
                ]);
                $organisationUser->save();
            }
        }
        return redirect()->route('admin.users')->with('message', 'Uporabnik ustvarjen!');
    }

    public function deleteUser(Request $request, User $userId)
    {
        UserCard::where('id_user', $userId->id)->delete();
        OrganisationUser::where('id_user', $userId->id)->delete();
        $userId->delete();
        return redirect()->route('admin.users')->with('message', 'Uporabnik je izbrisan!');
    }

}

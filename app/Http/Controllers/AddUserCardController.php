<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\OrganisationUser;
use App\Models\UserCard;
use App\Models\RequestCard;

class AddUserCardController extends Controller
{
    public function getCards()
    {
        return view(
            'user.card.cards',
            [
                'title' => 'Seznam kartic',
                'data' => UserCard::join('cards', 'cards.id', '=', 'user_cards.id_card')->where('id_user', session('user')->id)->get(),
            ]
        );
    }

    public function getCard(Request $request, Card $cardId)
    {
        return view(
            'user.card.card',
            [
                'title' => 'Kartica ' . $cardId->name,
                'card' => $cardId,
            ]
        );
    }

    public function postCard(Request $request, Card $cardId)
    {
        // Logic for handling the "user.card.update" route (POST and PUT methods)
    }

    public function getAddCard()
    {
        $userId = session('user')->id;
        //TODO: You can make join with pivot points

        $cards = Card::whereDoesntHave('userCards', function ($query) use ($userId) {
            $query->where('id_user', $userId);
        })
            ->whereDoesntHave('requestCards', function ($query) use ($userId) {
                $query->where('id_user', $userId);
            })
            ->get();

        return view(
            'user.card.cardJoin',
            [
                'title' => 'Dodaj kartico',
                'data' => $cards,
            ]
        );
    }

    public function postAddCard(Request $request, Card $cardId)
    {
        $userId = session('user')->id;
        $selectedOrganisationId = $cardId->id_organisation;

        $isNotMember = !OrganisationUser::where('id_user', $userId)
            ->where('id_organisation', $selectedOrganisationId)
            ->exists();
        if ($cardId->auto_join == 'Y') {
            UserCard::create([
                'id_user' => $userId,
                'id_card' => $cardId->id,
            ]);
            if ($isNotMember) {
                OrganisationUser::create([
                    'id_user' => $userId,
                    'id_organisation' => $selectedOrganisationId,
                ]);
            }
            return redirect()->route('user.card.join')->with('message', 'Kartica je bila dodana!');
        } else {
            RequestCard::create([
                'id_user' => $userId,
                'id_card' => $cardId->id,
                'id_organisation' => $selectedOrganisationId,
            ]);
            return redirect()->route('user.card.join')->with('message', 'Kartica je bila zahtevana!');
        }
    }

    public function deleteCard(Request $request, Card $cardId)
    {
        $userId = session('user')->id;
        $userOrganisationId = UserCard::where('id_user', $userId)->where('id_card', $cardId->id)->first()->join('cards', 'cards.id', '=', 'user_cards.id_card')->first()->id_organisation;
        UserCard::where('id_user', $userId)->where('id_card', $cardId->id)->delete();
        if (
            UserCard::where('id_user', $userId)
                ->whereIn('id_card', function ($query) use ($userOrganisationId) {
                    $query->select('id')
                        ->from('cards')
                        ->where('id_organisation', $userOrganisationId);
                })
                ->count() == 0
        ) {
            $organisationUser = OrganisationUser::where('id_user', $userId)->where('id_organisation', $userOrganisationId)->first();
            $organisationUser->delete();
        }
        return redirect()->route('user.cards')->with('message', 'Kartica je izbrisan!');
    }
}

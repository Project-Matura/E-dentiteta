<?php

namespace App\Http\Controllers;

use App\Models\OrganisationUser;
use App\Models\UserCard;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Organisation;
use App\Models\OrganisationEmployees;
use App\Models\RequestCard;

class OrganisationCardsController extends Controller
{
    public function getCards()
    {
        $userId = session('user')->id;

        $organisationIds = Organisation::where('id_user', $userId)
            ->pluck('id')
            ->merge(OrganisationEmployees::where('id_user', $userId)->pluck('id_organisation'))
            ->unique();

        
        $cards = Card::whereIn('id_organisation', $organisationIds)->get();

        return view(
            'organisation.card.cards',
            [
                'title' => 'Kartice organizacije',
                'data' => $cards,
            ]
        );
    }

    public function getCard(Request $request, Card $cardId)
    {
        return view('organisation.card.card',
            [
                'title' => 'Kartica',
                'existingData' => $cardId,
            ]);
    }

    public function postCard(Request $request, Card $cardId)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:255'],
            'description' => ['max:255'],
            'auto_join' => ['required', 'in:Y,N'],
        ]);

        $cardId->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'auto_join' => $validated['auto_join'],
        ]);
        return redirect()->route('organisation.cards')->with('message', 'Podatki o kartici so bili posodobljeni!');
    }

    public function getAddCard()
    {
        return view('organisation.card.cardCreate',
            [
                'title' => 'Dodajanj kartico',
                'existingData' => (object) [],
            ]);
    }

    public function postAddCard(Request $request, Card $cardId)
    {
        $userId = session('user')->id;

        $organisationIds = Organisation::where('id_user', $userId)
            ->pluck('id')
            ->merge(OrganisationEmployees::where('id_user', $userId)->pluck('id_organisation'))
            ->first();

    
        $validated = $request->validate([
            'name' => ['required', 'max:255'],
            'description' => ['max:255'],
            'auto_join' => ['required', 'in:Y,N'],
        ]);

        $card = new Card([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'id_organisation' => $organisationIds,
            'auto_join' => $validated['auto_join'],
        ]);
        $card->save();
        return redirect()->route('organisation.cards')->with('message', 'Katrica ustvarjena!');
    }

    public function getApproveCards()
    {
        $userId = session('user')->id;

        $organisationIds = Organisation::where('id_user', $userId)
            ->pluck('id')
            ->merge(OrganisationEmployees::where('id_user', $userId)->pluck('id_organisation'))
            ->first();
            if(RequestCard::where('id_organisation', $organisationIds)->exists()){
                $data = RequestCard::where('request_card.id_organisation', $organisationIds)
                ->join('users', 'users.id', '=', 'request_card.id_user')
                ->join('cards', 'cards.id', '=', 'request_card.id_card')
                ->get([
                    'request_card.*',
                    'users.name as user_name',
                    'users.*', 
                    'cards.name as card_name', 
                ]);
            }
            else{
                $data = [];
            }
        return view('organisation.card.cardApprove',
            [
                'title' => 'Potrdi kartico',
                'data' => $data,
            ]);
    }

    public function getApproveCard(Request $request, RequestCard $requestId)
    {
        $idCard = $requestId->id_card;
        $idUser = $requestId->id_user;
        $idOrganisation = $requestId->id_organisation;
        $requestId->delete();
        $userCard = new UserCard([
            'id_card' => $idCard,
            'id_user' => $idUser,
        ]);
        $userCard->save();
        if(OrganisationUser::where('id_organisation', $idOrganisation)->where('id_user', $idUser)->exists()){
            return redirect()->route('organisation.card.approve')->with('message', 'Kartica je bila potrjena!');
        }
        else{
            $organisationUser = new OrganisationUser([
                'id_organisation' => $idOrganisation,
                'id_user' => $idUser,
            ]);
            $organisationUser->save();
            return redirect()->route('organisation.card.approve')->with('message', 'Kartica je bila potrjena!');
        }

    }
    public function getDeclineCard(Request $request, RequestCard $requestId)
    {
        $requestId->delete();
        return redirect()->route('organisation.card.approve')->with('message', 'Kartica je bila zavrnjena!');
    }

    public function deleteCard(Request $requst, Card $cardId)
    {
        RequestCard::where('id_card', $cardId->id)->delete();
        UserCard::where('id_card', $cardId->id)->delete();
        $numberOfCards = Card::where('id_organisation', $cardId->id_organisation)->count();
        if($numberOfCards == 1){
            OrganisationUser::where('id_organisation', $cardId->id_organisation)->delete();
        }
        $cardId->delete();
        return redirect()->route('organisation.cards')->with('message', 'Kartica je bila izbrisana!');
    }
}

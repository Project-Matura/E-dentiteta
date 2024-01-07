@extends('layout')

@section('content')
    <div class="card">
        <div class="card-header">{{ __('Ustvari kartico') }}</div>
        <div class="card-body">
            <x-form :existingData="$existingData" submitRouteName="organisation.card" backRouteName="organisation.cards"
                submitButtonName="Shrani podatke" backButtonName="Nazaj" variableName="cardId">

                <x-input type="text" name="name" displayedName="Ime kartice" placeholder="Vnesite ime kartice"/>

                <x-input type="text" name="description" displayedName="Opis kartice"
                    placeholder="Vnesite kratek opis kartice"/>

                    <label for="auto_join">Odprt pristop k kartici</label>
                    <select class="form-control" name="auto_join" id="auto_join">
                        <option value="Y">Da</option>
                        <option value="N">Ne</option>
                    </select>
            </x-form>
        </div>
    </div>
@endsection

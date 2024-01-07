@extends('layout')

@section('content')
    <div class="card">
        <div class="card-header">{{ __('Ustvari kartico') }}</div>
        <div class="card-body">
            <x-form :existingData="$existingData" submitRouteName="admin.card" backRouteName="admin.cards"
                submitButtonName="Shrani podatke" backButtonName="Nazaj" :orgInfo="$orgInfo" variableName="cardId">

                <x-input type="text" name="name" displayedName="Ime kartice" placeholder="Vnesite ime kartice"/>

                <x-input type="text" name="description" displayedName="Opis kartice"
                    placeholder="Vnesite kratek opis kartice"/>


                    <label for="organisation">Organizacija</label>
                    <select class="form-control" name="organisation" id="organisation">
                        @foreach ($orgInfo as $row)
                            <option value="{{ $row?->id }}">{{ $row?->name }}</option>
                        @endforeach
                    </select>

                    <label for="auto_join">Odprt pristop k kartici</label>
                    <select class="form-control" name="auto_join" id="auto_join">
                        <option value="Y">Da</option>
                        <option value="N">Ne</option>
                    </select>
            </x-form>
        </div>
    </div>
@endsection

@extends('layout')

@section('content')
    <div class="card">
        <div class="card-header">{{ __('Podatki o uporabniku') }}</div>
        <div class="card-body">
            <x-form :existingDataa="$existingDataa" submitRouteName="admin.user" backRouteName="admin.users"
                submitButtonName="Shrani uporabnika" backButtonName="Nazaj" :cardInfo="$cardInfo" variableName="userId" :roles="$roles" :existingData="$existingData" :userCards="$userCards"> 

                <x-input type="text" name="name" displayedName="Ime" placeholder="Vnesite ime"
                    :value="$existingDataa[0]->name ?? ''" />

                <x-input type="text" name="surname" displayedName="Priimek" placeholder="Vnesite priimek"
                    :value="$existingDataa[0]->surname ?? ''" />

                <x-input type="email" name="email" displayedName="E-pošta" placeholder="Vnesite e-pošto"
                    :value="$existingDataa[0]->email ?? ''" />

                <x-input type="text" name="username" displayedName="Uporabniško ime" placeholder="Vnesite uporabniško ime"
                    :value="$existingDataa[0]->username ?? ''" />

                <x-input type="password" name="password" displayedName="Geslo" placeholder="Vnesite geslo"
                    :value="$existingDataa[0]->password ?? ''" readonly/>

                <x-input type="text" name="emso" displayedName="EMŠO" placeholder="Vnesite EMŠO"
                    :value="$existingDataa[0]->emso ?? ''" readonly/>

                <label for="role">Vloga</label>
                <select name="role" id="role" class="form-control">
                    @foreach($roles as $role)
                        <option value="{{ $role }}" {{ isset($existingData[0]->role) && $existingData[0]->role == $role ? 'selected' : '' }}>{{ $role }}</option>
                    @endforeach
                </select>

                <label for="email_verified_at">E-pošta preverjena ob</label>
                <input type="datetime" class="form-control" name="email_verified_at" id="email_verified_at"
                    value="{{ $existingData[0]->email_verified_at ?? '' }}" readonly/>


                <label for="card-filter">Poišči kartico</label>
                <input type="text" id="card-filter" class="form-control" placeholder="Poišči kartico po imenu" />
                <label for="cards">Kartice</label>
                <div class="form-group" style="max-height: 100px; overflow-y: auto;">
                    @foreach($cardInfo as $card)
                        <div class="form-check card-item" data-card-name="{{ $card->name }}">
                            @if($userCards->isEmpty() || $userCards == null || $userCards == '' || $userCards == '[]' || $userCards == 'null' || $userCards == [])
                                <input class="form-check-input" type="checkbox" name="cards[]" id="card-{{ $card->id }}" value="{{ $card->id }}">
                                <label class="form-check-label" for="card-{{ $card->id }}">
                                    {{ $card->name }}
                                </label>
                            
                            @else
                            <input class="form-check-input" type="checkbox" name="cards[]" id="card-{{ $card->id }}" value="{{ $card->id }}" {{ in_array($card->id, ($userCards->pluck('id_card')->toArray()) ?? []) ? 'checked' : '' }}>
                            <label class="form-check-label" for="card-{{ $card->id }}">
                                {{ $card->name }}
                            </label>
                            @endif
   
                        </div>
                    @endforeach
                </div>

                <script>
                    const cardItems = document.querySelectorAll('.card-item');
                    const cardFilter = document.getElementById('card-filter');

                    cardFilter.addEventListener('input', function() {
                        const filterValue = cardFilter.value.toLowerCase();

                        cardItems.forEach(function(cardItem) {
                            const cardName = cardItem.dataset.cardName.toLowerCase();
                            cardItem.style.display = cardName.includes(filterValue) ? 'block' : 'none';
                        });
                    });
                </script>
            </x-form>
        </div>
    </div>
@endsection

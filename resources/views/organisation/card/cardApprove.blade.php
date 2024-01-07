@extends('layout')

@section('content')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
    <div class="card">
        <div class="card-header">{{ __('Ustvari kartico') }}</div>
        <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <th>Ime kartice</th>
                    <th>Podatki uporabnika</th>
                    <th colspan="2">Upravljanje s kartico</th>
                </tr>

                @if (count($data) > 0)

                    @if (!$data->isEmpty())
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $row?->card_name }}</td>
                                <td>
                                    <a href="#" data-bs-toggle="popover" data-bs-html="true" style="color: black" data-bs-trigger="hover focus"
                                       title="User Information"
                                       data-bs-content="
                                           <div class='text-start'>
                                               Name: {{ $row?->name }}<br>
                                               Surname: {{ $row?->surname }}<br>
                                               Email: {{ $row?->email }}<br>
                                               Username: {{ $row?->username }}<br>
                                               EMŠO: {{ $row?->emso }}<br>
                                           </div>">
                                        {{ $row?->name }} {{ $row?->surname }}
                                    </a>
                                </td>
                                
                                <td><form
                                    action="{{ route('organisation.card.approve.card', ['requestId' => $row?->id_request_card]) }}"
                                    method="POST">
                                    @csrf
                                    <div class="d-flex gap-2">
                                        
                                        <button type="submit" class="btn btn-primary"
                                            onclick="return confirm('Ali želite odobriti kartico uporabniku?');">
                                            Odobri
                                        </button>
                                    </div>
                                </form></td>
                                <td>
                                    <form
                                        action="{{ route('organisation.card.decline.card', ['requestId' => $row?->id_request_card]) }}"
                                        method="POST">
                                        @csrf
                                        <div class="d-flex gap-2">
                                            
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Ali želite zavrniti kartico uporabniku?');">
                                                Zavrni
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @else
                    <tr>
                        <td colspan="4" class="text-center">Ni podatkov o zahtevah za kartico</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
    <script>
        $(function () {
            $('[data-bs-toggle="popover"]').popover({
                container: 'body',
                html: true, // if you want to show HTML content
                placement: 'top',
                trigger: 'hover'
            })
        });
        </script>
@endsection

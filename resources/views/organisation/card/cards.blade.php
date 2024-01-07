@extends('layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Podatki o karticah</h1>
        </div>
        <a href="{{ route('organisation.card.add')}}"
                class="btn btn-primary">Dodaj kartico</a>
        <div class="col-md-12 table-responsive card-body">
            <table class="table table-striped">
                <tr>
                    <th>Ime kartice</th>
                    <th colspan="2">Upravljanje s kartico</th>
                </tr>

                @if (!$data->isEmpty())

                    @if (count($data) > 0)
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $row?->name }}</td>
                                <td><a href="{{ route('organisation.card', ['cardId' => $row?->id]) }}"
                                    class="btn btn-primary">Uredi</a></td>
                                <td>
                                    <form
                                        action="{{ route('organisation.card.delete', ['cardId' => $row?->id]) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <div class="d-flex gap-2">
                                            
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Ali ste prepričani, da želite izbrisati to kartico?');">
                                                Izbriši
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @else
                    <tr>
                        <td colspan="4" class="text-center">Ni podatkov o karticah</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection

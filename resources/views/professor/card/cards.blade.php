@extends('layout')

@section('content')
    <div class="cards-about">
        <div class="cards-content">
            <div class="cards-header">
                <div>
                    <h1>Seznam kartic organizacije</h1>
                </div>
            </div>
            <div class="cards-table">
                <table class="table">
                    <tr>
                        <th>Ime kartice</th>
                        <th>Opis kartice</th>
                        <th>Možnosti</th>
                    </tr>

                    @if (!$data->isEmpty())

                        @if (count($data) > 0)
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $row?->name }}</td>
                                    <td>{{$row->description != null ? $row->description : 'Kartica nima opisa.'}}</td>
                                    <td class="options">
                                        <a href="{{ route('professor.card', ['cardId' => $row?->id]) }}"
                                           class="btn-edit"><i class="fa-solid fa-pen"></i>Uredi</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @else
                        <tr>
                            <td colspan="4" class=".text-center">Ni podatkov o karticah</td>
                        </tr>
                    @endif
                </table>
            </div>
            <div>
                {{$data->links('custom_vendor.pagination.default')}}
            </div>
        </div>

    </div>
    <script>
        function confirmDelete(event, form) {
            event.preventDefault();
            Swal.fire({
                title: "Izbris kartice?",
                text: "Ste prepričani, da želite izbrisati to kartico? Dejanja ni mogoče razveljaviti.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Izbriši kartico",
                cancelButtonText: "Prekliči izbris",
            }).then(result => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
@endsection
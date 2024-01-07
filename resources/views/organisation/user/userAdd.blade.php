@extends('layout')

@section('content')
    <script>
        function searchFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementsByTagName("table")[0];
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                // Column numbers: 1 for username, 0 for email, 2 for EMŠO
                if (tr[i].getElementsByTagName("td").length > 0) {
                    // Searching over username, email, and EMŠO
                    if (searchColumn(tr[i], 1, filter) || searchColumn(tr[i], 0, filter) || searchColumn(tr[i], 2,
                        filter)) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        function searchColumn(row, column, filter) {
            var td = row.getElementsByTagName("td")[column];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    return true;
                }
            }
            return false;
        }
    </script>

    <div class="card">
        <div class="card-header">
            <h1>Podatki o uporabnikih</h1>
        </div>
        <div class="col-md-12 table-responsive card-body">
            <div class="mb-3">
                <input type="text" class="form-control" id="searchInput" onkeyup="searchFunction()"
                    placeholder="Poišči uporabnika po emšu ali po mailu ali po uporabniškem imenu">
            </div>
            <table class="table table-striped" id="userTable">
                <tr>
                    <th>Podatki uporabnika</th>
                    <th>Uporabniško ime</th>
                    <th>EMŠO</th>
                    <th colspan="2">Upravljanje z uporabnikom</th>
                </tr>

                @if (!$data->isEmpty())

                    @if (count($data) > 0)
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $row?->email }}</td>
                                <td>{{ $row?->username }}</td>
                                <td>{{ $row?->emso }}</td>
                                <td>
                                    <form action="{{ route('organisation.user.add.create', ['userId' => $row?->id]) }}"
                                        method="POST">
                                        @csrf
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary"
                                                onclick="return confirm('Ali ste prepričani, da želite dodati tega uporabnika?');">
                                                Dodaj
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @else
                    <tr>
                        <td colspan="9" class="text-center">Ni podatkov o uporabnikih organizacije</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection

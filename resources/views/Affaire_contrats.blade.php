@extends(backpack_view('blank'))

@section('content')
    <button class="btn btn-success" id="export">Export</button><br><br>
    <table class="table" id="exportMe">
        <tr>
            <th scope="col">Identifiant</th>
            <th scope="col">Date signature</th>
            <th scope="col">Objet</th>
            <th scope="col">Montant</th>
            <th scope="col">Date debut</th>
            <th scope="col">Date fin</th>
            <th scope="col">Statut</th>
            <th scope="col">Echanges</th>
        </tr>
        @foreach ($contrats as $c)
            <tr>
                <td>{{ $c->identifiant }}</td>
                <td>{{ date('Y/m/d', $c->date_signature->timestamp) }}</td>
                <td>{{ $c->objet }}</td>
                <td>{{ $c->montant }}</td>
                <td>{{ date('Y/m/d', $c->date_debut->timestamp) }}</td>
                <td>{{ date('Y/m/d', $c->date_fin->timestamp) }}</td>
                <td>{{ $c->statut == 0 ? 'En cours' : 'Cloturé' }}</td>
                <td><a href="{{ route('contrat_echanges', $c->id) }}">Afficher</a></td>
            </tr>
        @endforeach
    </table>
    <a class="btn btn-primary btn-lg" href="/app/affaire/{{ $c->affaire->id }}/show">Retour</a>

    <script type="text/javascript">
        const toCsv = function(table) {
            // Query all rows
            const rows = table.querySelectorAll('tr');

            return [].slice
                .call(rows)
                .map(function(row) {
                    // Query all cells
                    const cells = row.querySelectorAll('th,td');
                    return [].slice
                        .call(cells)
                        .map(function(cell) {
                            return cell.textContent;
                        })
                        .join(',');
                })
                .join('\n');
        };
        const download = function(text, fileName) {
            const link = document.createElement('a');
            link.setAttribute('href', `data:text/csv;charset=utf-8,${encodeURIComponent(text)}`);
            link.setAttribute('download', fileName);

            link.style.display = 'none';
            document.body.appendChild(link);

            link.click();

            document.body.removeChild(link);
        };
        const table = document.getElementById('exportMe');
        const exportBtn = document.getElementById('export');

        exportBtn.addEventListener('click', function() {
            // Export to csv
            const csv = toCsv(table);

            // Download it
            download(csv, 'contrats.csv');
        });
    </script>
@endsection

@extends(backpack_view('blank'))
@section('content')
<table class="table">
    <thead>
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
    </thead>
    <tbody>
        @foreach ($contrats as $c)
            <tr>
                <th scope="row">{{ $c->identifiant }}</th>
                <td>{{ $c->date_signature }}</td>
                <td>{{ $c->objet }}</td>
                <td>{{ $c->montant }}</td>
                <td>{{ $c->date_debut }}</td>
                <td>{{ $c->date_fin }}</td>
                <td>
                    @if ($c->statut == 0)
                        En cours
                    @else
                        Cloturé
                    @endif
                </td>
                <td><a href="{{ route('contrat_echanges', $c->id) }}">Afficher</a></td>
            </tr>
        @endforeach
    </tbody>
  </table>
@endsection

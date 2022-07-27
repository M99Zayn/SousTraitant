@extends(backpack_view('blank'))
@section('content')
<table class="table">
    <thead>
      <tr>
        <th scope="col">Expediteur</th>
        <th scope="col">Destinataire</th>
        <th scope="col">Date expedition</th>
        <th scope="col">Date cloture</th>
        <th scope="col">Commentaire</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($echanges as $e)
            <tr>
                <th>{{ $e->expediteur }}</th>
                <td>{{ $e->destinataire }}</td>
                <td>{{ $e->date_exp }}</td>
                <td>{{ $e->date_cloture }}</td>
                <td>{{ $e->commentaire }}</td>
                <td>
                    <a href="/admin/echange/{{ $e->id }}/show">Afficher</a>
                </td>
            </tr>
        @endforeach
    </tbody>
  </table>
@endsection
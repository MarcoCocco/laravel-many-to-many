@extends('layouts/admin')

@section('content')
    <h2 class="text-center m-4">Tipi di Progetto</h2>
    <table class="mt-5 table table-striped">
        <thead>
            <th>Nome</th>
            <th>Descrizione</th>
            <th>N° progetti</th>
        </thead>
        <tbody>
            @foreach ($types as $type)
                <tr>
                    <td>{{ $type->name }}</td>
                    <td>{{ $type->description }}</td>
                    <td>{{ count($type->projects) }}</td>
                    <td><a href="{{ route('admin.types.show', $type) }}"><i class="fa-solid fa-magnifying-glass"></i></a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-around m-4">
        <a href="{{ route('admin.types.create') }}" class="btn btn-primary">
            Aggiungi un tipo di progetto
        </a>
    </div>
@endsection

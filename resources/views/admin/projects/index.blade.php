@extends('layouts/admin')

@section('content')
    <table class="mt-5 table table-striped">
        <thead>
            <th>Titolo</th>
            <th>Descrizione</th>
            <th>Tipo di progetto</th>
            <th>Linguaggio di Programmazione</th>
        </thead>

        <tbody>

            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->description }}</td>
                    <td>{{ $project->type->name ?? 'Non specificato' }}</td>
                    <td>{{ $project->language }}</td>
                    <td><a href="{{ route('admin.projects.show', $project) }}"><i
                                class="fa-solid fa-magnifying-glass"></i></a></td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <div class="d-flex justify-content-around m-4">
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
            Aggiungi un progetto
        </a>
    </div>
@endsection

@extends('layouts/admin')

@section('content')
    <h2 class="text-center m-4">Tutti i progetti di tipo {{ $type->name }}</h2>
    <div class="back-to-list text-center mb-4">
        <a href="{{ route('admin.types.index') }}"><i class="fa-solid fa-left-long"></i> Torna alla lista</a>
    </div>
    @if (count($type->projects) > 0)
        <table class="mt-5 table table-striped">
            <thead>
                <th>Nome</th>
                <th>Descrizione</th>
                <th>Dettagli del progetto</th>

            </thead>
            <tbody>
                @foreach ($type->projects as $project)
                    <tr>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->description }}</td>
                        <td><a href="{{ route('admin.projects.show', $project) }}">Vai al progetto</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center p-4">Il tipo {{ $type->name }} non ha nessun progetto associato.</p>
    @endif

    <div class="d-flex justify-content-around">
        <a href="{{ route('admin.types.edit', $type) }}" class="btn btn-primary">Modifica</a>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Elimina
        </button>
    </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Elimina il tipo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Sei sicuro di voler eliminare il tipo?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <form action="{{ route('admin.types.destroy', $type) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Elimina</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

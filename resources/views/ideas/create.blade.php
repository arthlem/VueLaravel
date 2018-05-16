@extends('layouts.app', ['title' => 'Ajouter une idée'])

@section('content')
    <h1>Ajouter une idée</h1>
    {!! Form::open(['action' => 'IdeaController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('text', 'Texte de l\'idée')}}
            {{Form::text('text', '', ['class' => 'form-control', 'placeholder' => 'Texte de l\'idée'])}}
        </div>
        {{ Form::hidden('id_project', $project_id) }}
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Ajouter l'idée</button>
            <a class="btn btn-secondary" href="/projects/{{$project_id}}">Annuler</a>
        </div>
    {!! Form::close() !!}
@endsection
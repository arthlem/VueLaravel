@extends('layouts.app', ['title' => 'Ajouter un projet'])

@section('content')
    <h1>Créer un projet</h1>
    {!! Form::open(['action' => 'ProjectController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('name', 'Nom du project')}}
            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Nom du projet'])}}
        </div>
        <div class="form-group">
            {{Form::file('image')}}
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Ajouter</button>
            <a class="btn btn-secondary" href="/projects">Annuler</a>
        </div>
    {!! Form::close() !!}
@endsection
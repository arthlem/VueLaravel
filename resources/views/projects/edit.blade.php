@extends('layouts.app', ['title' => 'Modifier'])

@section('content')
    <h1>Modifier un projet</h1>
    {!! Form::open(['action' => ['ProjectController@update', $project->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('name', 'Nom du project')}}
            {{Form::text('name', $project->name, ['class' => 'form-control', 'placeholder' => 'Nom du project'])}}
        </div>
        <div class="form-group">
            {{Form::file('image')}}
        </div>
        {{Form::hidden('_method','PUT')}}

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Modifier</button>
            <a class="btn btn-secondary" href="/projects">Annuler</a>
        </div>
    {!! Form::close() !!}
@endsection
<?php

namespace App\Http\Controllers;

use App\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IdeaControllerJson extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Idea::all());
    }

    /**
     * La liste des idées d'un projet.
     *
     * @return les idées en format json
     */
    public function projectIdeas($projectId)
    {
        return DB::table('ideas as i')
            ->leftJoin('votes as v', 'v.id_idea', '=', 'i.id')
            ->selectRaw('i.id, i.text, i.id_creator, SUM(v.value) as count')
            ->where('i.id_project', '=', $projectId)
            ->groupBy('id', 'text', 'id_creator')
            ->get();
    }

    public function addIdeas(Request $request, $projectId){
        $idea = Idea::create($request->all());
        return response()->json('Successfully added');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $projectId)
    {
        $idea = new Idea([
            'text' => $request->get('text'),
            'id_creator' => $request->get('id_creator'),
            'id_project' => $request->get('id_project'),
        ]);
        $idea->save();
        return response()->json($idea);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $idea = Idea::find($id);

        $idea->text = $request->get('text');

        $idea->save();

        return "Success updating idea #" . $idea->id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Idea::destroy($id);
    }
}

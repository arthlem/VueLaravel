<?php

namespace App\Http\Controllers;

use App\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IdeaController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('ideas.create')->with('project_id', $id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $idea = new Idea([
            'text' => $request->get('text'),
            'id_creator' => auth()->user()->id,
            'id_project' => $request->get('id_project'),
        ]);
        $idea->save();
        return redirect('/projects/' . $request->get('id_project'))->with('success', 'l\'idée a bien été créée');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $idea = Idea::find($id);
        // Check for correct user
        if(auth()->user()->id !==$idea->id_creator){
            return redirect('/projects')->with('error', 'Pas autorisé');
        }
        return view('ideas.edit')->with('idea', $idea);
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

        $this->validate($request, [
            'text' => 'required'
        ]);

        $idea = Idea::find($id);

        $idea->text = $request->get('text');

        $idea->save();

        return redirect('/projects/'.$idea->id_project)->with('success', 'idée mise à jour');
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
        $idea = Idea::find($id);
        $id_project = $idea->id_project;
        // Check for correct user
        if(auth()->user()->id !==$idea->id_creator){
            return redirect('/projects')->with('error', 'Pas autorisé');
        }
        
        $idea->delete();
        return redirect('/projects/'.$id_project)->with('success', 'idée supprimée');
    }
}

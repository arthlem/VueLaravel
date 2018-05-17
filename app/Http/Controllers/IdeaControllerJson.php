<?php

namespace App\Http\Controllers;

use App\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IdeaControllerJson extends Controller
{

    /**
     * @SWG\Post(
     *   path="/ideas",
     *   tags={"ideas"},
     *   summary="Ajouter une idée",
     *   @SWG\Parameter(name="text",required=true,in="body",description="Le texte de l'idée",type="string",@SWG\Schema(@SWG\Property(property="text",type="string",default="Test"))),
     *   @SWG\Parameter(name="id_project",required=true,in="body",description="L'id du projet",type="integer",@SWG\Schema(@SWG\Property(property="id_project",type="integer",default="Test"))),
     *   @SWG\Parameter(name="id_creator",required=true,in="body",description="L'id de l'utilisateur qui ajoute le projet",type="integer",@SWG\Schema(@SWG\Property(property="id_creator",type="integer",default="Test"))),
     *   @SWG\Response(response=200, description="Retourne le projet avec un id")
     * )
     *
     * Créer un projet
     *
     * @param  \Illuminate\Http\Request requête contenant toutes les informations pour créer un projet
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idea = new Idea([
            'text' => $request->text,
            'id_creator' => $request->id_creator,
            'id_project' => $request->id_project,
        ]);
        $idea->save();
        return response()->json($idea);
    }

    /**
     * @SWG\Put(
     *   path="/ideas/{id}",
     *   tags={"ideas"},
     *   summary="Modifier une idée",
     *   @SWG\Parameter(name="id",required=true,in="path",description="L'id de l'idée",type="integer",@SWG\Schema(@SWG\Property(property="id",type="integer",default="Test"))),
     *   @SWG\Parameter(name="text",required=true,in="body",description="Le texte de l'idée",type="string",@SWG\Schema(@SWG\Property(property="text",type="string",default="Test"))),
     *   @SWG\Response(response=200, description="Success")
     * )
     *
     * Modifier une idée via son id
     *
     * @param $id l'id du projet
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
     * @SWG\Delete(path="/ideas/{id}",
     *   tags={"ideas"},
     *   summary="Supprimer une idée via son id",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="L'id de l'idée à supprimer",
     *     required=true,
     *     type="integer",
     *     minimum=1.0
     *   ),
     *   @SWG\Response(response=200, description="Idée supprimé avec succès"),
     *   @SWG\Response(response=404, description="Idée introuvable")
     * )
     */
    public function destroy($id)
    {
        $idea = Idea::find($id);
        if ($idea == null) {
            return response()->json('L\'idée n\'existe pas', 404);
        } else {
            $idea->delete();
            return response()->json('Idée supprimée', 200);
        }
    }
}

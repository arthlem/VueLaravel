<?php

namespace App\Http\Controllers;

use App\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     *   @SWG\Response(response=200, description="Retourne le projet avec un id"),
     *   @SWG\Response(response=403, description="Vous n'êtes pas autorisé à faire ça"),
     *   @SWG\Response(response=422, description="Il manque des paramètres")
     * )
     *
     * Créer un projet
     *
     * @param  \Illuminate\Http\Request requête contenant toutes les informations pour créer un projet
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {

            $validatedData = $request->validate([
                'text' => 'required',
                'id_creator' => 'required',
                'id_project' => 'required',
            ]);

            $idea = new Idea([
                'text' => $request->text,
                'id_creator' => $request->id_creator,
                'id_project' => $request->id_project,
            ]);
            $idea->save();
            return response()->json($idea, 200);
        } else {
            return response()->json('Vous n\'êtes pas authorisé à faire ça', 403);
        }
    }

    /**
     * @SWG\Put(
     *   path="/ideas/{id}",
     *   tags={"ideas"},
     *   summary="Modifier une idée",
     *   @SWG\Parameter(name="id",required=true,in="path",description="L'id de l'idée",type="integer",@SWG\Schema(@SWG\Property(property="id",type="integer",default="Test"))),
     *   @SWG\Parameter(name="text",required=true,in="body",description="Le texte de l'idée",type="string",@SWG\Schema(@SWG\Property(property="text",type="string",default="Test"))),
     *   @SWG\Response(response=200, description="Success"),
     *   @SWG\Response(response=403, description="Vous n'êtes pas autorisé à faire ça"),
     *   @SWG\Response(response=404, description="L'idée n'existe pas")
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
        if (Auth::check() && $idea->id_creator === Auth::user()->id) {
            if (!$idea) {
                return response()->json('L\'idée n\'existe pas', 404);
            } else {
                $validatedData = $request->validate([
                    'text' => 'required',
                    'id_creator' => 'required',
                    'id_project' => 'required',
                ]);

                $idea->text = $request->get('text');

                $idea->save();

                return response()->json($idea, 200);
            }

        } else {
            return response()->json('Vous n\'êtes pas authorisé à faire ça', 403);
        }

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
     *   @SWG\Response(response=404, description="Idée introuvable"),
     *   @SWG\Response(response=403, description="Vous n'êtes pas autorisé à faire ça")
     * )
     */
    public function destroy($id)
    {
        $idea = Idea::find($id);
        if ($idea == null) {
            return response()->json('L\'idée n\'existe pas', 404);
        } else if (Auth::check() && $idea->id_creator === Auth::user()->id) {
            $idea->delete();
            return response()->json('Idée supprimée', 200);

        } else {
            return response()->json('Vous n\'êtes pas authorisé à faire ça', 403);
        }
    }
}

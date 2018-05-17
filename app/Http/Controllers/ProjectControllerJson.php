<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectControllerJson extends Controller
{
    /**
     * @SWG\Get(
     *   path="/projects",
     *   tags={"projects"},
     *   summary="Récupérer tous les projets",
     *   @SWG\Response(response=200, description="Tous les projets")
     * )
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Project::all());
    }

    /**
     * @SWG\Post(
     *   path="/projects",
     *   tags={"projects"},
     *   summary="Ajouter un projet",
     *   @SWG\Parameter(name="name",required=true,in="body",description="Le nom du projet",type="string",@SWG\Schema(@SWG\Property(property="name",type="string",default="Test"))),
     *   @SWG\Parameter(name="image_link",required=true,in="body",description="Le lien de l'image du projet",type="string",@SWG\Schema(@SWG\Property(property="image_link",type="string",default="Test"))),
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
        $project = new Project([
            'name' => $request->get('name'),
            'image_link' => $request->get('image_link'),
            'id_creator' => $request->get('id_creator'),
        ]);
        $project->save();
        return response()->json($project);
    }

    /**
     * @SWG\Get(
     *   path="/projects/{id}",
     *   tags={"projects"},
     *   summary="Récupérer un projet via son id",
     *   @SWG\Parameter(name="id",required=true,in="path",description="L'id du projet",type="integer",@SWG\Schema(@SWG\Property(property="id",type="integer",default="1"))),
     *   @SWG\Response(response=200, description="Retourne le projet correspondant à l'id en paramètre")
     * )
     *
     * Récupérer un projet via son id
     *
     * @param $id l'id du projet
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);
        $ideas = $project->ideas;

        foreach ($ideas as $idea) {
            $idea->count = $idea->votes()->count();
        }

        return response()->json([
            'project' => $project,
            'ideas' => $ideas,
        ]);
    }

    /**
     * @SWG\Put(
     *   path="/projects/{id}",
     *   tags={"projects"},
     *   summary="Modifier un projet",
     *   @SWG\Parameter(name="id",required=true,in="path",description="L'id du projet",type="integer",@SWG\Schema(@SWG\Property(property="id",type="integer",default="1"))),
     *   @SWG\Parameter(name="name",required=false,in="body",description="Le nom du projet",type="string",@SWG\Schema(@SWG\Property(property="name",type="string",default="Test"))),
     *   @SWG\Parameter(name="image_link",required=false,in="body",description="Le lien de l'image du projet",type="string",@SWG\Schema(@SWG\Property(property="image_link",type="string",default="Test"))),
     *   @SWG\Response(response=200, description="Success")
     * )
     *
     * Modifier un projet via son id
     *
     * @param $id l'id du projet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        if ($request->user()->id === $project->id_creator) {
            if ($request->image_link) {
                $project->name = $request->name;
            }
            if ($request->image_link) {
                $project->image_link = $request->image_link;
            }
            $project->save();

            return "Success updating project #" . $project->id;
        }else{
            return response()->json("Ce projet ne vous appartient pas.".Auth::user(), 400);
        }  
    }

    /**
     * @SWG\Delete(path="/projects/{id}",
     *   tags={"projects"},
     *   summary="Supprimer un projet via son id",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="L'id du projet à supprimer",
     *     required=true,
     *     type="integer",
     *     minimum=1.0
     *   ),
     *   @SWG\Response(response=200, description="Projet supprimé avec succès"),
     *   @SWG\Response(response=404, description="Projet introuvable")
     * )
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        if ($project == null) {
            return response()->json('Le projet n\'existe pas', 404);
        } else {
            //Si pas une url alors delete du storage
            if (substr($project->image_link, 0, 4) !== "http") {
                Storage::delete('public/images/' . $project->image_link);
            }

            $project->delete();
            return response()->json('Projet supprimé', 200);
        }
    }
}

<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Boite à idée",
 *     version="1.0.0"
 *   )
 * )
 */
class PageController extends Controller
{
    public function index(){
        return redirect('/projects');
    }
}
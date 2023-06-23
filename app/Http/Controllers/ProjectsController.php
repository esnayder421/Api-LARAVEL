<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projects;
use App\Models\User;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Collection;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class ProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $projects = Projects::simplePaginate();

        return response()->json([
            "mensaje" => 'lista',
            $projects
        ], 200);
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
    public function store(Request $request)
    {
        try {
            $profile = new AuthController();
            $validation = $profile->meIdRol();
            // return $validation;
            if($validation == 1){
                $project = new Projects();
                $project->projectTitle = $request->title;
                $project->projectDesc = $request->desc;
                $project->initialDate = $request->initialDate;
                $project->finalDate = $request->finalDate;
                $project->save();
    
                return response()->json([
                "mensaje" => 'Se guardo correctamente',
                $project
            ], 200);
            }else{
                return response()->json([
                    "mensaje" => 'No tienes permisos'
                ], 403);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "Error" => 'Inernal Error Server',
            ], 401);
        }
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
        //
        try {
            $profile = new AuthController();
            $validation = $profile->meIdRol();
            if($validation == 1){
                $project = Projects::find($id);
                $project->projectTitle = $request->title;
                $project->projectDesc = $request->desc;
                $project->initialDate = $request->initialDate;
                $project->finalDate = $request->finalDate;
                $project->save();
                
                return response()->json([
                    "mensaje" => 'Se actualizo correctamente',
                    $project
                ], 201); 
            }else{
                return response()->json([
                    "mensaje" => 'no tiene permisos'
                ], 403); 
            }
            

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "Error" => 'Method Update: Inernal Error Server',
            ], 401);
        }
        
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
        try {
            $profile = new AuthController();
            $validation = $profile->meIdRol();
            if($validation == 1){
            $project = Projects::find($id);
            $project->delete();

            return response()->json([
                "mensaje" => 'Se elimino correctamente'
            ], 201); 
        }else{
            return response()->json([
                "mensaje" => 'Susted no tiene permisos'
            ], 403); 
        }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "Error" => 'Method Delete: Inernal Error Server',
            ], 401);

        }

    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AuthController;
use App\Models\Tasks;
use Illuminate\Http\Request;

class TasksController extends Controller
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
        //
        $tasks = Tasks::simplePaginate();

        return response()->json([
            "mensaje" => 'lista',
            $tasks
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
        //
        try {
            $profile = new AuthController();
            $validation = $profile->meIdRol();
            // return $validation;
            if($validation == 1){
                $task = new Tasks();
                $task->title = $request->title;
                $task->description = $request->desc;
                $task->state = "pendiente";
                $task->id_project = $request->id_project;
                $task->save();
                return response()->json([
                "mensaje" => 'Se guardo correctamente',
                $task
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
        try {
                $task =Tasks::find($id);
                $task->title = $request->title;
                $task->description = $request->desc;
                $task->state = $request->state;
                $task->id_project = $request->id_project;
                $task->id_user = $request->id_user;
                $task->save();
                return response()->json([
                "mensaje" => 'Se actualizo correctamente',
                $task
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                "Error" => 'Inernal Error Server',
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
        try {
            $profile = new AuthController();
            $validation = $profile->meIdRol();
            if($validation == 1){
            $task = Tasks::find($id);
            $task->delete();

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

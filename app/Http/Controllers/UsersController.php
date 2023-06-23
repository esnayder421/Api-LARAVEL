<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store', '', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::simplePaginate();

        return response()->json([
            "mensaje" => 'lista',
            $users
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            if($request->id_rol){
                $user->id_rol = $request->id_rol;
            }else{
                $user->id_rol = 2;
            }
            
            $user->save();
        return response()->json([
            "mensaje" => 'Se guardo correctamente',
            $user
        ], 200);
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
            $profile = new AuthController();
            $validation = $profile->meIdRol();
            // return $validation;
            if($validation == 1){
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->id_rol = $request->id_rol;
            $user->save();

        return response()->json([
            "mensaje" => 'Se actualizo correctamente',
            $user
        ], 200);
        }else{
            return response()->json([
                "mensaje" => 'Usted no tiene permisos'
            ], 403);
        }
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
        //
    }
}

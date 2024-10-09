<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Resources\UsuarioResource;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Usuario::all();
        return UsuarioResource::collection($usuarios);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUsuarioRequest $request)
    {
        try {

            $usuario = Usuario::create($request->validated());
            return response()->json([
                'message' => 'Usuário registrado com sucesso!',
                'data' => new UsuarioResource($usuario),
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Erro ao registrar o usuário',
                'message' => $e->getMessage(),
            ], 500);
            
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuario $usuario)
    {
        $usuario->update($request->validate());
        return new UsuarioResource($usuario);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return response(null, 204);
    }
}

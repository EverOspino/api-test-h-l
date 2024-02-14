<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();
            return response()->json([
                'ok' => true,
                'data' => UserResource::collection($users),
                'message' => 'Datos enviados correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'data' => [],
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    public function show(User $user)
    {
        try {
            $user = new UserResource($user);
            return response()->json([
                'data' => $user
        ]);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'data' => [],
                'message' => 'Error al mostrar los usuarios'
            ], 500);
        }
        
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'cedula' => 'required|numeric|unique:users',
                'nombre_completo' => 'required|string|max:100',
            ], );
            $user = User::create($validatedData);
            $data = new UserResource($user);
            return response()->json([
                'ok' => true,
                'data' => $data,
                'message' => 'Usuario creado correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'data' => [],
                'message' => 'Error al crear el usuario'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json([
                'ok' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        try {
            $validatedData = $request->validate([
                'cedula' => 'required|numeric',
                'nombre_completo' => 'required|string|max:100',
            ]);

            $user->cedula = $request->cedula;
            $user->nombre_completo = $request->nombre_completo;
            $data = new UserResource($user);

            $user->save();
            return response()->json([
                'ok' => true,
                'data' => $data,
                'message' => 'Usuario actualizado correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'data' => [],
                'message' => 'Error al actualizar el usuario'
            ], 500);
        }
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json([
                'ok' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        try {
            $user->delete();
            return response()->json([
                'ok' => true,
                'message' => 'Usuario eliminado con exito'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Error al eliminar el usuario'
            ], 500);
        }
    }
}

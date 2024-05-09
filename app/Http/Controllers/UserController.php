<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // GET - Obtener todos los clientes
    public function index()
    {
        //
        $users = User::all();
        return response()->json($users, 200);
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
    // POST - Crear un nuevo cliente
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'phone' => 'required'
        ]);

        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    // GET - Obtener un cliente por su ID
    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
     
     public function update(Request $request){
        $user = User::find($request->id);
    
        if ($user) {
            if ($request->has('first_name')) {
                $user->first_name = $request->first_name;
            }
            if ($request->has('last_name')) {
                $user->last_name = $request->last_name;
            }            
            // Verifica si el campo "email" se proporciona en la solicitud
            if ($request->has('email')) {
                $user->email = $request->email;
            }
            if ($request->has('email_verified_at')) {
                $user->email_verified_at = $request->email_verified_at;
            }
          
            if ($request->has('phone')) {
                $user->phone = $request->phone;
            }
            if ($request->has('password')) {
                $user->password = bcrypt($request->password);
            }
    
            $user->save();
            return response()->json($user, 200);
        } else {
            return response()->json(['mensaje' => 'Usuario no encontrado'], 404);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    // DELETE - Eliminar un cliente
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted succesfully'], 200);
    }
}

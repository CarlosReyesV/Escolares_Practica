<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EscuelaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $students = Http::withoutVerifying()->get('https://webservices.mx/escolares/test/alumnos/listar');
        return $students->json();
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
    public function store(Request $request)
    {
        //
        $url = 'https://webservices.mx/escolares/test/alumnos/agregar';
    
        $data = [
            'clave' => $request->input('clave'),
            'matricula' => $request->input('matricula'),
            'paterno' => $request->input('paterno'),
            'materno' => $request->input('materno'),
            'nombre' => $request->input('nombre'),
        ];

        $response = Http::withoutVerifying()->post($url, $data);

        if ($response->successful()) {
            $responseData = $response->json();
            return response()->json($responseData, $response->status());
        } else {
            $errorResponse = $response->json();
            return response()->json($errorResponse, $response->status());
        }
    }

    /**
     * Display by searchbar.
     */
    public function searchbar($id)
    {
        //
        $response = Http::get('https://webservices.mx/escolares/test/alumnos/obtener/'.$id);

        if ($response->successful()) {
            return $response->json();
        } else {
            return response()->json(['error' => 'No se pudo obtener los datos'], $response->status());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $response = Http::get('https://webservices.mx/escolares/test/alumnos/obtener/'.$id);
        return $response->json();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,)
    {
        //
        $url = 'https://webservices.mx/escolares/test/alumnos/guardar';

        $data = [
            'alumno_id' => $request->input('id'),
            'clave' => $request->input('clave'),
            'matricula' => $request->input('matricula'),
            'paterno' => $request->input('paterno'),
            'materno' => $request->input('materno'),
            'nombre' => $request->input('nombre'),
        ];

        $response = Http::withoutVerifying()->put($url, $data);

        if ($response->successful()) {
            $responseData = $response->json();
            return response()->json($responseData, $response->status());
        } else {
            $errorResponse = $response->json();
            return response()->json($errorResponse, $response->status());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 
        $response = Http::get('https://webservices.mx/escolares/test/alumnos/eliminar/'.$id);
    }
}

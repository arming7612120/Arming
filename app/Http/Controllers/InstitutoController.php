<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Instituto;

class InstitutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $institutos = Instituto::orderBy('id', 'desc')->paginate(7);
        }
        else{
            $institutos = Instituto::where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('id', 'desc')->paginate(7);
        }
        

        return [
            'pagination' => [
                'total'        => $institutos->total(),
                'current_page' => $institutos->currentPage(),
                'per_page'     => $institutos->perPage(),
                'last_page'    => $institutos->lastPage(),
                'from'         => $institutos->firstItem(),
                'to'           => $institutos->lastItem(),
            ],
            'institutos' => $institutos
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $instituto = new Instituto();
        $instituto->nombre = $request->nombre;
        $instituto->sigla = $request->sigla;
        $instituto->condicion = '1';
        $instituto->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $instituto = Instituto::findOrFail($request->id);
        $instituto->nombre = $request->nombre;
        $instituto->sigla = $request->sigla;
        $instituto->condicion = '1';
        $instituto->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $instituto = Instituto::findOrFail($request->id);
        $instituto->condicion = '0';
        $instituto->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $instituto = Instituto::findOrFail($request->id);
        $instituto->condicion = '1';
        $instituto->save();
    }
}

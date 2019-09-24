<?php

namespace App\Http\Controllers;

use App\Tipos;
use Illuminate\Http\Request;

class TiposController extends Controller
{
    
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $tipos = Tipos::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $tipos = Tipos::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $tipos->total(),
                'current_page' => $tipos->currentPage(),
                'per_page'     => $tipos->perPage(),
                'last_page'    => $tipos->lastPage(),
                'from'         => $tipos->firstItem(),
                'to'           => $tipos->lastItem(),
            ],
            'tipos' => $tipos
        ];
    }

    public function selectTipo(Request $request){
         if (!$request->ajax()) return redirect('/');
         $tipos = Tipos::select('id','registrado')->orderBy('registrado', 'asc')->get();
         return ['tipos' => $tipos];
     }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;


class PersonaController extends Controller
{
    public function prueba(){
        return 'funciona';
    }

    public function index(Request $request)
    {
       if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $personas = Persona::join('tipos', 'personas.idtipo', '=', 'tipos.id')
            ->select('personas.id', 'personas.paterno', 'personas.materno', 'personas.nombre', 'personas.ci', 
            'personas.expedido', 'personas.idtipo', 'tipos.registrado')  
            ->orderBy('personas.id', 'desc')->paginate(2);
        }
        else{
            $personas = Persona::join('tipos', 'personas.idtipo', '=', 'tipos.id')
            ->select('personas.id', 'personas.paterno', 'personas.materno', 'personas.nombre', 'personas.ci', 
            'personas.expedido', 'personas.idtipo', 'tipos.registrado')
            ->where('personas.id'. $criterio, 'like', '%' . $buscar . '%')  
            ->orderBy('personas.id', 'desc')->paginate(2);  
        }
        return [
            'pagination' => [
                'total'        => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page'     => $personas->perPage(),
                'last_page'    => $personas->lastPage(),
                'from'         => $personas->firstItem(),
                'to'           => $personas->lastItem(),
            ],
            'personas' => $personas
        ];
    }

   
/*
    public function listarArticulo(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        

        return ['articulos' => $articulos];
    }
 
    public function listarArticuloVenta(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->where('articulos.stock','>','0')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->where('articulos.stock','>','0')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        

        return ['articulos' => $articulos];
    }

    public function listarPdf(){
        $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre',
            'categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock',
            'articulos.descripcion','articulos.condicion')
            ->orderBy('articulos.nombre', 'desc')->get();

        $cont=Articulo::count();

        $pdf = \PDF::loadView('pdf.articulospdf',['articulos'=>$articulos,'cont'=>$cont]);
        return $pdf->download('articulos.pdf');
    }

    public function buscarArticulo(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $articulos = Articulo::where('codigo','=', $filtro)
        ->select('id','nombre')->orderBy('nombre', 'asc')->take(1)->get();

        return ['articulos' => $articulos];
    }

    public function buscarArticuloVenta(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $articulos = Articulo::where('codigo','=', $filtro)
        ->select('id','nombre','stock','precio_venta')
        ->where('stock','>','0')
        ->orderBy('nombre', 'asc')
        ->take(1)->get();

        return ['articulos' => $articulos];
    }
    */
    public function store(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
        $persona = new Persona();
        $persona->paterno = $request->paterno;
        $persona->materno = $request->materno;
        $persona->nombre = $request->nombre;
        $persona->ci = $request->ci;
        $persona->expedido = $request->expedido;
        $persona->idtipo = $request->idtipo;
        $persona->save();
        
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $persona = Persona::find($request->get('id'));

        if($persona){
            $persona->idtipo = $request->idtipo;
            $persona->paterno = $request->paterno;
            $persona->materno = $request->materno;
            $persona->nombre = $request->nombre;
            $persona->ci = $request->ci;
            $persona->expedido = $request->expedido;
            $persona->save();
        }else{
            return 'persona no existe';
        }
        
    }   
}

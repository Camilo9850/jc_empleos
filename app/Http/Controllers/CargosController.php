<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Entidades\Cargos;
use App\Entidades\CategoriasLaborales;
use Illuminate\Http\Request;

class CargosController extends Controller
{
    public function index()
    {
        $titulo = 'Gestión de Cargos';
        return view('sistema.cargos-listar', compact('titulo'));
    }

    public function nuevo()
    {
        $titulo = 'Nuevo Cargo';
        $cargo = new Cargos();
        $categorias = CategoriasLaborales::all();
        return view('sistema.cargo-nuevo', compact('titulo', 'cargo', 'categorias'));
    }

    public function editar($id)
    {
        $titulo = 'Editar Cargo';
        $cargo = Cargos::find($id);
        $categorias = CategoriasLaborales::all();
        
        if (!$cargo) {
            return redirect('/admin/cargos')->with('error', 'Cargo no encontrado');
        }
        
        return view('sistema.cargo-nuevo', compact('titulo', 'cargo', 'categorias'));
    }

    public function guardar(Request $request)
    {
        try {
            $id = $request->input('id');
            
            if ($id && $id != "0") {
                // Actualizar
                $cargo = Cargos::find($id);
                if (!$cargo) {
                    return redirect('/admin/cargos')->with('error', 'Cargo no encontrado');
                }
            } else {
                // Crear nuevo
                $cargo = new Cargos();
            }
            
            $cargo->Cargo = $request->input('txtCargo');
            $cargo->id_categoriaslaborales_FK = $request->input('lstCategoria') != "" ? $request->input('lstCategoria') : null;
            $cargo->estado = $request->input('lstEstado', 'ACTIVO');
            
            $cargo->save();
            
            $mensaje = $id && $id != "0" ? 'Cargo actualizado correctamente' : 'Cargo creado correctamente';
            return redirect('/admin/cargos')->with('success', $mensaje);
            
        } catch (\Exception $e) {
            return redirect('/admin/cargos')->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    public function eliminar(Request $request)
    {
        try {
            $id = $request->input('id');
            $cargo = Cargos::find($id);
            
            if (!$cargo) {
                return response()->json(['error' => 'Cargo no encontrado'], 404);
            }
            
            $cargo->delete();
            
            return response()->json(['success' => 'Cargo eliminado correctamente']);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar: ' . $e->getMessage()], 500);
        }
    }

    public function cargarGrilla(Request $request)
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'Cargo',
            1 => 'Cargo',
            2 => 'estado'
        );
        
        $sql = "SELECT 
                    id_Cargo_PK,
                    Cargo,
                    estado
                FROM tbl_Cargo WHERE 1=1";

        if (!empty($request['search']['value'])) {
            $search = $request['search']['value'];
            $sql .= " AND (Cargo LIKE '%$search%' OR estado LIKE '%$search%')";
        }
        
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . " " . $request['order'][0]['dir'];
        
        $resultado = DB::select($sql);
        $total = count(DB::select("SELECT * FROM tbl_Cargo"));
        
        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => $total,
            "recordsFiltered" => count($resultado),
            "data" => $resultado,
        );
        
        return response()->json($json_data);
    }
}


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

        // Column mapping for ordering
        $columns = array(
            0 => 'c.Cargo',
            1 => 'cl.nombre',
            2 => 'c.estado'
        );

        $sql = "SELECT 
                    c.id_cargo_pk as id,
                    c.Cargo as cargo,
                    COALESCE(cl.nombre, '') as categoria,
                    c.estado as estado
                FROM tbl_cargo c
                LEFT JOIN categorias_laborales cl ON c.id_categoriaslaborales_FK = cl.idcategoria_laboral
                WHERE 1=1";

        if (!empty($request['search']['value'])) {
            $search = addslashes($request['search']['value']);
            $sql .= " AND (c.Cargo LIKE '%$search%' OR cl.nombre LIKE '%$search%' OR c.estado LIKE '%$search%')";
        }

        // Ordering
        if (isset($request['order'][0]['column'])) {
            $orderCol = intval($request['order'][0]['column']);
            $orderDir = $request['order'][0]['dir'] === 'desc' ? 'DESC' : 'ASC';
            $orderBy = isset($columns[$orderCol]) ? $columns[$orderCol] : 'c.Cargo';
            $sql .= " ORDER BY " . $orderBy . " " . $orderDir;
        }

        $resultado = DB::select($sql);

        $totalQuery = DB::select("SELECT COUNT(*) as cnt FROM tbl_cargo");
        $total = isset($totalQuery[0]) ? intval($totalQuery[0]->cnt) : count($resultado);

        // Convert objects to associative arrays with lowercase keys matching JS mapping
        $data = array_map(function($row){
            return [
                'id' => $row->id,
                'cargo' => $row->cargo,
                'categoria' => $row->categoria,
                'estado' => $row->estado
            ];
        }, $resultado);

        $json_data = array(
            "draw" => isset($request['draw']) ? intval($request['draw']) : 0,
            "recordsTotal" => $total,
            "recordsFiltered" => count($data),
            "data" => $data,
        );

        return response()->json($json_data);
    }
}


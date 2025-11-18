<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Entidades\CategoriasLaborales;

class CategoriasLaboralesController extends Controller
{
    public function index()
    {
        $titulo = 'Gestión de Categorías Laborales';
        return view('sistema.categorias-laborales-listar', compact('titulo'));
    }

    public function nuevo()
    {
        $titulo = 'Nueva Categoría Laboral';
        $categoria = new CategoriasLaborales();
        return view('sistema.categoria-laboral-nuevo', compact('titulo', 'categoria'));
    }

    public function editar($id)
    {
        $titulo = 'Editar Categoría Laboral';
        $categoria = CategoriasLaborales::find($id);
        
        if (!$categoria) {
            return redirect('/admin/categorias-laborales')->with('error', 'Categoría no encontrada');
        }
        
        return view('sistema.categoria-laboral-nuevo', compact('titulo', 'categoria'));
    }

    public function guardar(Request $request)
    {
        try {
            $id = $request->input('id');
            
            if ($id && $id != "0") {
                // Actualizar
                $categoria = CategoriasLaborales::find($id);
                if (!$categoria) {
                    return redirect('/admin/categorias-laborales')->with('error', 'Categoría no encontrada');
                }
            } else {
                // Crear nuevo
                $categoria = new CategoriasLaborales();
            }
            
            $categoria->nombre = $request->input('txtNombre');
            $categoria->descripcion = $request->input('txtDescripcion');
            $categoria->estado = $request->input('lstEstado', 'ACTIVO');
            
            $categoria->save();
            
            $mensaje = $id && $id != "0" ? 'Categoría actualizada correctamente' : 'Categoría creada correctamente';
            return redirect('/admin/categorias-laborales')->with('success', $mensaje);
            
        } catch (\Exception $e) {
            return redirect('/admin/categorias-laborales')->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    public function eliminar(Request $request)
    {
        try {
            $id = $request->input('id');
            $categoria = CategoriasLaborales::find($id);
            
            if (!$categoria) {
                return response()->json(['error' => 'Categoría no encontrada'], 404);
            }
            
            $categoria->delete();
            
            return response()->json(['success' => 'Categoría eliminada correctamente']);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar: ' . $e->getMessage()], 500);
        }
    }

    public function cargarGrilla(Request $request)
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'nombre',
            1 => 'nombre',
            2 => 'estado'
        );
        
        $sql = "SELECT 
                    idcategoria_laboral,
                    nombre,
                    descripcion,
                    estado
                FROM categorias_laborales WHERE 1=1";

        if (!empty($request['search']['value'])) {
            $search = $request['search']['value'];
            $sql .= " AND (nombre LIKE '%$search%' OR descripcion LIKE '%$search%')";
        }
        
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . " " . $request['order'][0]['dir'];
        
        $resultado = DB::select($sql);
        $total = count(DB::select("SELECT * FROM categorias_laborales"));
        
        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => $total,
            "recordsFiltered" => count($resultado),
            "data" => $resultado,
        );
        
        return response()->json($json_data);
    }
}


<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriasLaboralesController extends Controller
{
    public function index()
{
    $titulo = 'Gestión de Clientes';
    $clientes = Cliente::all(); // O tu consulta personalizada
    return view('sistema.cliente-listar', compact('titulo', 'clientes'));
}

}

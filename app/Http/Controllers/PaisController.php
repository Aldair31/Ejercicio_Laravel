<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pais;

class PaisController extends Controller
{
    function ListarNombrePaises(){;
        return Pais::all();
    }
}

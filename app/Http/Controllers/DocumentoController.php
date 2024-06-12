<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\documento;

class DocumentoController extends Controller
{
   public function index()
    {
        return documento::all();
    }
}

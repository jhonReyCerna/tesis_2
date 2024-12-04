<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Help;

class HelpController extends Controller
{
    public function getHelp($section)
    {
        $helpContent = Help::where('section', $section)->first();

        if (!$helpContent) {
            return response()->json(['error' => 'No se encontró contenido de ayuda.'], 404);
        }

        return response()->json(['content' => $helpContent->content]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RunController extends Controller
{
    public function run(Request $request)
    {
        $code = $request->input('code', '');
        ob_start();
        try {
            eval($code);
        } catch (\Throwable $e) {
            echo 'Error: ' . $e->getMessage();
        }
        return response()->json(['output' => ob_get_clean()]);
    }
}

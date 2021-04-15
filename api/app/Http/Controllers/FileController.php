<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function anexos_ticket(Request $file){
        $file=Storage::disk('public/anexos_tickets')->get('anexos_tickets/ZbtF5WR6yN6c1zJDn74vv3ybjpIOniAKJUWWGwqi.pdf');
        //dd($file);
        //return response()->download(public_path($file->ruta));
    }
}

<?php

namespace App\Http\Controllers\Modules;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class UtilsModul extends Controller
{
    /**
     * gibt die Spalten einer DB zurück
     * */
    public function getDatabaseColumnNames($table)
    {
        Schema::getColumnListing($table);
    }
}

<?php

namespace App\Services\Global;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class UtilsService
 * @package App\Services
 */
class UtilsService
{

    /** Vorteile:
     * Methoden und Varoablen Global
     * Variablen können einmal declariert und für immer genutzt werden
     * Wenn alle Methoden die gleichen Variable brauchen, kann sie in construct gesetzt werden
     */

    /**
     * prüft, ob das Objekt Request den angegebenen Regeln entspricht
     * @param req request request
     * @param validationRules associative array Array mit Validierungsregeln see https://laravel.com/docs/8.x/validation#manually-creating-validators
     * @param validationErrorMessage string Fehlermeldung wenn Validierung mit Fehler abbricht
     * */
    public function validateRequest(Request $req, $validationRules)
    {
        $validator = Validator::make($req->all(), $validationRules);

        if ($validator->fails()) {
            return false;
        } else {
            return true;
        }
    }
}

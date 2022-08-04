<?php

namespace App\Http\Controllers\Modules;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class UtilsModul extends Controller
{

    /**
     * füllt ein Model mit den Request Daten (inklusive Checkboxen), sofern der Spaltenname der Migration angegeben
     * und gibt dieses zurück.
     *
     * @param object object Objekt Tabelle, dessen Attribute gefüllt werden sollen
     * @param standardTableColumnNames array Array von attribut-Namen (string) aus dem Request, die im Objekt gefüllt werden sollen
     * @param checkboxTableColumnNames array Array von attribut-Namen (string) die checkbox-werte (boolean-werte) repräsentieren, die aus dem Request, die im Objekt gefüllt werden sollen
     * @param req request request
     * */
    public function fillObjectFromRequest($object, $TableColumnNames = null,  $checkboxTableColumnNames = null, Request $req)
    {
        if (isset($TableColumnNames)) {
            foreach ($TableColumnNames as $columnName) {
                if ($req->has($columnName)) {
                    Log::info("columnName; columnValue:", [$columnName, $req->{$columnName}]);
                    $object->{$columnName} = $req->{$columnName};
                }
            }
        }

        if (isset($checkboxTableColumnNames)) {
            foreach ($checkboxTableColumnNames as $checkboxColumnName) {
                $req->has($checkboxColumnName) ? $object->{$checkboxColumnName} = true : $object->{$checkboxColumnName} = false;
            }
        }
        return $object;
    }

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

    /** EXAMPLE
     * gibt die Spalten einer DB zurück
     * */
    public function getDatabaseColumnNames($table)
    {
        Schema::getColumnListing($table);
    }
}

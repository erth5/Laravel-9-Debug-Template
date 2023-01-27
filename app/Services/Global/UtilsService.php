<?php

namespace App\Services\Global;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

/** Vorteile:
 * Methoden und Variablen Global
 * Variablen können einmal declariert und für immer genutzt werden
 * Wenn alle Methoden die gleichen Variable brauchen, kann sie in construct gesetzt werden
 */

/**
 * Class UtilsService
 * @package App\Services
 */
class UtilsService
{
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

    /**
     * füllt ein Model mit den Request Daten (inklusive Checkboxen), sofern der Spaltenname der Migration angegeben
     * und gibt dieses zurück.
     *
     * @param object object Objekt Tabelle, dessen Attribute gefüllt werden sollen
     * @param standardTableColumnNames array Array von attribut-Namen (string) aus dem Request, die im Objekt gefüllt werden sollen
     * @param checkboxTableColumnNames array Array von attribut-Namen (string) die checkbox-werte (boolean-werte) repräsentieren, die aus dem Request, die im Objekt gefüllt werden sollen
     * @param req request request
     * */
    public function fillObjectFromRequest($object, Request $req, $withNullValues)
    {
        dd(get_class($object));
        $databaseName = strtolower(Str::plural(get_class($object)), 2);
        $tableColumnNames = $this->getDbColumnsWithoutBoolean($databaseName);
        $checkboxTableColumnNames = $this->getDbBooleanColumns($databaseName);

        if (isset($TableColumnNames)) {
            foreach ($TableColumnNames as $columnName) {
                if ($req->has($columnName)) {
                    if ($req->get($columnName) != null || $withNullValues) {
                        if ($object->{$columnName} != $req->{$columnName}) {
                            logger("Updated: oldColumnValue; columnName; newColumnValue: ", [$object->{$columnName}, $columnName, $req->{$columnName}]);
                            $object->{$columnName} = $req->{$columnName};
                        }
                    }
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

    /** recursiv
     * @param [array] Array mit Ihalt
     * @param [obeject] $object leeres Eloquent Modell
     * @return object gefülltes Modell
     */
    public function fillObjectFromArray($object, array $array)
    {
        $databaseName = strtolower(Str::plural(get_class($object)), 2);
        $tableColumnNames = $this->getDbColumnsWithoutBoolean($databaseName);

        foreach ($array as $value) {
            if (is_array($value)) {
                $object = $this->fillObjectFromArray($object, $tableColumnNames, $value);
            }
            if (is_string($value)) {
                $object->{$tableColumnNames} = $value;
            }
            // if (is_object())
        }
        return $object;
    }

    private function getDbColumnsWithoutBoolean(string $database)
    {
        $tableColumns = array();
        $contents = Schema::getColumnListing($database);
        foreach ($contents as $content) {
            if (Schema::getColumnType($database, $content) != 'boolean')
                $tableColumns[] = $content;
        }
        return $tableColumns;
    }

    private function getDbBooleanColumns($database)
    {
        $tableColumns = array();
        $booleans = Schema::getColumnListing($database);
        foreach ($booleans as $maybeBool) {
            if (Schema::getColumnType($database, $maybeBool) == 'boolean')
                $tableColumns[] = $maybeBool;
        }
        return $tableColumns;
    }
}

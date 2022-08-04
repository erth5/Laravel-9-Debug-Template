<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

// Aktiviere oder deaktiviere TestSeiten: false=close, true=open

/**
 * @package App\Services
 */
class DebugService
{
    public function debugFunction($debugValue = false)
    {
        return $debugValue;
    }

    /**
     * Prüft alle Datenbankfelder 
     * @param Database string  $databaseName Name der Datenbank
     * @param array $columns erwartete Datenbank-Spalten-Namen
     */
    public function proofAllDatabaseFields(string $databaseName, $columns)
    {
        $currentColumns = Schema::getColumnListing($databaseName);
        foreach ($columns as $column) {
            if (!in_array($column, $currentColumns))
                return false;
        }
        foreach ($currentColumns as $currentColumn) {
            if (!in_array($currentColumn, $columns))
                return false;
        }
        return true;
    }

    /**
     * @param class-string  $model \Illuminate\Database\Eloquent\Model
     * @param array $columns erwartete Datenbank-Spalten-Namen
     */
    public function proofDatabaseFields($modelClass, $columns)
    {
        $fillable = new $modelClass;
        $currentColumns = $fillable->getFillable();
        foreach ($columns as $column) {
            if (!in_array($column, $currentColumns))
                return false;
        }
        foreach ($currentColumns as $currentColumn) {
            if (!in_array($currentColumn, $columns))
                return false;
        }
        return true;
    }
}

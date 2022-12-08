<?php

namespace App\Http\Controllers\Example;

use App\Models\User;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    public function exportCSV()
    {
        return Excel::download(new UsersExport, 'users.csv');
    }

    public function import()
    {
        Excel::import(new UsersImport, 'users.xlsx');

        return redirect('/')->with('success', 'All good!');
    }

    public function test()
    {
        /** works */
        // $users = User::orderBy('name')->with('roles')->get();
        // return view('debug.role', compact('users'));

        /** works Derzeit kein Anmeldesystem */
        // $dbUser = User::where('name', 'Max Mustermann')->first();
        // $helperUser = Auth::user();
        // $authUser = auth()->user();
        // dd($dbUser . $helperUser . $authUser);
        // return $dbUser->proofUserCan('show_permissions');

        /** works performance: 2 queries->bad*/
        // if (User::first() == null)
        //     $users = null;
        // else {
        //     $users = User::all();
        //     return view('debug.person', compact('users'));
        // }
    }
}

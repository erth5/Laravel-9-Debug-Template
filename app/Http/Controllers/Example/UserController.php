<?php

namespace App\Http\Controllers\Example;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function test()
    {
        /** Derzeit kein Anmeldesystem */
        $dbUser = User::where('name', 'Max Mustermann')->first();
        $helperUser = Auth::user();
        $authUser = auth()->user();
        dd($dbUser . $helperUser . $authUser);
        return $dbUser->proofUserCan('show_permissions');
    }
}

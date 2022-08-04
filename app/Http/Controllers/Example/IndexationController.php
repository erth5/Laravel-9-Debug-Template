<?php

namespace App\Http\Controllers\Example;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Example\Image;
use App\Models\Example\Lang;
use App\Models\Example\Person;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Middlewares\RoleOrPermissionMiddleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

$data[] = null;

class IndexationController extends Controller
{

    public function index()
    {
        // TODO all()->sortBy()
        
        foreach (Config('database.telescope') as $dbNames) {
            $data[] = Schema::getColumnListing($dbNames);
        }
        // foreach (Config('database.models') as $dbNames) {
        //     $data[] = $default::all();
        // }

        $data[] = Person::all();
        $data[] = Lang::all();
        $data[] = Image::all();

        $data[] = Role::all();
        $data[] = Permission::all();

        return view('debug.indexation', compact('data'));
    }


    /** 1 stages */
    // $user = User::find($id);
    /** 2 stages */
    // $person = person::with('partner.image!!!')->firstOrFail();
    /** 3 stages */
    // user->person->image->paths

    // 64Bit required
    public function indexiation($stage = 9223372036854775807)
    {
        return view('debug.indexation');
    }
}

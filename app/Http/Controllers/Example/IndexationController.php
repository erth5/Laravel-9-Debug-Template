<?php

namespace App\Http\Controllers\Example;

use App\Models\User;
use App\Models\Example\Lang;
use App\Models\Example\Image;
use App\Models\Example\Person;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

$data[] = null;

class IndexationController extends Controller
{

    public function index()
    {
        foreach (Config('tables.telescope') as $dbNames) {
            $data[] = Schema::getColumnListing($dbNames);
        }

        $data[] = Person::all()->sortBy('created_at');
        $data[] = Lang::all()->sortBy('abbreviation');
        $data[] = Image::all()->sortBy('path');

        $data[] = Role::all();
        $data[] = Permission::all();

        $data[] = $user = User::find(2);
        $data[] = Person::with('user')->firstOrFail();
        $data[] = $user->person->image;
        return view('debug.indexation', compact('data'));
    }


    // 64Bit required
    public function indexiation($stage = 9223372036854775807)
    {
        return view('debug.indexation');
    }
}

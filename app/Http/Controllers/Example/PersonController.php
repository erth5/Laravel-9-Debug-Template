<?php

namespace App\Http\Controllers\Example;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Example\Person;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Modules\UtilsModul;

class PersonController extends Controller
{
    /**
     * Display all users and his people
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUser()
    {
        // performance: 2 queries->bad
        if (User::first() == null)
            $users = null;
        else {
            $users = User::all();
            return view('debug.person', compact('users'));
        }
    }

    /**
     * Display all people and his relations to users
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPerson()
    {
        // performance: 2 queries->bad
        if (Person::count() == 0)
            return view('debug.user');
        else
            $people = Person::all();
        return view('debug.user', compact('people'));
    }

    /** 
     * Speichert eine vorhandene oder neue Person ab
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Person $person, Request $request)
    {
        $person = Person::findOrFail($person);
        // TODO kann ncht gehen
        $person = new UtilsModul;
        $TableColumnNames = Config::get('database.tables.people');
        $checkboxTableColumnNames = [null];
        dd($TableColumnNames);
        $person->fillObjectFromRequest($person, $TableColumnNames, $checkboxTableColumnNames, $request);
        $person->saveOrFail();
        dd($person);
    }

    /**
     * Set users.names by relationship from people.surname and people.last_name
     * person -> user
     */
    public function adjust()
    {
        $people = Person::all();
        foreach ($people as $person) {
            if ($person->user_id != null)
                if ($person->user_id->name != ($person->surname . $person->last_name))
                    Log::warning('name of user was adjusted to person, old data: ', [$person->user_id->name]);
            $person->user_id->name = ($person->surname . $person->last_name);
        }
        $people = Person::all();
        return redirect()->back(compact('people'));;
    }

    public function getValuesDirect()
    {
        // $names =  User::get(array('name'));
        $names =  User::select('name')->get();
        dd($names);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        $person->delete();
        $view = Person::view();
        // dd($view);
        return $view;
    }

    public function role(){
        $users = User::orderBy('name')->with('roles')->get();
        return view('debug.role', compact('users'));
    }

    public function test($id = 11)
    {
        // works
        // $person = Person::findOrFail($id);
        // if ($person->user_id == null)
        //     echo 'ist null';
        // else
        //     echo 'ist nicht null';

        // if ($person->has('user_id'))
        //     echo 'hat';
        // else
        //     echo 'hat nicht';

        // if ($person->user_id->exists())
        //     echo ('existiert');
        // else
        //     echo 'existiert nicht';
        // dd('Erfassung vollständig');

        // works
        // $person = Person::find($id);
        // $relatedImages = $person->countRelatedImages($id);
        // if ($relatedImages == 2)
        //     $relatedImages = $person->getRelatedImages($id);
        // dd($relatedImages);

        /** Use */
        $test = 'variablen text';
        $withText = 'with text';
        /** not works */
        // return View::make('/debug.test', compact('test'))
        // ->with('statusSuccess', 'Anzeige erfolgreich')
        // ->with('example', $withData);
        /** works */
        // return view('/debug.test')->with(compact('test'))->with('example', $withText);
        // return View::make('/debug.test')->with(compact('test'))->with('example', $withText);

        /** works */
        $test = Person::peopleOrganized();
        dd($test);
    }
}

// fügt jeden Attribut alle Values hinzu
// $tmpPartnerData = array_fill_keys($tmpPartnerKeys, $tmpPartnerValues);
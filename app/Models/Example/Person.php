<?php

namespace App\Models\Example;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'surname',
        //Spell-checked:Last Name will be written with blank line
        'last_name',
        'username',
    ];

    /** 
     * get some people by id Range
     */
    public static function peopleRange($firstId, $lastId)
    {
        $people = [];
        for ($firstId; $firstId < $lastId; $firstId++) {
            $people[] = Person::find($firstId);
        }
        return $people;
    }

    /** 
     * get all people by id with pagination, with sort
     */
    public static function peopleOrganized()
    {
        return Person::orderBy('id')->paginate(8);
    }

    public static function peopleAdded()
    {
        return Person::orderBy('created_at', "desc")->paginate(24);
    }



    /** display the people - static view*/
    public static function view()
    {
        $people = Person::all();
        return view('debug.person', compact('people'));
    }

    // TODO use static??
    /** Scope: Select which has only one image TODO - wie macht man das?
     * using: ::hasOneImage
     */
    // public function scopeHasOneImage($query)
    // {
    //     dd($query);
    //     $number = Image::where('person_id', '=', $id)->count();
    //     return $number;
    // }

    /** Count number of Images a person has TODO scope
     * @return number Amount Anzahl Bilder
     */
    public function countRelatedImages($id)
    {
        return Image::where('person_id', '=', $id)->count();
    }

    /** Get all Images related to a person
     * @return Image Images of a person
     */
    public function getRelatedImages($id)
    {
        return Image::where('person_id', '=', $id)->get();
    }

    /**
     * Relationship: get user that owns person
     */
    public function user()
    {
        // Korrekt->person belongsTo user Test
        return $this->belongsTo(User::class);
    }

    /** Relationship: get language(s) spoken by user 
     *Must be axtra table
     */
    public function lang()
    {
        return $this->hasMany(Lang::class);
    }

    // public function test(){
    //     return $this->hasM
    // }

    /**
     * Relationship: get images associated with person
     */
    public function image()
    {
        return $this->hasMany(Image::class);
    }

    /** Example Function to get a value as method */
    public static function username()
    {
        return Person::select('username')->get();
    }
}

<?php

namespace App\Models\Example;

use App\Models\User;
use App\Models\Scopes\SoftDeletesScope;
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

    /** scope to get all relationships */
    public function scopeWithRelationships($query)
    {
        $query->with('image', 'user', 'lang');
    }

    /** Count number of Images a person has TODO scope
     * @return number Amount Anzahl Bilder
     */
    public function countRelatedImages($id)
    {
        return Image::where('person_id', $id)->count();
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
        return $this->belongsTo(User::class);
    }

    /** Relationship: get language(s) spoken by user 
     *  wherePivot only exists on a BelongsToMany
     */
    public function lang()
    {
        return $this->belongsToMany(Lang::class)->withPivot('lang_id');
    }

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

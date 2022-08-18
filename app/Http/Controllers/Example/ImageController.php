<?php

namespace App\Http\Controllers\Example;

use Exception;
use Illuminate\Http\Request;
use App\Models\Example\Image;
use App\Http\Controllers\Controller;
use App\Services\Global\UtilsService;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Image\StoreImageRequest;
use App\Http\Controllers\Modules\ImageValidatorModule;

class ImageController extends Controller
{

    protected $utilsService;
    public function __construct(
        UtilsService $utilsService
    ) {
        $this->utilsService = $utilsService;
    }

    /* variant1 */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::withTrashed()->get();
        // performance: 1 querie->good
        if ($images->isEmpty())
            return view('image.index');
        else
            return view('image.index', compact('images'));
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param image array all saved images
     * @param name string name of image
     * @param path string path of image
     * @param requestData meta data from image
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImageRequest $request)
    {
        /* Validation
         +Recommendet RequestFile 
         app/Rules to add own validator rules
         non static in module
         static in Service (this case service use other Request Facade)
         +or in controller*/

        /* has own return back -> no proof required */
        $validator = new ImageValidatorModule($request);
        $validator->proofImageExist();

        $request->validate([
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        if ($request != true) {
            return redirect()->route('images')->with('statusError', __('image.validateError'));
        }

        /** storeAs: $path, $name, $options = []     */
        if ($request->hasFile('image')) {
            /* Pfad mit Namen und speichern*/
            // $path = $request->file('image')->storeAs('images', $name, 'public');
            /* Pfad ohne Namen */
            $name = time() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('images', $name, 'public');
            $metadata = Image::create();
            $metadata->name = $name;
            $metadata->path = 'images/';
            $metadata->extension = $request->file('image')->getExtension();
            $metadata->saveOrFail();
            return redirect()->route('image')->with('statusSuccess', __('image.uploadSuccess'))->with('imageName', $name);
        }
        return redirect()->route('image')->withErrors('Request has no image');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/image.upload');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $image = Image::first();
        return view('image.show', compact('image'));
    }

    /**
     * Update the specified resource in storage.
     * set only new name to image
     *
     * @param  \Illuminate\Http\Request  $request beinhaltet noch kein neues Image
     * @param  \App\Models\Image  $image altes Image
     * @return \Illuminate\Http\Response
     * // getClientOriginalExtension()
     */
    public function update(Request $request, Image $image)
    {
        // dd($image, $request->file('image'));
        $image = Image::find($request)->get(); // TODO first statt get ...
        $image->name = time() . $request->file('image')->getClientOriginalName();
        $request->file('image')->move('images', $image->name, 'public');
        return redirect()->route('image', compact($request, $image));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        /** Soft-delete */
        $image->delete();
        return redirect()->route('destroy image')->with('status', 'Image Has been removed');
    }

    public function clear()
    {
        $images = Image::onlyTrashed()->get();
        /** Hard-delete */
        foreach ($images as $image) {
            if (Storage::exists('public/' . $image->path)) {
                Storage::delete('public/' . $image->path);
            }
            $image->forceDelete();
        }
        $images = Image::all();
        return view('image.index', compact('images'));
    }

    /** 
     * Restore the specific resource, when it's soft-deleted
     * 
     * @param \App\Models\Example\Image
     * @return \Illuminate\Http\Response
     */
    public function restore($image)
    {
        $image = Image::withTrashed()->findOrFail($image);
        $image->remove_time = null;
        $image->saveOrFail();
        return redirect()->route('restore image')->with('status', 'Image Has been restored');
    }

    /** 
     * rename a image to new name and path
     */
    public function rename(Request $request, Image $image)
    {
        try {
            Storage::move('public/' . $image->path . $image->name, 'public/' . $image->path . $request->rename . '.' . $image->extension);
            // rename(public_path('storage/' . $image->path . $image->name), public_path('storage/' . $image->path . $request->rename));
            $image->name = $request->rename;
            $image->saveOrFail();
        } catch (Exception $e) {
            return redirect()->route('image')->with('status', 'Error,' . $image->name . ' not found');
        }
        return redirect()->route('image')->with('status', 'Image Has been renamed');
    }

    /** alternative
     * store function
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function image(Request $request)
    {
        $validation = new ImageValidatorModule($request);
        $validation->imageValidator();
        $name = $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->store('image');

        $dbItem = new Image();
        $dbItem->name = $name;
        // path descripes the name in Path "storage/app/images
        $dbItem->path = $path;
        $dbItem->saveOrFail();

        $images = Image::all();
        // dd($request, $validation, $dbItem, $name, $path);
        return redirect('image')->with('status', 'Image Has been uploaded:')->with('imageName', $name)->with('images', $images);
    }


    /** Debug Image Data*/
    public function debug(Request $req)
    {
        //Display File Name
        echo 'File Name: ' . $req->getClientOriginalName();
        echo '<br>';

        //Display File Extension
        echo 'File Extension: ' . $req->getClientOriginalExtension();
        echo '<br>';

        //Display File Real Path
        echo 'File Real Path: ' . $req->getRealPath();
        echo '<br>';

        //Display File Size
        echo 'File Size: ' . $req->getSize();
        echo '<br>';

        //Display File Mime Type
        echo 'File Mime Type: ' . $req->getMimeType('JJJJ:MM:DD');

        //copy Uploaded File
        $destinationPath = 'debugPath';
        $req->copy($destinationPath, $req->getClientOriginalName());

        /* display self metadata */
        $path = 'debug';
        $requestData["image"] = '/storage/' . $path;
        echo $requestData;
        return $req;
    }
}

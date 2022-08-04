<?php

namespace App\Http\Controllers\Example;

use Illuminate\Http\Request;
use App\Models\Example\Image;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Modules\ImageValidatorModule;
use App\Services\Global\UtilsService;
use Illuminate\Support\Facades\Storage;

/**
 * variant1: ressource, yield, storage, withName
 * variant2: components, storage
 */

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
    public function store(Request $request)
    {
        /* Variante 1 - Automatisches Validieren durch spezifiziertenRequest ImageRequest TODO nicht implementiert */
        /* Variante 2 - Aufruf der Rule TODO nicht getestet */
        /* Varinate 2 - Aufruf des Modules TODO */
        /* Variante 4 - Aufruf mit Service TODO */

        $validator = new ImageValidatorModule($request);
        $validator->proofImageExist();
        if ($validator != true) {
            dd('Image exist Validation Fails');
            return back()->with('statusError', __('image.existError'));
        }

        $validator->validateImage();
        if ($validator != true) {
            dd('Image has correct form Validation Fails');
            return back()->with('statusError', __('image.validateError'));
        }

        /** storeAs: $path, $name, $options = []     */
        $name = time() . $request->file('image')->getClientOriginalName();
        /* Pfad mit Namen und speichern*/
        // $path = $request->file('image')->storeAs('images', $name, 'public');
        /* Pfad ohne Namen */
        $path = 'images/';
        $request->file('image')->storeAs('images', $name, 'public');

        $metadata = Image::create();
        $metadata->name = $name;
        $metadata->path = $path;
        $metadata->saveOrFail();
        $images = Image::all();
        return redirect('/image')->with('statusSuccess', __('image.uploadSuccess'))->with(compact('images'), 'imageName', $name);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        $image = Image::find($request)->get();
        $image->name = time() . $request->file('image')->getClientOriginalName();
        $request->file('image')->move('images', $image->name, 'public');
        return view('image', compact($request, $image));
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
        return redirect()->back()->with('status', 'Image Has been removed');
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
        return redirect()->back()->with('status', 'Image Has been restored');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        $image = Image::find($image);
        return view('image.edit', compact('image'));
    }

    /** 
     * rename a image to new name and path
     */
    public function rename(Request $request, Image $image)
    {
        $image = Image::find($image);
        dd($request);
        // TODO rename path
        $image->name = $request->name;
        return view('image.show')->with('status', 'Image Has been renamed');
    }

    // /** variant 2
    //  * store function
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function image(Request $request)
    {
        // TODO Erkenne post oder get: Wenn get:
        return view('image.all');

        // Wenn post:

        // $validation = new ImageValidator($request);
        // $validation->imageValidator();
        // $name = $request->file('image')->getClientOriginalName();
        // $path = $request->file('image')->store('image');

        // $dbItem = new Image();
        // $dbItem->name = $name;
        // // path descripes the name in Path "storage/app/images
        // $dbItem->path = $path;
        // $dbItem->saveOrFail();

        // $images = Image::all();
        // // dd($request, $validation, $dbItem, $name, $path);
        // return redirect('image')->with('status', 'Image Has been uploaded:')->with('imageName', $name)->with('images', $images);
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
    /** Debug */
}

<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $brands = Brand::all();
        return view("admin.products.brand.index", [
            'brands' => $brands
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $photo_id = "";
        if ($request->hasFile('brand_logo')) {
            $photo_path = $request->file('brand_logo')->storePublicly('brand', 'public');
            $photo = Photo::create(['path' => $photo_path]);
            $photo_id = $photo->id;
        }
        Brand::create([
            'name' => $request->brand_name,
            'photo_id' => $photo_id
        ]);
        return redirect(route("brand.index"));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $brand = Brand::find($id);
        return view("admin.products.brand.show", compact("brand"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

        $photo_id = "";
        $brand = Brand::find($id);
        if ($request->hasFile('brand_logo')) {
            Storage::disk('public')->delete($brand->photo->path);
            $photo_path = $request->file('brand_logo')->storePublicly('brand', 'public');
            $photo = Photo::create(['path' => $photo_path]);
            $photo_id = $photo->id;
        }
        $brand->update([
            'name' => $request->brand_name,
            'photo_id' => $photo_id
        ]);
        return redirect(route("brand.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        Storage::disk('public')->delete($brand->photo->path);
        $brand->delete();

        return redirect(route("brand.index"));
    }
}

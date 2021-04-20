<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::all();
        return view('admin.slider.index', [
            'sliders' => $sliders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $photo_id = 0;
        if ($request->hasFile('slider_photo')) {
            $photo_path = $request->file('slider_photo')->storePublicly('slider', 'public');
            $photo = Photo::create([
                'path' => $photo_path
            ]);
            $photo_id = $photo->id;
        }
        Slider::create([
            'title' => $request->slider_title,
            'photo_id' => $photo_id
        ]);
        return redirect(route('slider.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::find($id);
        return view('admin.slider.edit', [
            'slider' => $slider
        ]);
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
        $photo_id = 0;
        $slider = Slider::find($id);
        if ($request->hasFile('slider_photo')) {
            Storage::disk('public')->delete($slider->photo->path);
            $photo_path = $request->file('slider_photo')->storePublicly('slider', 'public');
            $photo = Photo::create([
                'path' => $photo_path
            ]);
            $photo_id = $photo->id;
        }
        $slider->update([
            'title' => $request->slider_title,
            'photo_id' => $photo_id
        ]);
        return redirect(route('slider.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);
        Storage::disk('public')->delete($slider->photo->path);
        $slider->delete();
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Backend\Map;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMapRequest;
use App\Http\Requests\UpdateMapRequest;
use App\Models\Map;

class MapController extends Controller {
    public function __construct() {
        $this->middleware('can:read map', [
            'only' => ['index', 'show'],
        ]);
        $this->middleware('can:create map', [
            'only' => ['create', 'store'],
        ]);
        $this->middleware('can:update map', [
            'only' => ['update', 'edit'],
        ]);
        $this->middleware('can:delete map', [
            'only' => ['destroy'],
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $user_id = auth()->user()->expertProfile ? auth()->id() : null;
        $maps = Map::where('user_id', $user_id)->paginate(paginateCount());

        return view('backend.map.showMaps', compact('maps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('backend.map.map');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMapRequest $request) {
        // dd($request->iframe_link);
        $pattern = '/https:\/\/www\.google\.com\/maps\/embed/i';
        $src = str($request->iframe_link)->contains('<iframe') ? preg_grep($pattern, explode('"', $request->iframe_link))[1] : $request->iframe_link;
        // dd($src);
        $map = Map::create([
            ...$request->except(['iframe_link']),
            'src' => $src,
            'user_id' => auth()->user()->expertProfile ? auth()->id() : null,
        ]);
        $notification = [
            'message' => 'Added Successfully',
            'alert-type' => 'success',
        ];

        return redirect(route('map.index'))->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Map $map) {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Map $map) {
        return view('backend.map.editMap', compact('map'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMapRequest $request, Map $map) {
        $pattern = '/https:\/\/www\.google\.com\/maps\/embed/i';
        $src = str($request->iframe_link)->contains('<iframe') ? preg_grep($pattern, explode('"', $request->iframe_link))[1] : $request->iframe_link;
        $map->location = $request->location;
        $map->district = $request->district;
        $map->thana = null !== $request->thana ? $request->thana : $map->thana;
        $map->address = $request->address;
        $map->src = $src;
        $map->update();

        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect(route('map.index'))->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Map $map) {
        $map->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect(route('map.index'))->with($notification);
    }
}

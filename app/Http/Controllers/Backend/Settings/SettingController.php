<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller {
    public $setting;
    public $alert;

    public function __construct() {
        $this->middleware('permission:read basic setting|read referral setting|read payment setting|read return link setting', [
            'only' => ['index'],
        ]);
        $this->middleware('can:manage basic setting', [
            'only' => ['store'],
        ]);
        $this->middleware('can:manage referral setting', [
            'only' => ['reference'],
        ]);
        $this->middleware('can:manage payment setting', [
            'only' => ['payment'],
        ]);
        $this->middleware('can:manage return link setting', [
            'only' => ['returnLink'],
        ]);
        $this->setting = Setting::first();
        $this->alert = [
            'message' => 'Changes Saved',
            'alert-type' => 'success',
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $data = $this->setting;

        return view('backend.settings.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'logo' => 'image|max:5126',
            'email' => 'required|email',
            'phone' => 'required|string',
            'whatsapp' => 'required|string',
            'favicon' => 'image|max:1024',
            'address' => 'required|string',
            'app_name' => 'required|string|max:255',
        ]);
        $logo = $request->has('logo') ? saveImage($request->logo, 'settings', 'logo') : $this->setting->basic->logo;
        $favicon = $request->has('favicon') ? saveImage($request->favicon, 'settings', 'favicon') : $this->setting->basic->favicon;
        $array = [
            'logo' => $logo,
            'favicon' => $favicon,
            'email' => $request->email,
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
            'address' => $request->address,
            'app_name' => $request->app_name,
        ];
        if ($this->setting) {
            $this->setting->basic = $array;
            $this->setting->update();
        } else {
            Setting::create([
                'basic' => $array,
            ]);
        }

        return back()
            ->with($this->alert);
    }

    /**
     * Store a newly created resource in reference.
     */
    public function reference(Request $request) {
        $request->validate([
            'commission' => 'numeric',
            'withdrawal' => 'numeric',
            'partner_commission' => 'numeric',
        ]);
        $array = [
            'commission' => $request->commission ?? 0,
            'withdrawal' => $request->withdrawal ?? 0,
            'partner_commission' => $request->partner_commission ?? 0,
        ];
        if ($this->setting) {
            $this->setting->update(['reference' => $array]);
        } else {
            Setting::create([
                'reference' => $array,
            ]);
        }

        return back()
            ->with($this->alert);
    }

    /**
     * Store a newly created resource in reference.
     */
    public function images(Request $request) {
        $request->validate([
            'header_image' => 'image|max:5124',
            'footer_image' => 'image|max:5124',
        ]);
        $headerImage = saveImage($request->header_image, 'settings', 'header_image');
        $footerImage = saveImage($request->footer_image, 'settings', 'footer_image');
        if ($this->setting) {
            $this->setting->update(['basic->header_image' => $headerImage, 'basic->footer_image' => $footerImage]);
        } else {
            Setting::create(['basic->header_image' => $headerImage, 'basic->footer_image' => $footerImage]);
        }

        return back()
            ->with($this->alert);
    }

    /**
     * Store a newly created resource in reference.
     */
    public function payment(Request $request) {
        // dd($request);
        $request->validate([
            'payment_methods' => 'required|array',
            'payment_numbers' => 'required|array',
        ]);

        $payments = [];
        foreach ($request->payment_methods as $key => $method) {
            $array = [
                'method' => $method,
                'number' => $request->payment_numbers[$key],
            ];
            array_push($payments, $array);
        }
        if ($this->setting) {
            $this->setting->update(['payment' => $payments]);
        } else {
            Setting::create([
                'payment' => $payments,
            ]);
        }

        return back()
            ->with($this->alert);
    }

    public function returnLink(Request $request) {
        // dd($request);
        $request->validate([
            'return_link_titles' => 'required|array',
            'return_links' => 'required|array',
        ]);

        $returnLinks = [];
        foreach ($request->return_link_titles as $key => $title) {
            $array = [
                'title' => $title,
                'link' => $request->return_links[$key],
            ];
            array_push($returnLinks, $array);
        }
        if ($this->setting) {
            $this->setting->update(['return_links' => $returnLinks]);
        } else {
            Setting::create([
                'return_links' => $returnLinks,
            ]);
        }

        return back()
            ->with($this->alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
    }
}

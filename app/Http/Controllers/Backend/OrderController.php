<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ExpertProfile;
use App\Models\Purchase;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $payments = Purchase::latest()->get();
        return view('backend.payment.approved', compact('payments'));
    }

    public function consultancyIndex()
    {
        $payments = Purchase::with('purchasable')->where('purchasable_type','ExpertProfile')->latest()->get();
        //dd($payments);
        return view('backend.payment.consultancyApproved', compact('payments'));
    }

    public function status($id)
    {
        $payments = Purchase::find($id);
        if ($payments->approved === 0) {
            $payments->approved = 1;
        } else {
            $payments->approved = 0;
        }
        $payments->save();
        $notification = [
            'message' => 'Order Approved Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->back()
            ->with($notification);
    }

    public function consultancyStatus($id)
    {
        $payments = Purchase::find($id);
        if ($payments->approved === 0) {
            $payments->approved = 1;
        } else {
            $payments->approved = 0;
        }
        $payments->save();
        $notification = [
            'message' => 'Order Approved Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->back()
            ->with($notification);
    }

    public function destroy($id)
    {
        Purchase::find($id)->delete();
        $notification = [
            'message' => 'Successfully Deleted',
            'alert-type' => 'success',
        ];
        return back()->with($notification);;
    }
}

<?php

namespace App\Http\Controllers\Backend\Invoice;

use Carbon\Carbon;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with('client')->latest()->get();
        return view('backend.invoice.viewAll', compact('invoices'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::get();
        $invoiceImage = null;
        if (countRecords('invoices') > 0) {
            $invoiceImage = Invoice::first()->header_image;
        }
        return view('backend.invoice.createInvoice', compact('clients', 'invoiceImage'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        if ($request->hasFile('header_image')) {
            $header_image = saveImage($request->image, 'invoices', 'invoice');
        }else{
            $header_image = Invoice::first()->header_image;
        }
        $invoice = Invoice::create([
            'client_id' => $request->client,
            'header_image' => $header_image,
            'reference_no' => $request->reference,
            'note' => $request->note,
            'discount' => $request->discount,
            'sub_total' => $request->sub_total,
            'total' => $request->total,
            'amount_paid' => $request->paid,
            'amount_due' => $request->due,
            'payment_note' => $request->payment_note,
            'payment_method' => $request->payment_method,
            'due_date' => $request->due_date,
            'issue_date' => $request->issue_date,
        ]);


        //invoice Items
        foreach ($request->item_names as $key => $name) {
            // taxes
            $taxes = [];
            foreach ($request["tax-$key-names"] as $id => $name) {
                $array = [
                    'name'=> $request["tax-$key-names"][$id],
                    'rate'=> $request["tax-$key-rates"][$id],
                    'number'=> $request["tax-$key-numbers"][$id],
                ];
                array_push($taxes, $array);
            }
            $item = [
                'invoice_id'=> $invoice->id,
                'name'=> $request['item_names'][$key],
                'description'=> $request['item_descriptions'][$key],
                'rate'=> $request['item_rates'][$key],
                'qty'=> $request['item_qtys'][$key],
                'total' => $request['item_rates'][$key] * $request['item_qtys'][$key],
                'taxes'=> json_encode($taxes),
            ];
            $invoiceItem = InvoiceItem::create($item);
        }

        return view('backend.invoice.createInvoice');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $clients = Client::get();
     return view('backend.invoice.viewOne', compact('invoice', 'clients'));
    }

    function getInvoiceData($id) {
        $invoice = Invoice::with('invoiceItems')->find($id);
        $content = new InvoiceResource($invoice);
        return response($content);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}

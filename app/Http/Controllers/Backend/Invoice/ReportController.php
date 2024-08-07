<?php

namespace App\Http\Controllers\Backend\Invoice;

use App\Filter\InvoiceFilter;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\FiscalYear;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReportController extends Controller {
    public function index(string $type) {
        $invoices = Invoice::with('recentFiscalYears')
        ->whereHas('fiscalYears', function ($q) {
            $q->where('year', currentFiscalYear());
        })
        ->latest()->paginate(paginateCount());
        $fiscalYear = currentFiscalYear();
        $fiscalYears = FiscalYear::latest('year')->limit(3)->get()->reverse();

        return view('backend.report.index', compact('invoices', 'fiscalYear', 'fiscalYears', 'type'));
    }

    public function ledger(Request $request) {
        $references = Invoice::select('reference_no')->distinct()->latest()->get()->pluck('reference_no');
        $zones = Client::select('zone')->distinct()->latest()->get()->pluck('zone');
        $circles = Client::select('circle')->distinct()->latest()->get()->pluck('circle');
        $clients = Client::latest()->latest()->get();
        $filter = new InvoiceFilter();
        $queries = $filter->transform($request);
        // dd($queries);
        $invoiceQueries = array_filter($queries, fn ($query) => 'client_id' === $query[0] || 'reference_no' === $query[0]);
        $clientQueries = array_filter($queries, fn ($query) => 'zone' === $query[0] || 'circle' === $query[0]);
        $fiscalQueries = array_filter($queries, fn ($query) => 'year' === $query[0]);
        $pivotQueries = array_filter($queries, fn ($query) => str_contains($query[0], 'fiscal_year_invoice'));
        // dd($fiscalYear);
        $invoiceQueries = array_values($invoiceQueries);
        $clientQueries = array_values($clientQueries);
        $fiscalQueries = array_values($fiscalQueries);
        $pivotQueries = array_values($pivotQueries);
        $fiscalYear = $fiscalQueries[0][2];

        $invoices = Invoice::with('fiscalYears')->where($invoiceQueries)
            ->whereHas('client', function (Builder $query) use ($clientQueries) {
                $query->where($clientQueries);
            })
            ->whereHas('fiscalYears', function ($query) use ($fiscalQueries, $pivotQueries) {
                $query->where($fiscalQueries)
                    ->where($pivotQueries);
            })
            ->latest()->get();

        return view('backend.report.ledger', compact('invoices', 'clients', 'references', 'zones', 'circles', 'fiscalYear'));
    }
}

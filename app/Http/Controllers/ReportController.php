<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportIndexRequest;
use App\Http\Requests\ReportRequest;
use App\Models\Address;
use App\Models\Report;
use App\Models\User;
use App\Services\CreateOrGetAddressService;
use App\Services\GetUniqueDividedAddresses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ReportIndexRequest $request)
    {
        $filter_date = [
            'filter' => false
        ];

        if($request->input('dfrom') && $request->input('dto')) {

            if(Carbon::parse($request->input('dfrom'))->getTimestamp() <= Carbon::parse($request->input('dto'))->getTimestamp()) {
                $filter_date = [
                    'filter' => true,
                    'from' => $request->input('dfrom'),
                    'to' => $request->input('dto')
                ];
            }
        }

        $reports = Report::with('user')
            ->when($request->input('manager'), function ($query) use ($request) {
                $query->where('user_id', $request->input('manager'));
            })
            ->when($filter_date['filter'], function ($query) use ($filter_date) {
                $query->whereDate('created_at', '>=', $filter_date['from'])->whereDate('created_at', '<=', $filter_date['to']);
            })
            ->get();

        $users = User::all(['id', 'name', 'lastname']);

        return view('reports/index', compact('reports', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Report $report)
    {
        Gate::authorize('create', $report);

        $users = User::all(['id', 'name', 'lastname', 'surname']);

        $current_user_id = auth()->user()->id;

        $addresses = Address::all();

        $addresses_unique = GetUniqueDividedAddresses::getAll($addresses);

        return view('reports/create', compact('users', 'current_user_id', 'report', 'addresses_unique'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReportRequest $request)
    {
        Gate::authorize('create', Report::class);
        $addresses = $request->input('addresses');

        $addresses_id = CreateOrGetAddressService::getIdAddresses($addresses);

        $report_input = $request->only(['income', 'user_id']);

        $report = Report::create($report_input);

        $report->addresses()->sync($addresses_id);

        return response(['status_response' => 'ok']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        Gate::authorize('view', $report);
        $report = $report->load(['user', 'addresses']);
        return view('reports/show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        Gate::authorize('update', $report);
        $report = $report->load('addresses');

        $users = User::all(['id', 'name', 'lastname', 'surname']);


        $current_user_id = $report->user_id;

        $addresses = Address::all();

        $addresses_unique = GetUniqueDividedAddresses::getAll($addresses);

        return view('reports/edit', compact('users', 'current_user_id', 'report', 'addresses_unique'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReportRequest $request, Report $report)
    {
        Gate::authorize('update', $report);
        $addresses = $request->input('addresses');
        $report_input = $request->only(['income', 'user_id']);

        $addresses_id = CreateOrGetAddressService::getIdAddresses($addresses);

        if($report) {
            $report->update($report_input);
            $report->addresses()->sync($addresses_id);
        }
        return response(['status_response' => 'ok']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        Gate::authorize('delete', $report);

        $report->delete();
    }
}

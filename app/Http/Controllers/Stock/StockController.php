<?php

namespace App\Http\Controllers\Stock;

use App\Stock;
use DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('stock.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getStockDataTable(Request $request, $download=false)
    {
        $stocks = Stock::select('*');
        if ($request->has('name')) {
            $stocks = $stocks->where('name', 'LIKE', '%'.$request->name.'%');
        }
        if ($request->has('from')) {
            $stocks = $stocks->whereDate('created_at', '>=', Carbon::parse($request->from.' 00:00:00'));
        }
        if ($request->has('to')) {
            $stocks = $stocks->where('created_at', '<=', Carbon::parse($request->to.' 23:59:59'));
        }
        if($download) {
            return $stocks->get();
        }

        return Datatables::of($stocks)
            ->editColumn('type', function ($stock) {
                return ucfirst($stock->type);
            })
            ->editColumn('created_at', function ($stock) {
                return Carbon::parse($stock->created_at)->toFormattedDateString();
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stock.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Stock::create($request->all());
            return redirect('stocks')->with('status', 'New Stock Added Successfully');
        } catch (Exception $e) {
            return redirect('stocks/create')->with('error', 'New Stock Added Successfully');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }
}

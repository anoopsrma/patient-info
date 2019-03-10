<?php

namespace App\Http\Controllers\Stock;

use App\Stock;
use DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
     * Retrieve Data for DataTable.
     * 
     * @param \Illuminate\Http\Request $request
     * @param boolean $download
     * @return \Illuminate\Http\Response
     */
    public function getStockDataTable(Request $request, $download=false)
    {
        $stocks = Stock::select('*');
        if ($request->name) {
            $stocks = $stocks->where('name', 'LIKE', '%'.$request->name.'%');
        }
        if ($request->from) {
            $stocks = $stocks->where('created_at', '>=', Carbon::parse($request->from.' 00:00:00'));
        }
        if ($request->to) {
            $stocks = $stocks->where('created_at', '<=', Carbon::parse($request->to.' 23:59:59'));
        }
        if($download) {
            return $stocks;
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
     * Retrieve Data for DataTable.
     * 
     * @param \Illuminate\Http\Request $request
     * @param boolean $download
     * @return \Illuminate\Http\Response
     */
    public function getStockCsv(Request $request)
    {
        $headers = array(
            'Content-Type'        => 'text/csv',
            'Cache-Control'       => 'no-cache ',
            'Content-Disposition' => 'attachment; filename=stock'.Carbon::now()->toDateString().'.csv',
            'Expires'             => '0',
            'Pragma'              => 'public',
        );
        $stocks = $this->getStockDataTable($request, $download=true);

        return $response = new StreamedResponse(function () use ($stocks) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                "S.N", "Name", "Type", "Price", "Added By", "Created_At"
            ]);
            foreach($stocks->cursor() as $key => $stock) {
                fputcsv($handle, [
                    ++$key,
                    $stock->name,
                    $stock->type,
                    $stock->price,
                    $stock->admin,
                    $stock->created_at,
                ]);
            }
            fclose($handle);
        }, 200, $headers);
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

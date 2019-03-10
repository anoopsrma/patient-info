<?php

namespace App\Http\Controllers\Patient;

use DB;
use Auth;
use App\Patient;
use DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PatientController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('patient.index');
    }

    /**
     * Retrieve Data for DataTable.
     *
     * @param \Illuminate\Http\Request $request
     * @param boolean $download
     * @return \Illuminate\Http\Response
     */
    public function getPatientDataTable(Request $request, $download=false)
    {
        $patients = Patient::select('*');
        if ($request->name) {
            $patients = $patients->where('first_name', 'LIKE', '%'.$request->name.'%')
                            ->orWhere('last_name', 'LIKE', '%'.$request->name.'%')
                            ->orWhere('middle_name', 'LIKE', '%'.$request->name.'%');
        }
        if ($request->from) {
            $patients = $patients->where('created_at', '>=', Carbon::parse($request->from.' 00:00:00'));
        }
        if ($request->to) {
            $patients = $patients->where('created_at', '<=', Carbon::parse($request->to.' 23:59:59'));
        }
        if($download) {
            return $patients;
        }

        return Datatables::of($patients)
            ->editColumn('name', function ($patient) {
                return ($patient->first_name.' '.$patient->middle_name.' '.$patient->last_name.'
                    <br><br><button class="btn btn-sm btn-primary" data-id='.$patient->id.'>View Detail</button>');
            })
            ->rawColumns(['name'])
            ->filterColumn('name', function($query, $keyword) {
                $query->where(function($query) use ($keyword) {
                    $query->whereRaw("CONCAT(first_name,' ',middle_name,' ',last_name) like ?", ["%{$keyword}%"]);
                });
            })
            ->editcolumn('is_new', function ($patient) {
                return ($patient->is_new == 1) ? 'नयाँ' : 'पुरानो';
            })
            ->editcolumn('is_referred', function ($patient) {
                return ($patient->is_referred == 1) ? 'हो' : 'होइन';
            })
            ->editcolumn('has_id', function ($patient) {
                return ($patient->has_id == 1) ? 'छ' : 'छैन';
            })
            ->editcolumn('created_at', function ($patient) {
                return Carbon::parse($patient->created_at)->toFormattedDateString();
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
        return view('patient.form');
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
            $data = $request->only($this->getData()) + ['admin' => Auth::user()->email];
            $patient = Patient::create($data);
            $this->registerMedicine($patient->id, $request->only(['type','medicine','price']));
            return redirect('patients')->with('status', 'New Patient Added Successfully');
        } catch (Exception $e) {
            return redirect('patients/create')->with('error', 'Something Went Wrong!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  string  $id
     * @return array $data
     */
    public function registerMedicine($id, $data)
    {
        foreach ($data['type'] as $key => $value) {
            DB::table('patient_medicines')->insert([
                'patient_id'    => $id,
                'type'          => $value,
                'name'          => $data['medicine'][$key],
                'price'         => $data['price'][$key],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        //
    }

    /**
     * Retrieve patient data keys.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData()
    {
        return [
            "age",
            "group",
            "reg_no",
            "has_id",
            "gender",
            "is_new",
            "address",
            "last_name",
            "first_name",
            "middle_name",
            "is_referred",
            "social_indicator",
        ];
    }
}

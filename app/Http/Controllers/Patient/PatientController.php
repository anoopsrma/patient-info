<?php

namespace App\Http\Controllers\Patient;

use DB;
use Auth;
use Form;
use App\Patient;
use DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
                    <br><br><button class="btn btn-sm btn-primary" id="detail" data-toggle="modal" data-target="#myModal" data-id='.$patient->id.'>औषधी/सेवा</button>');
            })
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
            ->editcolumn('action', function ($patient) {
                $actionHtml =
                    "<a href=" . route('patients.edit', $patient->id) . " class='pull-left'>
                        <i class='fa fa-edit fa-lg mt-4'></i>
                    </a>";
                return $actionHtml .=
                    Form::open([
                        'url' => route('patients.destroy', $patient->id),
                        'method' => 'Delete',
                        'class' => 'pull-right'
                    ]) .
                    "<button href='#' class='btn btn-sm btn-danger' onclick=\"if(!confirm('Are you sure you want to delete ?')) return false;\">Delete</i>
                        </button> " .
                    Form::close();
            })
            ->rawColumns(['name', 'action'])
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
                'created_at'    => Carbon::now()
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
        $data = DB::table('patient_medicines')->where('patient_id',$patient->id)->get();
        return view('patient.table',['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        $medicines = DB::table('patient_medicines')->where('patient_id',$patient->id)->get();
        return view('patient.edit',['patient' => $patient , 'medicines' => $medicines]);
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
        try {
            $data = $request->only($this->getData()) + ['admin' => Auth::user()->email];
            $patient->update($data);
            $this->updateMedicine($patient->id, $request->only(['type','medicine','price']));
            return redirect('patients')->with('status', ' Patient Updated Successfully');
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
    public function updateMedicine($id, $data)
    {
        DB::table('patient_medicines')->where('patient_id',$id)->delete();
        foreach ($data['type'] as $key => $value) {
            DB::table('patient_medicines')->insert([
                'patient_id'    => $id,
                'type'          => $value,
                'name'          => $data['medicine'][$key],
                'price'         => $data['price'][$key],
                'created_at'    => Carbon::now()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        try {
            $patient->delete();
            return redirect('patients')->with('status', ' Patient Deleted Successfully');
        } catch (Exception $e) {
            return redirect('patients/create')->with('error', 'Something Went Wrong!');
        }
        
    }

    /**
     * Retrieve Data for DataTable.
     * 
     * @param \Illuminate\Http\Request $request
     * @param boolean $download
     * @return \Illuminate\Http\Response
     */
    public function getPatientCsv(Request $request)
    {
        $headers = array(
            'Content-Type'        => 'text/csv',
            'Cache-Control'       => 'no-cache ',
            'Content-Disposition' => 'attachment; filename=patient'.Carbon::now()->toDateString().'.csv',
            'Expires'             => '0',
            'Pragma'              => 'public',
        );
        $patients = $this->getPatientDataTable($request, $download=true);

        return $response = new StreamedResponse(function () use ($patients) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                "S.N", "Name", "Gender", "Age", "Group", "Created_At"
            ]);
            foreach($patients->cursor() as $key => $patient) {
                fputcsv($handle, [
                    ++$key,
                    $patient->first_name.' '.$patient->middle_name.' '.$patient->last_name,
                    $patient->gender,
                    $patient->age,
                    $patient->group,
                    $patient->created_at,
                ]);
            }
            fclose($handle);
        }, 200, $headers);
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
            "ward",
        ];
    }
}

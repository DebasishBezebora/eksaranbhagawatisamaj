<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamUsers;
use App\Models\exam_semester;
use Session;

class examMaster extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) :
            $datas = exam_semester::all();
            $dt = datatables()->of($datas)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "<div class='custom-control custom-checkbox'><input class='custom-control-input-danger mainCheckBox' type='checkbox' value='" . $row->EID . "'></div>";
                    $btn .= "<a href='" . url('exam-master') . "/" . $row->EID . "/edit' description='Edit' class='btn btn-block btn-light btn-xs'><i class='fas fa-edit'></i></a>";
                    return $btn;
                })
                ->editColumn('created_at', function ($row) {
                    $formatedDate = date("d/m/Y H:i:s", strtotime($row->created_at));
                    return $formatedDate;
                })
                ->editColumn('updated_at', function ($row) {
                    $formatedDate = date("d/m/Y H:i:s", strtotime($row->updated_at));
                    return $formatedDate;
                })
                ->editColumn('Exam_Type', function ($row) {
                    if ($row->Exam_Type == 1) :
                        $etype = "Even";
                    elseif ($row->Exam_Type == 0) :
                        $etype = "Odd";
                    else :
                        $etype = "";
                    endif;
                    return $etype;
                })
                ->rawColumns(['action'])
                ->make(true);
            return $dt;
            return view('exam_master.examMaster');
        else :
            $data = array();
            if (session()->has('loginID')) :
                $data = ExamUsers::where('ID', '=', Session::get('loginID'))->first();
            endif;
            $a = compact('data');
            $data1 = exam_semester::all();
            $b = compact('data1');
            $c = array_merge($a, $b);
            return view('exam_master.examMaster', $c);
        endif;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        if (session()->has('loginID')) :
            $data = ExamUsers::where('ID', '=', Session::get('loginID'))->first();
        endif;
        $a = compact('data');

        return view('exam_master.examMasterAdd', $a);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required'
            ]
        );

        $examSemester = new exam_semester();

        $examSemester->Exam_Name = $request->name;
        $examSemester->Exam_Type = $request->exam_type;
        $examSemester->Exam_Category = $request->exam_category;
        $examSemester->visitor = $request->ip();

        $res = $examSemester->save();
        if ($res) :
            return back()->with('Success', 'Record has been saved successfully.');
        else :
            return back()->with('Fail', 'Oops! Something is not right.');
        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array();

        $data = array();
        if (session()->has('loginID')) :
            $data = ExamUsers::where('ID', '=', Session::get('loginID'))->first();
        endif;
        $a = compact('data');
        $data1 = exam_semester::where('EID', '=', $id)->first();
        $b = compact('data1');
        $c = array_merge($a, $b);

        return view('exam_master.examMasterEdit', $c);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required'
            ]
        );

        $res = exam_semester::where('EID', $id);
        $res->update([
            'Exam_Name' => $request->name,
            'Exam_Type' => $request->exam_type,
            'Exam_Category' => $request->exam_category,
            'visitor' => $request->ip()
        ]);

        if ($res) :
            return back()->with('Success', 'Record has been updated successfully.');
        else :
            return back()->with('Fail', 'Oops! Something is not right.');
        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ids = explode(",", $id);
        $tata = exam_semester::whereIn('EID', $ids)->delete();
        if ($tata) :
            $res = array("message" => "Record has been removed.");
        else :
            $res = array("error" => "Oops! Something goes wrong.");
        endif;
        echo json_encode($res);
    }
}

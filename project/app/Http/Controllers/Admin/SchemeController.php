<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Scheme;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SchemeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.scheme.index');
    }

    //*** JSON Request
    public function datatables()
    {
        $datas = Scheme::orderBy('id', 'desc')->get();
        //--- Integrating This Collection Into Datatables
        return DataTables::of($datas)
            ->addColumn('action', function (Scheme $data) {
                return '
                <div class="action-list">
                    <a href="' . route('admin-scheme-option-index', $data->id) . '"><i class="fas fa-city"></i> Manage Options</a>
                    <a data-href="' . route('admin-scheme-edit', $data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>Edit</a>
                    <a href="javascript:;" data-href="' . route('admin-scheme-delete', $data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a>
                </div>';
            })

            ->addColumn('status', function (Scheme $data) {
                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                $s = $data->status == 1 ? 'selected' : '';
                $ns = $data->status == 0 ? 'selected' : '';
                return '<div class="action-list"><select class="process select droplinks ' . $class . '"><option data-val="1" value="' . route('admin-scheme-status', [$data->id, 1]) . '" ' . $s . '>Activated</option><option data-val="0" value="' . route('admin-scheme-status', [$data->id, 0]) . '" ' . $ns . '>Deactivated</option>/select></div>';
            })

            ->rawColumns(['action', 'status'])
            ->toJson(); //--- Returning Json Data To Client Side
    }




    public function create()
    {
        return view('admin.scheme.create');
    }


    public function store(Request $request)
    {

        $rules = [
            'name'  => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $scheme = new Scheme();
        $scheme->name = $request->name;
        $scheme->save();
        $mgs = __('Data Added Successfully.');
        return response()->json($mgs);
    }


    //*** GET Request Status
    public function status($id1, $id2)
    {
        Scheme::findOrFail($id1)->update([
            'status' => $id2
        ]);
    }


    public function edit($id)
    {
        $scheme = Scheme::findOrFail($id);
        return view('admin.scheme.edit', compact('scheme'));
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'name'  => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $scheme = Scheme::findOrFail($id);
        $scheme->name = $request->name;
        $scheme->update();
        $mgs = __('Data Updated Successfully.');
        return response()->json($mgs);
    }


    public function delete($id)
    {
        $scheme = Scheme::findOrFail($id);
        $scheme->delete();
        $mgs = __('Data Deleted Successfully.');
        return response()->json($mgs);
    }
}

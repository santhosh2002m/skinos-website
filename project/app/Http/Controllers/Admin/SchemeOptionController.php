<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Scheme;
use App\Models\SchemeEntries;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SchemeOptionController extends Controller
{
    public function manageSchemeOptions($scheme_id)
    {
        $scheme = Scheme::findOrFail($scheme_id);
        return view('admin.scheme.options.index', compact('scheme'));
    }

    //*** JSON Request
    public function datatables($scheme_id)
    {
        $datas = SchemeEntries::with('scheme')->orderBy('order', 'asc')->where('scheme_id', $scheme_id)->get();
        //--- Integrating This Collection Into Datatables
        return DataTables::of($datas)
            ->addColumn('action', function (SchemeEntries $data) use ($scheme_id) {
                return '
                <div class="action-list">
                    <a data-href="' . route('admin-scheme-option-edit', $data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>Edit</a>
                    <a href="javascript:;" data-href="' . route('admin-scheme-option-delete', $data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a>
                </div>';
            })
            ->addColumn('status', function (SchemeEntries $data) {
                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                $s = $data->status == 1 ? 'selected' : '';
                $ns = $data->status == 0 ? 'selected' : '';
                return '<div class="action-list">
                    <select class="process select droplinks ' . $class . '">
                        <option data-val="1" value="' . route('admin-scheme-option-status', [$data->id, 1]) . '" ' . $s . '>Activated</option>
                        <option data-val="0" value="' . route('admin-scheme-option-status', [$data->id, 0]) . '" ' . $ns . '>Deactivated</option>
                    </select>
                </div>';
            })
            ->rawColumns(['action', 'status'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    public function create($scheme_id)
    {
        $scheme = Scheme::findOrFail($scheme_id);
        return view('admin.scheme.options.create', compact('scheme'));
    }

    public function store(Request $request, $scheme_id)
    {
        $rules = [
            'name' => 'required|string',
            'order' => 'required|integer|min:0',
            'total_quantity' => 'required|numeric',
            'discount_percentage' => 'required|numeric',
            'number_of_boxes' => 'required|numeric',
            'name_of_the_box' => 'required|string',
            'quantity_of_items_per_box' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $scheme_entry = new SchemeEntries();
        $scheme_entry->name = $request->name;
        $scheme_entry->order = $request->order;
        $scheme_entry->total_quantity = $request->total_quantity;
        $scheme_entry->discount_percentage = $request->discount_percentage;
        $scheme_entry->number_of_boxes = $request->number_of_boxes;
        $scheme_entry->name_of_the_box = $request->name_of_the_box;
        $scheme_entry->quantity_of_items_per_box = $request->quantity_of_items_per_box; 
        $scheme_entry->scheme_id = $scheme_id;
        $scheme_entry->status = 1;
        $scheme_entry->save();
        $mgs = __('Data Added Successfully.');
        return response()->json($mgs);
    }

    public function status($id1, $id2)
    {
        $schemeEntries = SchemeEntries::findOrFail($id1);
        $schemeEntries->status = $id2;
        $schemeEntries->update();
    }

    public function edit($id)
    {
        $schemeEntry = SchemeEntries::findOrFail($id);
        return view('admin.scheme.options.edit', compact('schemeEntry'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string',
            'order' => 'required|integer|min:0',
            'total_quantity' => 'required|numeric',
            'discount_percentage' => 'required|numeric',
            'number_of_boxes' => 'required|numeric',
            'name_of_the_box' => 'required|string',
            'quantity_of_items_per_box' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $scheme_entry = SchemeEntries::findOrFail($id);
        $scheme_entry->name = $request->name;
        $scheme_entry->order = $request->order;
        $scheme_entry->total_quantity = $request->total_quantity;
        $scheme_entry->discount_percentage = $request->discount_percentage;
        $scheme_entry->number_of_boxes = $request->number_of_boxes;
        $scheme_entry->name_of_the_box = $request->name_of_the_box;
        $scheme_entry->quantity_of_items_per_box = $request->quantity_of_items_per_box; 
        $scheme_entry->update();
        $mgs = __('Data Updated Successfully.');
        return response()->json($mgs);
    }

    public function delete($id)
    {
        $scheme_entry = SchemeEntries::findOrFail($id);
        $scheme_entry->delete();
        $mgs = __('Data Deleted Successfully.');
        return response()->json($mgs);
    }
}
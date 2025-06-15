<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cashback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;

class CashbackController extends Controller
{
    public function index()
    {
        return view('admin.Cashbacks.index');
    }

    public function datatables(Request $request)
    {
        $cashbacks = Cashback::query();

        return DataTables::of($cashbacks)
            ->addColumn('action', function ($cashback) {
                return '
                    <a href="javascript:;" data-href="' . route('admin-cashback-edit', $cashback->id) . '" class="edit" data-toggle="modal" data-target="#modal1"><i class="fas fa-edit"></i></a>
                    <a href="javascript:;" data-href="' . route('admin-cashback-destroy', $cashback->id) . '" class="delete" data-toggle="modal" data-target="#confirm-delete"><i class="fas fa-trash-alt"></i></a>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.Cashbacks.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'min_purchase_value' => 'required|integer|min:0',
            'max_purchase_value' => 'required|integer|gt:min_purchase_value',
            'advance_percentage' => 'required|numeric|min:0|max:100',
            'days_7_percentage' => 'required|numeric|min:0|max:100',
            'days_7_30_percentage' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Cashback::create($request->only([
            'min_purchase_value',
            'max_purchase_value',
            'advance_percentage',
            'days_7_percentage',
            'days_7_30_percentage',
        ]));

        return response()->json(['success' => 'Cashback created successfully.']);
    }

    public function edit($id)
    {
        $cashback = Cashback::findOrFail($id);
        return view('admin.Cashbacks.edit', compact('cashback'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'min_purchase_value' => 'required|integer|min:0',
            'max_purchase_value' => 'required|integer|gt:min_purchase_value',
            'advance_percentage' => 'required|numeric|min:0|max:100',
            'days_7_percentage' => 'required|numeric|min:0|max:100',
            'days_7_30_percentage' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cashback = Cashback::findOrFail($id);
        $cashback->update($request->only([
            'min_purchase_value',
            'max_purchase_value',
            'advance_percentage',
            'days_7_percentage',
            'days_7_30_percentage',
        ]));

        return response()->json(['success' => 'Cashback updated successfully.']);
    }

    public function destroy($id)
    {
        $cashback = Cashback::findOrFail($id);
        $cashback->delete();

        return response()->json(['success' => 'Cashback deleted successfully.']);
    }
}
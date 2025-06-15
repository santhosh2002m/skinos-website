<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\DiscountSlab;
use App\Models\Scheme;
use Illuminate\Http\Request;
use Validator;
use Datatables;

class DiscountSlabController extends AdminBaseController
{
    //*** JSON Request
    public function datatables()
    {
        $datas = DiscountSlab::latest('id')->get();
        //--- Integrating This Collection Into Datatables
        return Datatables::of($datas)
            ->addColumn('status', function (DiscountSlab $data) {
                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                $s = $data->status == 1 ? 'selected' : '';
                $ns = $data->status == 0 ? 'selected' : '';
                return '<div class="action-list"><select class="process select droplinks ' . $class . '"><option data-val="1" value="' . route('admin-slabs-status', ['id1' => $data->id, 'id2' => 1]) . '" ' . $s . '>' . __("Activated") . '</option><option data-val="0" value="' . route('admin-slabs-status', ['id1' => $data->id, 'id2' => 0]) . '" ' . $ns . '>' . __("Deactivated") . '</option>/select></div>';
            })
            ->addColumn('action', function (DiscountSlab $data) {
                return '<div class="action-list"><a data-href="' . route('admin-slabs-edit', $data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>' . __('Edit') . '</a><a href="javascript:;" data-href="' . route('admin-slabs-delete', $data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
            })
            ->rawColumns(['status', 'attributes', 'action','is_featured'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    public function index()
    {
        return view('admin.discountslabs.index');
    }

    public function create()
    {
        return view('admin.discountslabs.create');
    }
    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
            'min_value' => 'required|integer|min:0',
            'max_value' => 'nullable|integer|min:0|gt:min_value',
            'discount_percentage' => 'required|numeric|between:0,100',
        ];
        
        $customs = [
            'min_value.required' => __('Minimum value is required.'),
            'min_value.integer' => __('Minimum value must be an integer.'),
            'min_value.min' => __('Minimum value must be at least 0.'),
        
            'max_value.integer' => __('Maximum value must be an integer.'),
            'max_value.min' => __('Maximum value must be at least 0.'),
            'max_value.gt' => __('Maximum value must be greater than minimum value.'),
        
            'discount_percentage.required' => __('Discount percentage is required.'),
            'discount_percentage.numeric' => __('Discount percentage must be a number.'),
            'discount_percentage.between' => __('Discount percentage must be between 0 and 100.'),
        ];
        
        $validator = Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        $data = new DiscountSlab();
        $input = $request->all();
        $data->fill($input)->save();
        $msg = __('New Data Added Successfully.');
        return response()->json($msg);
    }

    //*** GET Request
    public function edit($id)
    {
        $data = DiscountSlab::findOrFail($id);
        return view('admin.discountslabs.edit', compact('data'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
            'min_value' => 'required|integer|min:0',
            'max_value' => 'nullable|integer|min:0|gt:min_value',
            'discount_percentage' => 'required|numeric|between:0,100',
        ];
        
        $customs = [
            'min_value.required' => __('Minimum value is required.'),
            'min_value.integer' => __('Minimum value must be an integer.'),
            'min_value.min' => __('Minimum value must be at least 0.'),
        
            'max_value.integer' => __('Maximum value must be an integer.'),
            'max_value.min' => __('Maximum value must be at least 0.'),
            'max_value.gt' => __('Maximum value must be greater than minimum value.'),
        
            'discount_percentage.required' => __('Discount percentage is required.'),
            'discount_percentage.numeric' => __('Discount percentage must be a number.'),
            'discount_percentage.between' => __('Discount percentage must be between 0 and 100.'),
        ];
        
        $validator = Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = DiscountSlab::findOrFail($id);
        $input = $request->all();
        // if ($file = $request->file('photo')) {
        //     $name = \PriceHelper::ImageCreateName($file);
        //     $file->move('assets/images/brands', $name);
        //     if ($data->photo != null) {
        //         if (file_exists(public_path() . '/assets/images/brands/' . $data->photo)) {
        //             unlink(public_path() . '/assets/images/brands/' . $data->photo);
        //         }
        //     }
        //     $input['photo'] = $name;
        // }
        // if ($file = $request->file('image')) {
        //     $name = \PriceHelper::ImageCreateName($file);
        //     $file->move('assets/images/brands', $name);
        //     $input['image'] = $name;
        // }


        $data->update($input);
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = __('Data Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request Status
    public function status($id1, $id2)
    {
        $data = DiscountSlab::findOrFail($id1);
        $data->status = $id2;
        $data->update();
        //--- Redirect Section
        $msg = __('Status Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request Delete
    public function destroy($id)
    {
        $data = DiscountSlab::findOrFail($id);
        $data->delete();
        $msg = __('Data Deleted Successfully.');
        return response()->json($msg);
    }
}

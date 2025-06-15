<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Scheme;
use Illuminate\Http\Request;
use Validator;
use Datatables;

class BrandController extends AdminBaseController
{
    //*** JSON Request
    public function datatables()
    {
        $datas = Brand::with('scheme')->latest('id')->get();
        //--- Integrating This Collection Into Datatables
        return Datatables::of($datas)
                ->editColumn('scheme_id', function ($brand) {
                    return $brand->scheme ? $brand->scheme->name : '-'; // Handle null values
                })
            ->addColumn('status', function (Brand $data) {
                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                $s = $data->status == 1 ? 'selected' : '';
                $ns = $data->status == 0 ? 'selected' : '';
                return '<div class="action-list"><select class="process select droplinks ' . $class . '"><option data-val="1" value="' . route('admin-brand-status', ['id1' => $data->id, 'id2' => 1]) . '" ' . $s . '>' . __("Activated") . '</option><option data-val="0" value="' . route('admin-brand-status', ['id1' => $data->id, 'id2' => 0]) . '" ' . $ns . '>' . __("Deactivated") . '</option>/select></div>';
            })
            ->editColumn('is_featured', function (Brand $data) {
                $class = $data->is_featured == 1 ? 'drop-success' : 'drop-danger';
                $s = $data->is_featured == 1 ? 'selected' : '';
                $ns = $data->is_featured == 0 ? 'selected' : '';
                return '<div class="action-list"><select class="process select droplinks ' . $class . '"><option data-val="1" value="' . route('admin-brand-featured', ['id1' => $data->id, 'id2' => 1]) . '" ' . $s . '>' . __("Activated") . '</option><option data-val="0" value="' . route('admin-brand-featured', ['id1' => $data->id, 'id2' => 0]) . '" ' . $ns . '>' . __("Deactivated") . '</option>/select></div>';
            })
            ->addColumn('action', function (Brand $data) {
                return '<div class="action-list"><a data-href="' . route('admin-brand-edit', $data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>' . __('Edit') . '</a><a href="javascript:;" data-href="' . route('admin-brand-delete', $data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
            })
            ->rawColumns(['status', 'attributes', 'action','is_featured'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    public function index()
    {
        return view('admin.brand.index');
    }

    public function create()
    {
        $schemes = Scheme::where('status',1)->where('is_deleted',0)->pluck('id','name')->toArray();
        if(empty($schemes)){
            return redirect()->back()->with('error',__('Create Scheme.'));
        }
        return view('admin.brand.create',compact('schemes'));
    }
    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
            
            'slug' => 'unique:brands|regex:/^[a-zA-Z0-9\s-]+$/',
            'image' => 'required|mimes:jpeg,jpg,png,svg'
        ];
        $customs = [
            
            'slug.unique' => __('This slug has already been taken.'),
            'slug.regex' => __('Slug Must Not Have Any Special Characters.'),
            'image.required' => __('Banner Image is required.'),
            'image.mimes' => __('Banner Image Type is Invalid.')
        ];
        $validator = Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Brand();
        $input = $request->all();
        if ($file = $request->file('photo')) {
            $name = \PriceHelper::ImageCreateName($file);
            $file->move('assets/images/brands', $name);
            $input['photo'] = $name;
        }
        if ($file = $request->file('image')) {
            $name = \PriceHelper::ImageCreateName($file);
            $file->move('assets/images/brands', $name);
            $input['image'] = $name;
        }

        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = __('New Data Added Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request
    public function edit($id)
    {
        $data = Brand::findOrFail($id);
        $schemes = Scheme::where('status',1)->where('is_deleted',0)->pluck('id','name')->toArray();
        return view('admin.brand.edit', compact('data','schemes'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
            
            'slug' => 'unique:brands,slug,' . $id . '|regex:/^[a-zA-Z0-9\s-]+$/',
            'image' => 'mimes:jpeg,jpg,png,svg'
        ];
        $customs = [
            
            'slug.unique' => __('This slug has already been taken.'),
            'slug.regex' => __('Slug Must Not Have Any Special Characters.'),
            'image.mimes' => __('Banner Image Type is Invalid.')
        ];
        $validator = Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = Brand::findOrFail($id);
        $input = $request->all();
        if ($file = $request->file('photo')) {
            $name = \PriceHelper::ImageCreateName($file);
            $file->move('assets/images/brands', $name);
            if ($data->photo != null) {
                if (file_exists(public_path() . '/assets/images/brands/' . $data->photo)) {
                    unlink(public_path() . '/assets/images/brands/' . $data->photo);
                }
            }
            $input['photo'] = $name;
        }
        if ($file = $request->file('image')) {
            $name = \PriceHelper::ImageCreateName($file);
            $file->move('assets/images/brands', $name);
            $input['image'] = $name;
        }


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
        $data = Brand::findOrFail($id1);
        $data->status = $id2;
        $data->update();
        //--- Redirect Section
        $msg = __('Status Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request Status
    public function featured($id1, $id2)
    {
        $data = Brand::findOrFail($id1);
        $data->is_featured  = $id2;
        $data->update();
        //--- Redirect Section
        $msg = __('Status Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }


    //*** GET Request Delete
    public function destroy($id)
    {
        $data = Brand::findOrFail($id);

        if ($data->attributes->count() > 0) {
            //--- Redirect Section
            $msg = __('Remove the Attributes first !');
            return response()->json($msg);
            //--- Redirect Section Ends
        }

     
        if (file_exists(public_path() . '/assets/images/brands/' . $data->image)) {
            unlink(public_path() . '/assets/images/brands/' . $data->image);
        }
        $data->delete();
        //--- Redirect Section
        $msg = __('Data Deleted Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }
}

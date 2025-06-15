<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Blog;
use Illuminate\Http\Request;
use Validator;
use Datatables;

class TagController extends AdminBaseController
{
    public function datatables()
    {
        $datas = Tag::latest('id')->get();
        return Datatables::of($datas)
            ->addColumn('status', function (Tag $data) {
                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                $s = $data->status == 1 ? 'selected' : '';
                $ns = $data->status == 0 ? 'selected' : '';
                return '<div class="action-list"><select class="process select droplinks ' . $class . '"><option data-val="1" value="' . route('admin-tag-status', ['id1' => $data->id, 'id2' => 1]) . '" ' . $s . '>' . __("Activated") . '</option><option data-val="0" value="' . route('admin-tag-status', ['id1' => $data->id, 'id2' => 0]) . '" ' . $ns . '>' . __("Deactivated") . '</option></select></div>';
            })
            ->addColumn('action', function (Tag $data) {
                return '<div class="action-list"><a data-href="' . route('admin-tag-edit', $data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>' . __('Edit') . '</a><a href="javascript:;" data-href="' . route('admin-tag-delete', $data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    }

    public function index()
    {
        return view('admin.tags.index');
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
            'name' => 'required',
            'slug' => 'unique:tags|regex:/^[a-zA-Z0-9\s-]+$/',
            'image' => 'required|mimes:jpeg,jpg,png,svg'
        ];
        $customs = [
            'name.required' => __('Name is required.'),
            'slug.unique' => __('This slug has already been taken.'),
            'slug.regex' => __('Slug Must Not Have Any Special Characters.'),
            'image.required' => __('Image is required.'),
            'image.mimes' => __('Image Type is Invalid.')
        ];
        $validator = Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Tag();
        $input = $request->all();
        if ($file = $request->file('image')) {
            $name = \PriceHelper::ImageCreateName($file);
            $file->move('assets/images/categories', $name);
            $input['image'] = $name;
        }

        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = __('New Data Added Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    public function edit($id)
    {
        $data = Tag::findOrFail($id);
        return view('admin.tags.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
            'name' => 'required',
            'slug' => 'unique:tags,slug,' . $id . '|regex:/^[a-zA-Z0-9\s-]+$/',
            'image' => 'mimes:jpeg,jpg,png,svg'
        ];
        $customs = [
            'name.required' => __('Name is required.'),
            'slug.unique' => __('This slug has already been taken.'),
            'slug.regex' => __('Slug Must Not Have Any Special Characters.'),
            'image.mimes' => __('Image Type is Invalid.')
        ];
        $validator = Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = Tag::findOrFail($id);
        $input = $request->all();
        if ($file = $request->file('image')) {
            $name = \PriceHelper::ImageCreateName($file);
            $file->move('assets/images/categories', $name);
            if ($data->image != null && file_exists(public_path() . '/assets/images/categories/' . $data->image)) {
                unlink(public_path() . '/assets/images/categories/' . $data->image);
            }
            $input['image'] = $name;
        }

        $data->update($input);
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = __('Data Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    public function status($id1, $id2)
    {
        $data = Tag::findOrFail($id1);
        $data->status = $id2;
        $data->update();

        $msg = __('Status Updated Successfully.');
        return response()->json($msg);
    }

    public function destroy($id)
    {
        $data = Tag::findOrFail($id);
        if ($data->image != null && file_exists(public_path() . '/assets/images/categories/' . $data->image)) {
            unlink(public_path() . '/assets/images/categories/' . $data->image);
        }
        $data->delete();

        $msg = __('Data Deleted Successfully.');
        return response()->json($msg);
    }
}
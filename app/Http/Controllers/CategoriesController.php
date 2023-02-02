<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Null_;

class CategoriesController extends Controller
{

    public function add(Request $request)
    {
        $categories = Categories::where('parent_id', Null)->get();
        return view('templates.categories.add', compact('categories'));
    }

    //add categories in database
    public function categoryAdd(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
            }

            $category = new Categories();
            $slug = Str::lower($request->title);
            $category->title = trim($request->title);
            $category->slug = str_replace(' ', '-', trim($slug));
            $category->parent_id = $request->parent;
            if ($category->save()) {
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Category has been added successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'msg' => 'Failed to add the category'
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
        }
    }
    public function categoryCount(Request $request)
    {
        try {
            $filterName = $request->filterName;
            $filterStatus = $request->filterStatus;
            $result = Categories::query();

            if ($filterName != '') {
                $result = $result->where('title', 'like', '%' . $filterName . '%');
            }

            // if ($filterStatus !='all'){
            //     $result = $result->where('status',$filterStatus);
            // }  

            $count = $result->count();
            if ($count > 0) {
                return response()->json(['status' => 'success', 'data' => $count]);
            } else {
                return response()->json(['status' => 'fail', 'msg' => 'No Data Found']);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
        }
    }
    public function categoryList(Request $request)
    {
        try {
            $filterName = $request->filterName;
            $filterStatus = $request->filterStatus;
            $filterLength = $request->filterLength;
            $result = Categories::query();

            if ($filterName != '') {
                $result = $result->where('title', 'like', '%' . $filterName . '%');
            }

            // if ($filterStatus !='all'){
            //     $result = $result->where('status',$filterStatus);
            // }            

            $i = 1;

            $categories = $result->take($filterLength)->skip($request->offset)->orderBy('id', 'DESC')->get();
            if (isset($categories) && sizeof($categories) > 0) {
                $html = '';
                foreach ($categories as $category) {
                    $html .= '
                        <tr class="border-bottom"> 
                            <td>' . $i++ . '</td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 fw-semibold">
                                ' . ucwords($category->title) . '
                                    </h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">' . $category->slug . '</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">'.($category->parent_id!=NULL? $category->parent->title :'').'</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">' . self::status($category->parent_id) . '</h6>
                            </td>

                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a  href="/category/edit/' . $category->id . '" class="btn btn-warning btnEdit">Edit</a> 
                                    <a  class="btn btn-danger text-white btnDelete" id="' . $category->id . '">Delete</a>
                                </div>
                            </td>
                        </tr>
                    ';
                }
                return response()->json(['status' => 'success', 'rows' => $html, 'data' => $categories]);
            } else {
                return response()->json(['status' => 'fail', 'msg' => 'No Category Found!']);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
        }
    }
    public static function status($status)
    {
        $html = '';
        if ($status == '') {
            $html = '<badge class="badge bg-success">Parrent</badge>';
        } else {
            $html = '<badge class="badge bg-danger">Child</badge>';
        }

        return $html;
    }

    // delete category

    public function deleteCategory($id)
    {
        try {
            $category = Categories::find($id);

            if ($category->delete()) {
                return response()->json(['status' => 'success', 'msg' => 'Category has been deleted']);
            }
            return response()->json(['status' => 'fail', 'msg' => 'Failed to delete the category']);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
        }
    }
    public function viewEdit($id)
    {
        $category = Categories::where('id', $id)->first();
        $categories = Categories::where('parent_id', Null)->get();
        if (!empty($category)) {
            return view('templates.categories.edit', ['category' => $category, 'categories' => $categories]);
        } else {
            return view('templates.404');
        }
    }
    public function updateCategory(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'title' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
            }

            $category = Categories::find($request->id);
            $slug = Str::lower($request->title);
            $category->title = trim($request->title);
            $category->slug = str_replace(' ', '-', trim($slug));
            if ($request->parent != '') {
                $category->parent_id = $request->parent;
            }


            if ($category->save()) {
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Category updated'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'msg' => 'Failed to update the category'
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
        }
    }

    // get all child categories of parent category
    public function getCild(Request $request)
    {
        $categories = Categories::where('parent_id', $request->id)->get();
        if (isset($categories) && sizeof($categories) > 0) {
            $html = '';
            $html .= '<option value="">Select child :</option>';
            foreach ($categories as $category) {
                $html .= '<option value="' . $category->id . '">' . $category->title . '</option>';
            }
            return response()->json(['status' => 'success', 'rows' => $html]);
        } else {
            return response()->json(['status' => 'fail', 'msg' => 'No Category Found!']);
        }
    }
}

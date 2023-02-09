<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Categories;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Inventory_items;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    //
    public function add(Request $request)
    {
        $categories = Categories::where('parent_id', Null)->get();
        return view('templates.products.add', compact('categories'));
    }
    // add product data in db
    public function productAdd(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'quantity' => 'required',
                'parent' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
            }
            $inventery_items = new Inventory_items();
            $inventery_items->name = trim($request->name);
            $inventery_items->unit = trim($request->unit);
            if ($inventery_items->save()) {
                $inventery = new Inventory();
                $inventery->item_id = $inventery_items->id;
                $inventery->quantity = $request->quantity;
                $inventery->last_quantity = $request->quantity;
                $inventery->parent_category_id = $request->parent;
                $inventery->child_category_id = $request->child;
                $inventery->site_id =Auth::user()->site_id;
                $inventery->save();
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Product has been added successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'msg' => 'Failed to add the product'
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
        }
    }
    public function productCount(Request $request)
    {
        try {
            $filterName = $request->filterName;
            $filterStatus = $request->filterStatus;
            $filterItemId=$request->filterItemId;
            $result = Inventory::query();

            if ($filterName != '') {
                $result = $result->whereHas(
                    'inventory_item',
                    function ($q) use ($filterName) {

                        $q->where('name', 'like', '%' . $filterName . '%');
                    }
                );
            }
            if($filterItemId !=''){
                $result = $result->where('item_id',$filterItemId);
            }
            // if ($filterStatus !='all'){
            //     $result = $result->where('status',$filterStatus);
            // }  

            $count = $result->where('site_id',Auth::user()->site_id)->count();
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

    public function productList(Request $request)
    {
        try {
            $filterName = $request->filterName;
            $filterStatus = $request->filterStatus;
            $filterLength = $request->filterLength;
            $filterItemId=$request->filterItemId;
            $result = Inventory::query();
            if ($filterName != '') {
                $result = $result->whereHas(
                    'inventory_item',
                    function ($q) use ($filterName) {

                        $q->where('name', 'like', '%' . $filterName . '%');
                    }
                );
            }
            if($filterItemId !=''){
                $result = $result->where('item_id',$filterItemId);
            }
            $i = 1;

            $products = $result->where('site_id',Auth::user()->site_id)->take($filterLength)->skip($request->offset)->orderBy('id', 'DESC')->get();

            if (isset($products) && sizeof($products) > 0) {
                $html = '';
                foreach ($products as $product) {
                    // dd($product->inventory_item->name);
                    $html .= '
                        <tr class="border-bottom"> 
                            <td>' . $i++ . '</td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 fw-semibold">
                                ' . ucwords($product->inventory_item->name) . '
                                    </h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">' . $product->inventory_item->unit . '</h6>
                            </td>

                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">' . ($product->quantity) . '</h6>
                            </td>
                            <td>
                            <h6 class="mb-0 m-0 fs-14 ">' . ($product->categories->title) . '</h6>
                              </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a  href="/products/edit/' . $product->id . '" class="btn btn-warning btnEdit">Edit</a> 
                                    <a  class="btn btn-danger text-white btnDelete" id="' . $product->id . '">Delete</a>
                                </div>
                            </td>
                        </tr>
                    ';
                }
                return response()->json(['status' => 'success', 'rows' => $html]);
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

    public function deleteProduct($id)
    {
        try {
            $inventory = Inventory::find($id);
            $inventry_item = Inventory_items::find($inventory->item_id);
            if ($inventory->delete()) {
                $inventry_item->delete();
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
    // product edit
    public function viewEdit($id)
    {
        $inventory = Inventory::where('id', $id)->first();
        $parent_categories = Categories::where('parent_id', Null)->get();
        $child_categories = Categories::where('parent_id', $inventory->parent_category_id)->get();
        if (!empty($inventory)) {
            return view('templates.products.edit', ['inventory' => $inventory, 'parent_categories' => $parent_categories, 'child_categories' => $child_categories]);
        } else {
            return view('templates.404');
        }
    }
    public function updateProduct(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'quantity' => 'required',
                'parent' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
            }
            $inventery = Inventory::find($request->id);
            $inventery->quantity = $request->quantity;
           // $inventery->last_quantity = $request->quantity;
            $inventery->parent_category_id = $request->parent;
            $inventery->child_category_id = $request->child;
            if ($inventery->save()) {
                $ineventry_item=Inventory_items::find($inventery->item_id);
                $ineventry_item->name=$request->name;
                $ineventry_item->unit=$request->unit;
                $ineventry_item->save();
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Products updated'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'msg' => 'Failed to update the products'
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
        }
    }
}

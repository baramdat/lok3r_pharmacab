<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Inventory;
use App\Models\Categories;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Requested_product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RequestedController extends Controller
{
    public function index()
    {
        $products = Inventory::where('site_id', Auth::user()->site_id)->get();

        return view('templates.requested_product.add', compact('products'));
    }

    public function add(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product' => 'required',
                'quantity' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
            }
            $requests_p = new Requested_product();
            $requests_p->product_id = $request->product ? $request->product : '';
            $requests_p->quantity = $request->quantity ? $request->quantity : '';
            $requests_p->user_id = Auth::user()->id;
            $requests_p->site_id = Auth::user()->site_id;
            $requests_p->status = 'open';
            if ($requests_p->save()) {
                $name= ucwords($requests_p->user->first_name) .' '.ucwords($requests_p->user->last_name);
                $user = User::role(['Site Admin'])->where('site_id', Auth::user()->site_id)->first();
                $user_name=ucwords($user->first_name) .' '.ucwords($user->last_name);
                Mail::send('templates.email.product_request', ['user_name'=>$user_name,'name' =>$name,'quantity'=>$request->quantity, 'product' => $requests_p->inventory_item->name, 'site' => $requests_p->site->name], function ($message) use ($user) {
                    $message->to($user->email)
                        ->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'))
                        ->subject("Product requested ");
                });
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Product request has been added successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'msg' => 'Failed to add the product request'
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
        }
    }

    public function list()
    {

        return view('templates.requested_product.list');
    }

    public function requestCount(Request $request)
    {
        try {
            $filterName = $request->filterName;
            $filterStatus = $request->filterStatus;
            $result = Requested_product::query();

            if ($filterName != '') {
                $result = $result->whereHas(
                    'inventory_item',
                    function ($q) use ($filterName) {

                        $q->where('name', 'like', '%' . $filterName . '%');
                    }
                );
            }
            if (Auth::user()->hasRole('Site User')) {
                $result = $result->where('user_id', Auth::user()->id);
            }
            $count = $result->where('site_id', Auth::user()->site_id)->count();
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

    public function requestProductList(Request $request)
    {
        try {
            $filterName = $request->filterName;
            $filterStatus = $request->filterStatus;
            $filterLength = $request->filterLength;
            $result = Requested_product::query();
            if ($filterName != '') {
                $result = $result->whereHas(
                    'inventory_item',
                    function ($q) use ($filterName) {

                        $q->where('name', 'like', '%' . $filterName . '%');
                    }
                );
            }
            if (Auth::user()->hasRole('Site User')) {
                $result = $result->where('user_id', Auth::user()->id);
            }
            $i = 1;

            $products = $result->where('site_id', Auth::user()->site_id)->take($filterLength)->skip($request->offset)->orderBy('id', 'DESC')->get();

            if (isset($products) && sizeof($products) > 0) {
                $html = '';
                foreach ($products as $product) {
                    // dd($product->inventory_item->name);
                    $html .= '
                    <tr class="border-bottom"> 
                        <td>' . $i++ . '</td>
                        <td>
                            <h6 class="mb-0 m-0 fs-14 fw-semibold">
                            ' . (ucwords($product->user->first_name) . ' ' . $product->user->last_name) . '
                                </h6>
                        </td>
                        <td>
                            <h6 class="mb-0 m-0 fs-14 ">' . ucwords($product->site->name) . '</h6>
                        </td>
                        <td>
                        <h6 class="mb-0 m-0 fs-14 ">' . ucwords($product->inventory_item->name) . '</h6>
                        </td>
                        <td>
                            <h6 class="mb-0 m-0 fs-14 ">' . ($product->quantity) . '</h6>
                        </td>
                        <td>
                        <h6 class="mb-0 m-0 fs-14 ">' . ucwords($product->status) . '</h6>
                          </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">';
                    if (!Auth::user()->hasRole('Site User')) {
                        $html .= '   <a   class="btn btn-warning" onclick="updateStatus(' . $product->id . ')">Status</a> ';
                    }
                    $html .= '    <a  class="btn btn-danger text-white btnDelete" id="' . $product->id . '">Delete</a>
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
    public function updateRequestStaus(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'status' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
            }
            $product = Requested_product::find($request->request_id);
            $product->status = $request->status;
            if ($product->save()) {
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Status updated updated'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'msg' => 'Failed to update the status'
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
        }
    }
    public function deleteRequestedProduct($id)
    {
        try {
            $product = Requested_product::find($id);
            if ($product->delete()) {
                return response()->json(['status' => 'success', 'msg' => 'Request has been deleted']);
            }
            return response()->json(['status' => 'fail', 'msg' => 'Failed to delete the request']);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Customer;
use App\DataTables\AdminOrdersDataTable;
use Barryvdh\Debugbar\Facade as DebugBar;
use Auth;
use DB;

class OrderController extends Controller
{
    public function orderDetails($id) {
        
        // $customer = DB::table('customer as c')->join('orderinfo as o','o.customer_id', '=', 'c.customer_id')
        //     ->where('o.orderinfo_id', $id)
        //     ->select('c.addressline', 'c.phone','o.orderinfo_id',  'o.status','o.date_placed')
        //     ->first();
        // // dd($customer);
        // $orders = DB::table('customer as c')->join('orderinfo as o','o.customer_id', '=', 'c.customer_id')
        //     ->join('orderline as ol','o.orderinfo_id', '=', 'ol.orderinfo_id')
        //     ->join('item as i','ol.item_id', '=', 'i.item_id')
        //     ->where('c.user_id', Auth::id())
        //     ->where('o.orderinfo_id', $id)
        //     ->select('i.description', 'ol.quantity', 'i.image_path', 'i.sell_price' )
        //     ->get();
        //     // dd($orders);

        $order = Order::with(['customer','items'])->whereHas('customer', function($query) {
            $query->where('user_id', Auth::id());
        })->where('orderinfo_id', $id)->first();

            $total = number_format($order->items->map(function($item) {
                return $item->pivot->quantity * $item->sell_price;
            })->sum(), 2);
            DebugBar::info($order, Auth::id());
            //    dd($total->sum());
        return view('user.order', compact('order', 'total'));
    }

    public function orders(AdminOrdersDataTable $dataTable){
        if(Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->back()->with('warning', 'not authorized');
        }
        return $dataTable->render('order.orders');

    }

    public function processOrder($id) {
        $customer = DB::table('customer as c')->join('orderinfo as o','o.customer_id', '=', 'c.customer_id')
            ->where('o.orderinfo_id', $id)
            ->select('c.addressline', 'c.phone','o.orderinfo_id',  'o.status','o.date_placed','o.status')
            ->first();
        // dd($customer);
        $orders = DB::table('customer as c')->join('orderinfo as o','o.customer_id', '=', 'c.customer_id')
            ->join('orderline as ol','o.orderinfo_id', '=', 'ol.orderinfo_id')
            ->join('item as i','ol.item_id', '=', 'i.item_id')
            ->where('o.orderinfo_id', $id)
            ->select('i.description', 'ol.quantity', 'i.image_path', 'i.sell_price' )
            ->get();
            // dd($orders);
            //pagtotal ng lahat ng orders
            $total = $orders->map(function ($item, $key) {
                 return $item->sell_price * $item->quantity;
            })->sum();
            // $total = $orders->map(function ($item, $key) {
            //      return $item->sell_price * $item->quantity;
            // })->sum();
            //    dd($total->sum());
        return view('order.processOrder', compact('customer', 'orders', 'total'));
    }

    public function orderUpdate(Request $request, $id) {
        // dd($request);
        Order::where('orderinfo_id', $id)
            ->update(['status' => $request->status]);
        return redirect()->route('admin.orders');
    }
}

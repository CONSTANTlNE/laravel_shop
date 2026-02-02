<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('owner_type', 'App\\Models\\User')
            ->where('owner_id', auth('web')->user()->id)
            ->with(['orderItems.product', 'city', 'owner'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('frontend.customer.customer_orders', compact('orders'));
    }

    public function adminIndex(Request $request)
    {
        $perPage = (int) $request->query('per_page', 30);
        if ($perPage <= 0) {
            $perPage = 30;
        }

        $sortBy = in_array($request->query('sort_by'), ['created_at', 'order_token', 'grand_total', 'address', 'bank_order_id'])
            ? $request->query('sort_by')
            : 'created_at';
        $sortDir = strtolower($request->query('sort_dir')) === 'asc' ? 'asc' : 'desc';

        $ordersQuery = Order::with(['orderItems.product', 'owner', 'city', 'presentsRelation', 'waybill']);

        // Search across amount (grand_total), address, and bank order id
        if ($q = trim((string) $request->query('q', ''))) {
            $ordersQuery->where(function ($builder) use ($q) {
                $builder->where('address', 'like', "%{$q}%")
                    ->orWhere('bank_order_id', 'like', "%{$q}%")
                    ->orWhere('order_token', 'like', "%{$q}%");
                // If query is numeric, try matching grand_total approximately
                if (is_numeric(str_replace([','], ['.'], $q))) {
                    $num = (float) str_replace([','], ['.'], $q);
                    $builder->orWhere('grand_total', $num)
                        ->orWhere('grand_total', 'like', "%{$q}%");
                } else {
                    $builder->orWhere('grand_total', 'like', "%{$q}%");
                }
            });
        }

        $orders = $ordersQuery
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage)
            ->appends($request->query());

        return view('backend.admin_orders', compact('orders', 'sortBy', 'sortDir'));
    }

    public function delivery(Request $request)
    {
        $order = Order::where('id', $request->input('order_id'))->with('waybill')->first();

        if ($order) {
            if ($order->is_delivered == 0) {
                if ($order->waybill != null) {
                    return back()->with('alert_error', 'Waybill issued, you must finish waybill');
                }
                $order->is_delivered = 1;
            } else {
                if ($order->waybill != null && $order->waybill->is_finished == true) {
                    return back()->with('alert_error', 'Waybill finished, cant change to "not delivered"');
                }
                $order->is_delivered = 0;
            }
            $order->save();

            return back();
        }

        return back()->with('alert_error', 'Order not found');
    }

    public function invoice(Request $request, $locale, $order)
    {

        $order = Order::where('owner_id', auth()->id())
            ->where('order_token', $order)
            ->with('orderItems', 'presentsRelation', 'city')
            ->first();

        if (! $order) {
            return back()->with('alert_error', __('Order not found'));
        }

        return view('frontend.invoice.invoice_template', compact('order'));
    }
}

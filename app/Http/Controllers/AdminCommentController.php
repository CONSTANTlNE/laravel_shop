<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    public function orderCommentStore(Request $request)
    {

        $order = Order::find($request->order_id);

        $order->adminComments()->create([
            'comment' => 'This product needs a price update.',
            'admin_id' => auth('admin')->id(),
        ]);
    }

    public function orderCommentDelete(Request $request) {}
}

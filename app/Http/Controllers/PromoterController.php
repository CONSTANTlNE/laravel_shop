<?php

namespace App\Http\Controllers;

use App\Models\Promoter;
use Illuminate\Http\Request;

class PromoterController extends Controller
{
    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'comment' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:255',
        ]);

        Promoter::create($data);

        return back()->with('alert_success', 'promoter added successfully');

    }

    public function update(Request $request) {}

    public function delete(Request $request)
    {

        $request->validate([
            'promoter_id' => 'required|exists:promoters,id',
        ]);

        $promoter = Promoter::find($request->promoter_id);
        $promoter->delete();

        return back()->with('alert_success', 'Promoter Deleted Successfully');

    }
}

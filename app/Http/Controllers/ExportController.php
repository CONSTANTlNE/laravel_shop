<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Exports\TotalSalesExport;
use App\Models\Export;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;

class ExportController extends Controller
{
    public function salesSumDownload(Request $request)
    {

        $from = $request->input('date_from');
        $to = $request->input('date_to');

        return new TotalSalesExport($from, $to)->download('invoices.xlsx');

    }

    public function exportProducts(Request $request)
    {
        $filename = 'products_'.now()->format('d-m-Y_H-i-s').'.xlsx';
        $path = 'exports/'.$filename;

        // Ensure the exports directory exists
        Storage::disk('public')->makeDirectory('exports');

        // 1. Generate the file synchronously (without queue)
        (new ProductsExport)->store($path, 'public', null, [Excel::XLSX]);

        // 2. Create the record
        $export = Export::create([
            'status' => 'completed',
            'admin_id' => auth('admin')->id(),
        ]);

        // 3. Get the absolute path from the public disk
        $fullPath = Storage::disk('public')->path($path);

        // 4. Verify file exists before adding to media library
        if (Storage::disk('public')->exists($path)) {
            $export->addMedia($fullPath)->toMediaCollection('exports');

            // 5. Delete the original file from storage
            Storage::disk('public')->delete($path);

            return back()->with('success', __('Products export has been stored in your media library.'));
        } else {
            // Clean up the export record if file doesn't exist
            $export->delete();

            return back()->with('error', __('Failed to generate export file.'));
        }
    }

    public function message(Request $request)
    {

        $export = Export::where('admin_id', auth('admin')->id())
            ->where('status', 'completed')
            ->with('media')->first();

        if ($export != null) {
            return view('backend.htmx.export_status', compact('export'));

        } else {
            return view('backend.htmx.export_status_done');
        }

    }

    public function download()
    {
        $export = Export::where('admin_id', auth('admin')->id())
            ->where('status', 'completed')
            ->first();

        if (! $export) {
            return back()->with('error', 'Export not found.');
        }

        // Get the latest file from the 'exports' collection
        $media = $export->getFirstMedia('exports')->getUrl();

        if (! $media) {
            return back()->with('error', 'File not found.');
        }

        $export->status = 'downloaded';
        $export->save();

        // Returns a standard Laravel download response
        return redirect()->away($media);
    }
}

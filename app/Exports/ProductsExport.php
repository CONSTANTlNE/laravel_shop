<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    use Exportable;

    public function query()
    {
        return Product::query()
            ->with(['category', 'subcategory'])
            ->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Date Created',
            'SKU',
            'Name',
            'Category',
            'Subcategory',
            'Stock',
            'Price',
            'In Stock',
            'Removed from Store',
            'Featured',
        ];
    }

    public function map($product): array
    {
        $locale = app()->getLocale();

        return [
            $product->created_at->format('d/m/Y'),
            $product->sku,
            is_array($product->name) ? ($product->name[$locale] ?? '') : $product->name,
            $product->category ? (is_array($product->category->name) ? ($product->category->name[$locale] ?? '') : $product->category->name) : '',
            $product->subcategory ? (is_array($product->subcategory->name) ? ($product->subcategory->name[$locale] ?? '') : $product->subcategory->name) : '',
            $product->stock,
            $product->price,
            $product->in_stock ? 'Yes' : 'No',
            $product->removed_from_store ? 'Yes' : 'No',
            $product->featured ? 'Yes' : 'No',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

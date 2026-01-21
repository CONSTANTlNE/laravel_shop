<?php

namespace App\Exports;

use App\Models\OrderItem;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TotalSalesExport implements FromQuery, ShouldAutoSize, WithColumnFormatting, WithEvents, WithHeadings, WithStyles
{
    use Exportable;

    protected $from;

    protected $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function query()
    {
        $locale = app()->getLocale();

        $from = Carbon::parse($this->from)->startOfDay();
        $to = Carbon::parse($this->to)->endOfDay();

        return OrderItem::query()
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->selectRaw('
        order_items.product_id,
        products.sku as sku,
        SUM(order_items.quantity) as total_quantity,
        SUM(order_items.product_price * order_items.quantity) as total_amount,
        COUNT(order_items.id) as sales_count
    ')
            ->selectRaw("products.name ->> '{$locale}' as product_name")
            ->selectRaw("categories.name ->> '{$locale}' as category_name")
            ->selectRaw("subcategories.name ->> '{$locale}' as subcategory_name")
            ->whereBetween('order_items.created_at', [
                $from,
                $to,
            ])
            ->groupBy(
                'order_items.product_id',
                'products.sku',
                'product_name',
                'category_name',
                'subcategory_name'
            )
            ->orderBy('order_items.product_id');

    }

    public function headings(): array
    {
        return [
            'Product ID',
            'SKU',
            'Total Quantity',
            'Total Amount',
            'Sales Count',
            'Product Name',
            'Category',
            'Subcategory',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
            'D' => NumberFormat::FORMAT_NUMBER_00,
            'E' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // 🔹 General header text
                $title = 'TOTAL SALES REPORT ('.
                    Carbon::parse($this->from)->format('d-m-Y').
                    ' → '.
                    Carbon::parse($this->to)->format('d-m-Y').
                    ')';

                // 🔹 Insert new row BEFORE headings
                $sheet->insertNewRowBefore(1, 1);

                // 🔹 Merge across all columns (A → I)
                $sheet->mergeCells('A1:H1');

                // 🔹 Set title text
                $sheet->setCellValue('A1', $title);

                // 🔹 Style it
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],
                ]);

                // 🔹 Increase row height
                $sheet->getRowDimension(1)->setRowHeight(30);
            },
        ];
    }
}

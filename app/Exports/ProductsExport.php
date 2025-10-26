<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $query;

    public function __construct(\Illuminate\Database\Eloquent\Builder $query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'Product ID',
            'Product Name',
            'Assembly ID',
            'Product Code',
            'Serial Number',
            'Description',
            'Purchase Date',
            'Warranty Date',
            'Purchase Price',
            'Purchase From',
            'Status',
            'Remark',
            'Product Created At',
            'Product Updated At',
            'Assembly Name',
            'Assembly Code',
            'Assembly Image',
            'Department Name',
            'Branch Name',
            'Employee Name',
            'Assembly Remark',
            'Creater By',
            //             'Assembly User ID',
            'Assembly Status',
            'Verify Status',
            'Assembly Created At',
            // 'Assembly Updated At',
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->assembly_id,
            $product->code,
            $product->serial_number,
            $product->description,
            $product->purchase_date,
            $product->warranty_date,
            $product->purchase_price,
            $product->purchase_from,
            $product->status,
            $product->remark,
            $product->created_at,
            $product->updated_at,
            $product->assembly->name ?? '',
            $product->assembly->code ?? '',
            $product->assembly->image ?? '',
            $product->assembly->department->name ?? '',
            $product->assembly->branch->name ?? '',
            $product->assembly->employee->name ?? '',
            $product->assembly->remark ?? '',
            $product->assembly->user->name ?? '',
            //             $product->assembly->is_active ? 'Active' : 'Inactive',,
            $product->assembly->latestVerify->status ?? 'Unknown',
            date_format($product->assembly->created_at, 'j-M-Y') ?? '',
            // $product->assembly->updated_at ?? '',
        ];
    }
}

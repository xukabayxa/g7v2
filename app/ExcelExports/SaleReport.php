<?php

namespace App\ExcelExports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use \Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class SaleReport implements FromView, WithEvents
{
    use Exportable;

    public function forData($data) {
        $this->data = $data;
        return $this;
    }

    public function view(): View
    {
        $data = $this->data;
        return view('g7.warehouse_reports.exports.saleReport', compact('data'));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:H500';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setName('Times New Roman');
            },
        ];
    }
}

<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoiceReportExport implements FromCollection, WithHeadings
{
    protected $invoices;

    public function __construct(array $invoices)
    {
        $this->invoices = $invoices;
    }

    public function collection()
    {
        return collect($this->invoices);
    }

    public function headings(): array
    {
        return [
            'S.No',
            'Booking Id',
            'Invoice ID',
            'Transporter Name',
            'Date',
            'Destination',
            'Total Amount',
            'Paid Amount',
            'Balance Amount',
            'No of Driver',
        ];
    }
}
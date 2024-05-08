<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TranspoterDataExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        // Define the column headings for the Excel file
        return [
            'Transporter Name',
            'Booking ID',
            'Invoice ID',
            'Date',
            'Destination',
            'Total Amount',
            'Paid Amount',
            'Balance Amount',
            'No of Driver',
        ];
    }
}
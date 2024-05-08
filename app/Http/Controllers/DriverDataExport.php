<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DriverDataExport implements FromCollection, WithHeadings
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
            // 'S.No',
            // 'Driver ID',
            'Driver Name',
            'Booking ID',
            'Invoice ID',
            'Transporter Name',
            'Date',
            'Destination',
            'Total Amount',
            'Paid Amount',
            'Balance Amount',
        ];
    }
}
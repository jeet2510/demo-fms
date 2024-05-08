<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingReportExport implements FromCollection, WithHeadings
{
    protected $processedData;

    public function __construct(array $processedData)
    {
        $this->processedData = collect($processedData);
    }

    public function headings(): array
    {
        return [
            'Sno',
            'Booking ID',
            'Transporter Name',
            'Date',
            'Destination',
            'Total Booking Amount',
            'Paid Amount',
            'Balance Amount',
            'Driver Count'
        ];
    }

    public function collection()
    {
        return $this->processedData;
    }
}
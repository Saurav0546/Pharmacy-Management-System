<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function generatePDF()
    {
        $medicines = [
            ['name' => 'Aspirin', 'price' => '10.50', 'quantity' => '100'],
            ['name' => 'Paracetamol', 'price' => '5.20', 'quantity' => '150'],
            ['name' => 'Ibuprofen', 'price' => '7.30', 'quantity' => '80'],
        ];
        
        $pdf = Pdf::loadView('pdf.pharmacy_report', compact('medicines'));

        return $pdf->download('pharmacy_report.pdf');
        
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use GuzzleHttp\Psr7\Response;

class PdfController extends Controller
{
  public function __invoke($id)
  {
    $nota = Nota::with('NotaProduct.products')->findOrFail($id);

    $sum = $nota->notaProduct->sum(function ($notaProduct) {
      return $notaProduct->product_quantity * $notaProduct->product_price;
    });

    // return view('pdf', compact('nota', 'sum'));
    $pdf = Pdf::loadView('pdf', compact('nota', 'sum'));
    return $pdf->stream();
  }
}

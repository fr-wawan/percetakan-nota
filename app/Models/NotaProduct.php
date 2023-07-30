<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaProduct extends Model
{
  use HasFactory;
  protected $table = 'nota_product';

  protected $guarded = [];

  public function products()
  {
    return $this->belongsTo(Product::class);
  }
}

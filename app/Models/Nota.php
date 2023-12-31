<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
  use HasFactory;
  protected $guarded = [];

  public function NotaProduct()
  {
    return $this->hasMany(NotaProduct::class);
  }

  public function customer()
  {
    return $this->belongsTo(Customer::class);
  }
}

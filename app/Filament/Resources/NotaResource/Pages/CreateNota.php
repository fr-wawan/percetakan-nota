<?php

namespace App\Filament\Resources\NotaResource\Pages;

use App\Filament\Resources\NotaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNota extends CreateRecord
{
  protected static string $resource = NotaResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    return $data;
  }
}

<?php

namespace App\Filament\Resources;

use stdClass;
use Filament\Forms;
use App\Models\Nota;
use Filament\Tables;
use App\Models\Product;
use App\Models\Customer;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use App\Filament\Resources\NotaResource\Pages;
use Filament\Tables\Columns\SelectColumn;

class NotaResource extends Resource
{
  protected static ?string $model = Nota::class;

  protected static ?string $navigationIcon = 'heroicon-o-document-text';

  protected static function getNavigationLabel(): string
  {
    return "Nota";
  }

  public static function getPluralLabel(): string
  {
    return "Nota";
  }


  public static function form(Form $form): Form
  {
    return $form->schema(
      [
        Card::make()->schema([
          TextInput::make('invoice')->disabled()->default('TRX-' . time()),
          Select::make('customer_id')
            ->required()->relationship('customer', 'nama')->required()->options(Customer::all()->pluck('nama', 'id'))->reactive()->searchable(),
          Select::make('status')->required()->options([
            'processing' => 'Processing',
            'delivered' => 'Delivered',
          ])->columnSpanFull(),
          TextInput::make('address')->required()->columnSpanFull(),
          RichEditor::make('notes')->required()->columnSpanFull(),
        ])->columns(2),
        Repeater::make('NotaProduct')->relationship()->schema([
          Select::make('products_id')
            ->required()->relationship('products', 'nama')->required()->options(Product::all()->pluck('nama', 'id'))->reactive()->searchable()->afterStateUpdated(function ($state, callable $get, callable $set) {
              $product = Product::find($state);
              if ($product) {
                $set('product_price', (string) $product->harga);
              }
            }),

          TextInput::make('product_quantity')->required()->reactive()->afterStateUpdated(function ($state, callable $get, callable $set) {
            $total = doubleval($get('product_price')) * intval($get('product_quantity'));
            $set('subtotal', (string) $total);
          }),

          TextInput::make('product_price')->disabled()->mask(
            fn (Forms\Components\TextInput\Mask $mask) => $mask
              ->numeric()
              ->decimalPlaces(2)
              ->thousandsSeparator(',')
          ),
          TextInput::make('subtotal')->disabled()->dehydrated(false)->mask(
            fn (Forms\Components\TextInput\Mask $mask) => $mask
              ->numeric()
              ->decimalPlaces(2)
              ->thousandsSeparator(',')
          ),
        ])->columnSpanFull(),

      ]
    );
  }


  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('index')->getStateUsing(
          static function (stdClass $rowLoop, HasTable $livewire): string {
            return (string) ($rowLoop->iteration +
              ($livewire->tableRecordsPerPage * ($livewire->page - 1
              ))
            );
          }
        ),
        Tables\Columns\TextColumn::make('invoice')->label('Invoice'),
        Tables\Columns\TextColumn::make('customer.nama')->label('Customer'),
        TextColumn::make('status')->enum([
          'processing' => 'Processing',
          'delivered' => 'Delivered',
        ]),
        Tables\Columns\TextColumn::make('created_at')->label('Tanggal Nota'),

      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\Action::make('Export')
          ->label('Print')
          ->color('success')
          ->icon('heroicon-o-document-download')
          ->url(fn (Nota $record) => route('pdf', $record))
          ->openUrlInNewTab(),
      ])
      ->bulkActions([
        Tables\Actions\DeleteBulkAction::make(),
      ])->defaultSort('created_at', 'desc');
  }

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListNotas::route('/'),
      'create' => Pages\CreateNota::route('/create'),
      'edit' => Pages\EditNota::route('/{record}/edit'),
    ];
  }
}

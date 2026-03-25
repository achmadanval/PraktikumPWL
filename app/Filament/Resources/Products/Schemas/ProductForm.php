<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\step;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Psy\Readline\Interactive\Actions\SubmitLineAction;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
        ->components([
            Wizard::make([
                Step::make('Product Info')
                    ->description('Isi Informasi Produk')
                    ->icon(Heroicon::CircleStack)
                    ->schema([
                        Group::make([
                            TextInput::make('name')
                                ->required(),
                            TextInput::make('sku')
                                ->required(),
                        ])->columns(2),
                        MarkdownEditor::make('description')
                    ]),

                    Step::make('Product Price and Stock')
                    ->description('isi Harga Produk')
                    ->icon(Heroicon::CurrencyDollar)
                    ->schema([
                        Group::make([
                            TextInput::make('price')
                            ->numeric()
                            ->required()
                            ->minValue(3),
                            TextInput::make('stock')
                            ->required(),
                        ])->columns(2),
                        MarkdownEditor::make('description')
                    ]),

                    Step::make('Media & Status')
                    ->description('Upload gambar dan atur Status')
                    ->icon(Heroicon::ClipboardDocument)
                    ->schema([
                        FileUpload::make('image')
                        ->disk('public')
                        ->directory('products'),

                        Checkbox::make('is_active'),
                        
                        Checkbox::make('is_featured'),
                    ]),
            ])
            ->columnSpanFull()
            ->submitAction(
                Action::make('save')
                    ->label('Save Product')
                    ->button()
                    ->color('primary')
                    ->submit('save')
            )
        ]);
    }
}

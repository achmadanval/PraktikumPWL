<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Product Tabs')
                ->tabs([
                    Tab::make('Product details')
                    ->icon('heroicon-s-clipboard-document')
                        ->schema([
                            TextEntry::make('name')
                                ->label('Product Name')
                                ->weight('bold')
                                ->color('primary'),
                            TextEntry::make('id')
                                ->label('Product id'),
                            TextEntry::make('sku')
                                ->label('Product SKU')
                                ->badge()
                                ->color('warning'),
                            TextEntry::make('description')
                                ->label('Product Description')
                                ->color('primary'),
                            TextEntry::make('created_at')
                                ->label('Product Creation Date')
                                ->date('d M Y')
                                ->color('info'),
                        ])
                        ->columnSpanFull(),
                    Tab::make('Product Price and Stock')
                    ->icon('heroicon-s-currency-dollar')
                        ->schema([
                            TextEntry::make('price')
                                ->label('Product Price')
                                ->weight('bold')
                                ->color('primary')
                                ->formatStateUsing(fn(string $state) : string => 'Rp' . number_format($state, 0, ',' , '.'))
                                ->icon('heroicon-s-currency-dollar'),
                            TextEntry::make('stock')
                                ->label('Product Stock')
                                ->icon('heroicon-o-building-storefront')
                                ->badge()
                                ->color(fn (int $state): string => match (true) {
                                    $state <= 0 => 'danger',    
                                    $state <= 10 => 'warning',  
                                    default => 'success',       
                                }),
                            ])->columnSpanFull(),
                    Tab::make('Image and Status')
                    ->icon('heroicon-o-camera')
                    
                        ->schema([
                            ImageEntry::make('image')
                                ->label('Product Image')
                                ->disk('public'),
                            TextEntry::make('Price')
                                ->label('Product Price')
                                ->weight('bold')
                                ->color('primary')
                                ->icon('heroicon-s-currency-dollar'),
                            TextEntry::make('stock')
                                ->label('Product Stock')
                                ->weight('bold')
                                ->color('primary'),
                            IconEntry::make('is_active')
                                ->label('Is Active?')
                                ->boolean(),
                            IconEntry::make('is_featured')
                                ->label('Is Featured?')
                                ->boolean(),
                            ])
                ])->columnSpanFull()
                ->vertical(),
            ]);
    }
}

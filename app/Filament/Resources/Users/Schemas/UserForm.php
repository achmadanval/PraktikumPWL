<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->unique(ignoreRecord:true)
                    ->required()
                    ->maxLength(255),
                TextInput::make('password')
                    ->password()
                    ->minLength(6)
                    ->required(),
                    
            ]);
    }
}

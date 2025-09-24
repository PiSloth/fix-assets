<?php

namespace App\Filament\Resources\Assemblies\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class AssemblyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('code')
                    ->required(),

                Select::make('department_id')
                    ->relationship('department', 'name')
                    ->required(),
                Select::make('branch_id')
                    ->relationship('branch', 'name')
                    ->required(),
                Select::make('employee_id')
                    ->relationship('employee', 'name')
                    ->required(),
                FileUpload::make('image')
                    ->image(),
                TextInput::make('remark'),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Assemblies\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AssemblyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('code'),
                TextEntry::make('branch_id')
                    ->numeric(),
                TextEntry::make('department_id')
                    ->numeric(),
                TextEntry::make('employee_id')
                    ->numeric(),
                TextEntry::make('user_id')
                    ->numeric(),
                ImageEntry::make('image'),
                TextEntry::make('remark'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}

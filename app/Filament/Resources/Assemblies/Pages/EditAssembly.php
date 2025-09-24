<?php

namespace App\Filament\Resources\Assemblies\Pages;

use App\Filament\Resources\Assemblies\AssemblyResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAssembly extends EditRecord
{
    protected static string $resource = AssemblyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

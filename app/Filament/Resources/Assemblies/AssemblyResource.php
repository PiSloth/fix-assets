<?php

namespace App\Filament\Resources\Assemblies;

use App\Filament\Resources\Assemblies\Pages\CreateAssembly;
use App\Filament\Resources\Assemblies\Pages\EditAssembly;
use App\Filament\Resources\Assemblies\Pages\ListAssemblies;
use App\Filament\Resources\Assemblies\Pages\ViewAssembly;
use App\Filament\Resources\Assemblies\Schemas\AssemblyForm;
use App\Filament\Resources\Assemblies\Schemas\AssemblyInfolist;
use App\Filament\Resources\Assemblies\Tables\AssembliesTable;
use App\Models\Assembly;
use BackedEnum;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssemblyResource extends Resource
{
    protected static ?string $model = Assembly::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('latestVerify');
    }

    public static function form(Schema $schema): Schema
    {
        return AssemblyForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AssemblyInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssembliesTable::configure($table);
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
            'index' => ListAssemblies::route('/'),
            'create' => CreateAssembly::route('/create'),
            'view' => ViewAssembly::route('/{record}'),
            'edit' => EditAssembly::route('/{record}/edit'),
        ];
    }
}

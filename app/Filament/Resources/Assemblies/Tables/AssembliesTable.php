<?php

namespace App\Filament\Resources\Assemblies\Tables;

use App\Models\Assembly;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AssembliesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('code')
                    ->searchable(),
                TextColumn::make('branch.name')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('department.name')
                    // ->numeric()
                    ->sortable(),
                TextColumn::make('employee.name')
                    // ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Verification Status')
                    ->badge()
                    ->getStateUsing(function (Assembly $record): string {
                        return $record->verify()->latest()->first()?->status ?? 'Not Verified';
                    })
                    ->color(fn($state) => match (strtolower((string) $state)) {
                        'verified' => 'success',
                        'pending' => 'warning',
                        'not verified' => 'primary',
                        'reject' => 'danger',
                        default => 'secondary',
                    })
                    ->sortable(),

                // ImageColumn::make('getImageUrlAttribute')
                //     ->toggleable()
                //     ->label('Image'),
                ImageColumn::make('image')
                    ->label('Image')
                    ->square() // or ->circular()
                    ->width(80)
                    ->toggleable(),

                TextColumn::make('remark'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('branch_id')
                    ->label('Branch')
                    ->relationship('branch', 'name'),
                SelectFilter::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'name'),
                SelectFilter::make('employee_id')
                    ->label('Employee')
                    ->relationship('employee', 'name'),
                SelectFilter::make('user_id')
                    ->label('Created By')
                    ->relationship('user', 'name'),
                // SelectFilter::make('status')
                //     ->options([
                //         'Not Verified' => 'Not Verified',
                //         'Pending' => 'Pending',
                //         'Verified' => 'Verified',
                //         'Reject' => 'Reject',
                //     ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporResource\Pages;
use App\Filament\Resources\LaporResource\RelationManagers;
use App\Models\Lapor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LaporResource extends Resource
{
    protected static ?string $model = Lapor::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';
    protected static ?string $navigationGroup = 'Management Data';
    protected static ?string $label = 'Lapor';
    protected static ?string $pluralLabel = 'Lapor';

    public static function getNavigationBadge(): ?string
    {
        return (string) Lapor::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('author')->label('Pelapor')->searchable(),
                TextColumn::make('judul')->label('Judul')->searchable()->limit(30),
                TextColumn::make('kategori')->label('Kategori')->searchable(),
                TextColumn::make('status_laporan')->label('Status')->badge(),
                TextColumn::make('report_time')->label('Waktu Lapor')->dateTime('d M Y H:i'),
            ])
            ->filters([

            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListLapors::route('/'),
        ];
    }
}

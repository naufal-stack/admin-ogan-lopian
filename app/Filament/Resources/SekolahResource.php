<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SekolahResource\Pages;
use App\Filament\Resources\SekolahResource\RelationManagers;
use App\Models\Sekolah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class SekolahResource extends Resource
{
    protected static ?string $model = Sekolah::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Management Data';
    protected static ?string $label = 'Sekolah';
protected static ?string $pluralLabel = 'Sekolah';

    public static function getNavigationBadge(): ?string
    {
        return (string) Sekolah::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('npsn')
                    ->label('NPSN')
                    ->required()
                    ->unique(ignoreRecord: true) // NPSN harus unik, abaikan record saat update
                    ->maxLength(255),
                TextInput::make('nama')
                    ->label('Nama Sekolah')
                    ->required()
                    ->maxLength(255),
                TextInput::make('alamat')
                    ->label('Alamat')
                    ->maxLength(255)
                    ->nullable(),
                TextInput::make('desa')
                    ->label('Desa')
                    ->maxLength(255)
                    ->nullable(),
                TextInput::make('kecamatan')
                    ->label('Kecamatan')
                    ->maxLength(255)
                    ->nullable(),
                Select::make('jenjang')
                    ->label('Jenjang')
                    ->options([
                        'PAUD' => 'PAUD',
                        'TK' => 'TK',
                        'SD' => 'SD',
                        'SMP' => 'SMP',
                        'SMA' => 'SMA',
                        'SMK' => 'SMK',
                        'Perguruan Tinggi' => 'Perguruan Tinggi',
                    ])
                    ->nullable(),
                TextInput::make('lat')
                    ->label('Latitude')
                    ->numeric() // Hanya menerima angka
                    ->nullable(),
                TextInput::make('lng')
                    ->label('Longitude')
                    ->numeric() // Hanya menerima angka
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('npsn')
                    ->label('NPSN')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nama')
                    ->label('Nama Sekolah')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->searchable()
                    ->limit(50), // Batasi panjang teks
                TextColumn::make('desa')
                    ->label('Desa')
                    ->searchable(),
                TextColumn::make('kecamatan')
                    ->label('Kecamatan')
                    ->searchable(),
                TextColumn::make('jenjang')
                    ->label('Jenjang')
                    ->searchable(),
                TextColumn::make('lat')
                    ->label('Latitude')
                    ->numeric(),
                TextColumn::make('lng')
                    ->label('Longitude')
                    ->numeric(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(), // Filter untuk soft delete
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListSekolahs::route('/'),
            'create' => Pages\CreateSekolah::route('/create'),
            'edit' => Pages\EditSekolah::route('/{record}/edit'),
        ];
    }
}

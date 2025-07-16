<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserMobileResource\Pages;
use App\Filament\Resources\UserMobileResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use App\Models\Register;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Pages\ListRecords;

class UserMobileResource extends Resource
{
    protected static ?string $model = \App\Models\Register::class;

    protected static ?string $navigationGroup = 'Management Data';
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $label = 'Pengguna';
protected static ?string $pluralLabel = 'Pengguna';

public static function getNavigationBadge(): ?string
    {
        return (string) Register::count();
    }
    public static function form(Form $form): Form
{
    return $form->schema([
        Forms\Components\TextInput::make('username')
            ->required()
            ->maxLength(255),
        Forms\Components\TextInput::make('email')
            ->email()
            ->required()
            ->maxLength(255),
        Forms\Components\TextInput::make('nama_lengkap')
            ->label('Nama Lengkap')
            ->required()
            ->maxLength(255),
        Forms\Components\TextInput::make('nik_ktp')
            ->label('NIK KTP')
            ->required()
            ->maxLength(20),
        Forms\Components\TextInput::make('activation_key')
            ->label('Activation Key')
            ->disabled(), // Tidak bisa diedit
    ]);
}


    public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('username')->searchable()->sortable(),
            TextColumn::make('email')->searchable(),
            TextColumn::make('nama_lengkap')->label('Nama Lengkap'),
            TextColumn::make('nik_ktp')->label('NIK KTP'),
            TextColumn::make('activation_key')->label('Activation Key'),
            TextColumn::make('created_at')->label('Tanggal Daftar')->dateTime(),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
}
protected function getHeaderActions(): array
    {
        return []; // Ini akan menghilangkan tombol "Create"
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
            'index' => Pages\ListUserMobiles::route('/'),
            'create' => Pages\CreateUserMobile::route('/create'),
            'edit' => Pages\EditUserMobile::route('/{record}/edit'),
        ];
    }
}

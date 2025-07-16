<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WisataResource\Pages;
use App\Models\Wisata;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms\Set;

class WisataResource extends Resource
{
    protected static ?string $model = Wisata::class;
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'Management Data';
    protected static ?string $label = 'Wisata';
    protected static ?string $pluralLabel = 'Wisata';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('nama')->required()->maxLength(255),
                    TextInput::make('kategori')->maxLength(255)->placeholder('Contoh: Pantai, Gunung, Museum'),
                ]),

                Textarea::make('deskripsi')
                    ->rows(4)
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->image()
                    ->directory('wisata_images')
                    ->disk('public')
                    ->nullable()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),

                TextInput::make('alamat')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Grid::make(2)->schema([
                    TextInput::make('website')->url()->maxLength(255)->nullable(),
                    TextInput::make('no_telp')->tel()->maxLength(255)->nullable(),
                ]),

                Grid::make(2)->schema([
                    TextInput::make('latitude')->numeric()->nullable(),
                    TextInput::make('longitude')->numeric()->nullable(),
                ]),

                Grid::make(2)->schema([
                    TextInput::make('jam_buka')->placeholder('08:00')->maxLength(255)->nullable(),
                    TextInput::make('jam_tutup')->placeholder('22:00')->maxLength(255)->nullable(),
                ]),

                Grid::make(2)->schema([
                    TextInput::make('prioritas')
                        ->numeric()
                        ->required(),

                    Toggle::make('checkout')
                        ->label('Checkout (Aktifkan untuk tampil)')
                        ->default(false),
                ]),

                Grid::make(3)->schema([
                    TextInput::make('child_price')
                        ->numeric()
                        ->label('Harga Anak')
                        ->required(),

                    TextInput::make('adult_price')
                        ->numeric()
                        ->label('Harga Dewasa')
                        ->required(),

                    TextInput::make('kuota')
                        ->numeric()
                        ->label('Kuota Tiket')
                        ->required()
                        ->minValue(0),
                ]),
                Map::make('alamat')
                        ->label('Pilih Lokasi')
                        ->defaultZoom(15)
                        ->draggable()
                        ->clickable()
                        ->autocomplete('id="autocomplete"')
                        ->height('400px')
                        ->columnSpanFull()
                        ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),

                ImageColumn::make('image')
                    ->disk('public')
                    ->square()
                    ->defaultImageUrl(url('/images/placeholder.png'))
                    ->label('Foto'),

                TextColumn::make('nama')->searchable()->sortable(),
                TextColumn::make('kategori')->searchable()->sortable(),
                TextColumn::make('alamat')->searchable()->limit(50),
                TextColumn::make('deskripsi')->searchable()->limit(50),
                TextColumn::make('no_telp')->searchable(),

                TextColumn::make('jam_buka')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('jam_tutup')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('child_price')
                    ->label('Harga Anak')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),

                TextColumn::make('adult_price')
                    ->label('Harga Dewasa')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),

                TextColumn::make('kuota') // ← Tambahkan ini
                    ->label('Kuota Tiket')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('prioritas')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('checkout')
                    ->boolean()
                    ->label('Checkout')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Wisata::count();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWisatas::route('/'),
            'create' => Pages\CreateWisata::route('/create'),
            'edit' => Pages\EditWisata::route('/{record}/edit'),
        ];
    }
}

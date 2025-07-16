<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HotelResource\Pages;
use App\Models\Hotel;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Dotswan\MapPicker\Fields\Map;
use Filament\Forms\Set;

class HotelResource extends Resource
{
    protected static ?string $model = Hotel::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Management Data';
    protected static ?string $label = 'Hotel';
    protected static ?string $pluralLabel = 'Hotel';

    public static function getNavigationBadge(): ?string
    {
        return (string) Hotel::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('nama')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('kategori')
                        ->maxLength(255),
                ]),
                Textarea::make('deskripsi')
                    ->rows(4)
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Upload Gambar')
                    ->image()
                    ->directory('hotel_photos')
                    ->disk('public')
                    ->visibility('public')
                    ->nullable(),

                TextInput::make('alamat')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),



                Grid::make(2)->schema([
                    TextInput::make('website')
                        ->url()
                        ->maxLength(255)
                        ->nullable(),
                    TextInput::make('no_telp')
                        ->tel()
                        ->maxLength(255)
                        ->nullable(),
                ]),

                Grid::make(2)->schema([
                    TextInput::make('latitude')
                        ->numeric()
                        ->nullable(),
                    TextInput::make('longitude')
                        ->numeric()
                        ->nullable(),
                ]),

                Grid::make(2)->schema([
                    TextInput::make('jam_buka')
                        ->placeholder('08:00')
                        ->maxLength(255)
                        ->nullable(),
                    TextInput::make('jam_tutup')
                        ->placeholder('22:00')
                        ->maxLength(255)
                        ->nullable(),
                ]),

                Map::make('location')
                    ->label('Pilih Lokasi Hotel')
                    ->columnSpanFull()
                    ->defaultLocation(latitude: -6.90389, longitude: 107.61861) // Contoh: Bandung
                    ->draggable(true)
                    ->clickable(true)
                    ->zoom(15)
                    ->tilesUrl("https://tile.openstreetmap.de/{z}/{x}/{y}.png")
                    ->showMarker(true)
                    ->showZoomControl(true)
                    ->showFullscreenControl(true)
                    ->geoMan(true)
                    ->geoManEditable(true)
                    ->drawMarker(true)
                    ->drawPolygon(true)
                    ->editPolygon(true)
                    ->deleteLayer(true)
                    ->extraStyles([
                        'min-height: 500px',
                        'border-radius: 12px',
                    ])
                    ->afterStateUpdated(function (Set $set, ?array $state): void {
                        $set('latitude', $state['lat']);
                        $set('longitude', $state['lng']);
                        $set('geojson', json_encode($state['geojson'] ?? null));
                    })
                    ->afterStateHydrated(function ($state, $record, Set $set): void {
                        if ($record) {
                            $set('location', [
                                'lat' => $record->latitude,
                                'lng' => $record->longitude,
                                'geojson' => json_decode($record->geojson ?? '{}'),
                            ]);
                        }
                    }),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
                ImageColumn::make('image')->square(),
                TextColumn::make('nama')->sortable()->searchable(),
                TextColumn::make('alamat')->limit(50)->searchable(),
                TextColumn::make('deskripsi')->limit(50)->searchable(),
                TextColumn::make('no_telp')->searchable(),
                TextColumn::make('jam_buka')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('jam_tutup')->toggleable(isToggledHiddenByDefault: true),
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHotels::route('/'),
            'create' => Pages\CreateHotel::route('/create'),
            'edit' => Pages\EditHotel::route('/{record}/edit'),
        ];
    }
}

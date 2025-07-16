<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DokterResource\Pages;
use App\Filament\Resources\DokterResource\RelationManagers;
use App\Models\Dokter;
use Filament\Forms;
use Filament\Forms\Form;
use App\Models\User; // <-- PASTIKAN INI ADA DAN BENAR
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Hash; // Untuk hashing password

class DokterResource extends Resource
{
    protected static ?string $model = Dokter::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Management Data';
    protected static ?string $label = 'Dokter';
    protected static ?string $pluralLabel = 'Dokter';
    public static function getNavigationBadge(): ?string
    {
        return (string) Dokter::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('id_user')
                    ->label('User Terkait')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('nomor_str')
                    ->label('Nomor STR')
                    ->required()
                    ->unique(ignoreRecord: true) // Nomor STR harus unik, abaikan record saat update
                    ->maxLength(255),
                TextInput::make('nama')
                    ->label('Nama Dokter')
                    ->required()
                    ->maxLength(255),
                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->unique(ignoreRecord: true) // Username harus unik, abaikan record saat update
                    ->maxLength(255),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state)) // Hash password saat disimpan
                    ->dehydrated(fn (?string $state): bool => filled($state)) // Hanya dehydrate jika ada input
                    ->required(fn (string $operation): bool => $operation === 'create') // Wajib saat membuat, opsional saat update
                    ->maxLength(255),
                TextInput::make('keahlian')
                    ->label('Keahlian')
                    ->maxLength(255)
                    ->nullable(),
                TextInput::make('handphone')
                    ->label('Nomor Handphone')
                    ->tel() // Tipe input telepon
                    ->maxLength(255)
                    ->nullable(),
                TextInput::make('unit_kerja')
                    ->label('Unit Kerja')
                    ->maxLength(255)
                    ->nullable(),
                TextInput::make('pengalaman')
                    ->label('Pengalaman (Tahun)')
                    ->numeric() // Hanya menerima angka
                    ->nullable(),
                FileUpload::make('foto')
                    ->image()
                    ->directory('dokter_photos') // Folder penyimpanan foto dokter
                    ->disk('public')
                    ->nullable()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(2048), // Maksimal 2MB
                // device_token tidak perlu di form karena biasanya diisi dari aplikasi klien
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                ImageColumn::make('foto')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png')), // Gambar placeholder jika tidak ada foto
                TextColumn::make('user.name') // Menampilkan nama user terkait
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nomor_str')
                    ->label('Nomor STR')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nama')
                    ->label('Nama Dokter')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('username')
                    ->label('Username')
                    ->searchable(),
                TextColumn::make('keahlian')
                    ->label('Keahlian')
                    ->searchable(),
                TextColumn::make('handphone')
                    ->label('Handphone')
                    ->searchable(),
                TextColumn::make('unit_kerja')
                    ->label('Unit Kerja')
                    ->searchable(),
                TextColumn::make('pengalaman')
                    ->label('Pengalaman')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('device_token')
                    ->label('Device Token')
                    ->toggleable(isToggledHiddenByDefault: true) // Sembunyikan secara default
                    ->limit(30),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('last_update')
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
            'index' => Pages\ListDokters::route('/'),
            'create' => Pages\CreateDokter::route('/create'),
            'edit' => Pages\EditDokter::route('/{record}/edit'),
        ];
    }
}

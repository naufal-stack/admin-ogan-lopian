<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InformasiPentingResource\Pages;
use App\Filament\Resources\InformasiPentingResource\RelationManagers;
use App\Models\InformasiPenting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select; // Untuk memilih user
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use App\Models\User;

class InformasiPentingResource extends Resource
{
    protected static ?string $model = InformasiPenting::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationGroup = 'Management Data';
protected static ?string $label = 'Informasi Penting';
protected static ?string $pluralLabel = 'Informasi Penting';
    public static function getNavigationBadge(): ?string
    {
        return (string) InformasiPenting::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('id_user')
                    ->label('User')
                    ->options(User::all()->pluck('name', 'id')) // Mengambil nama user dari tabel users
                    ->searchable()
                    ->required(),
                TextInput::make('name')
                    ->label('Judul Informasi')
                    ->required()
                    ->maxLength(255),
                Textarea::make('content')
                    ->label('Isi Informasi')
                    ->rows(5)
                    ->required()
                    ->columnSpanFull(),

                // Menggunakan FileUpload untuk gambar, disimpan ke direktori 'informasi_images'
                FileUpload::make('image')
                    ->image() // Hanya menerima file gambar
                    ->directory('informasi_images') // Gambar akan disimpan di storage/app/public/informasi_images
                    ->disk('public') // Secara eksplisit menyatakan penggunaan disk 'public'
                    ->nullable()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name') // Menampilkan nama user dari relasi
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Judul Informasi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('content')
                    ->label('Isi Informasi')
                    ->searchable()
                    ->limit(70), // Batasi panjang teks
                ImageColumn::make('image') // Menampilkan gambar dari storage
                    ->disk('public') // Menentukan disk tempat gambar disimpan
                    ->square() // Membuat gambar kotak
                    ->defaultImageUrl(url('/images/placeholder.png')), // Gambar placeholder jika tidak ada gambar
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
                Tables\Actions\RestoreAction::make(), // Untuk mengembalikan data yang di-soft delete
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(), // Menghapus permanen
                    Tables\Actions\RestoreBulkAction::make(), // Mengembalikan banyak data
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
            'index' => Pages\ListInformasiPentings::route('/'),
            'create' => Pages\CreateInformasiPenting::route('/create'),
            'edit' => Pages\EditInformasiPenting::route('/{record}/edit'),
        ];
    }
}

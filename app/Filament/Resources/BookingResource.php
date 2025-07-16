<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Daftar Pemesanan Tiket';
    protected static ?string $navigationGroup = 'Management Tiket';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_code')->label('Kode Booking')->searchable(),
                TextColumn::make('pengunjung')->label('Nama Pengunjung')->searchable(),
                TextColumn::make('nama_wisata')->label('Nama Wisata')->searchable(),
                TextColumn::make('tanggal')->label('Tanggal')->date(),
                TextColumn::make('qty_dewasa')->label('Dewasa'),
                TextColumn::make('qty_anak')->label('Anak'),
                TextColumn::make('total_price')->label('Total Harga')->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                TextColumn::make('status')->label('Status')->badge()->color(fn (string $state) => match ($state) {
                    'pending' => 'warning',
                    'confirmed' => 'success',
                    'cancelled' => 'danger',
                    default => 'gray',
                }),
                TextColumn::make('payment_status')->label('Pembayaran')->badge()->color(fn (string $state) => match ($state) {
                    'unpaid' => 'gray',
                    'paid' => 'success',
                }),
                TextColumn::make('created_at')->label('Dipesan Pada')->dateTime(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Action::make('Lihat Tiket')
        ->icon('heroicon-o-eye')
        ->modalSubmitAction(false) // HILANGKAN tombol Submit
        ->modalHeading('Preview Tiket PDF')
        ->modalContent(function ($record) {
            return view('filament.admin.booking-modal', ['record' => $record]);
        }),
                // Tables\Actions\EditAction::make(), // ❌ sudah dihapus
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            // 'edit' => Pages\EditBooking::route('/{record}/edit'), // ❌ nonaktifkan/hapus
            // 'view' => Pages\ViewBooking::route('/{record}'),
        ];
    }
}

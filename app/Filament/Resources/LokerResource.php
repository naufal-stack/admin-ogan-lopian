<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LokerResource\Pages;
use App\Models\Loker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;

class LokerResource extends Resource
{
    protected static ?string $model = Loker::class;

    protected static ?string $navigationGroup = 'Management Data';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
protected static ?string $label = 'Loker';
protected static ?string $pluralLabel = 'Loker';
    public static function getNavigationBadge(): ?string
    {
        return (string) Loker::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(2)->schema([
                TextInput::make('posisi')->required()->maxLength(255),
                TextInput::make('perusahaan')->required()->maxLength(255),
            ]),
            Textarea::make('deskripsi')->required()->rows(6)->columnSpanFull(),
            FileUpload::make('logo')
                ->image()
                ->directory('loker_logos')
                ->nullable(),
            Grid::make(2)->schema([
                Select::make('pendidikan')
                    ->required()
                    ->options([
                        'SMA/SMK/STM' => 'SMA/SMK/STM',
                        'Diploma' => 'Diploma',
                        'Sarjana (S1)' => 'Sarjana (S1)',
                        'Magister (S2)' => 'Magister (S2)',
                    ])
                    ->native(false),
                TextInput::make('lokasi')->required(),
            ]),
            Grid::make(2)->schema([
                Select::make('tipe_pekerjaan')
                    ->required()
                    ->options([
                        'Kontrak' => 'Kontrak',
                        'Tetap' => 'Tetap',
                        'Freelance' => 'Freelance',
                        'Magang' => 'Magang',
                    ])
                    ->native(false),
                TextInput::make('level_pekerjaan')->required(),
            ]),
            Select::make('kategori')
                ->required()
                ->options([
                    'Retail' => 'Retail',
                    'Teknologi' => 'Teknologi',
                    'Kesehatan' => 'Kesehatan',
                    'Pendidikan' => 'Pendidikan',
                    'Keuangan' => 'Keuangan',
                    'Perbankan' => 'Perbankan',
                    'Transportasi' => 'Transportasi',
                    'Industri' => 'Industri',
                    'Properti' => 'Properti',
                    'Manufaktur' => 'Manufaktur',
                    'Pemerintahan' => 'Pemerintahan',
                    'Perhotelan' => 'Perhotelan',
                    'Pariwisata' => 'Pariwisata',
                    'Media' => 'Media',
                    'E-commerce' => 'E-commerce',
                    'Pertanian' => 'Pertanian',
                    'Perikanan' => 'Perikanan',
                    'Perdagangan' => 'Perdagangan',
                    'Telekomunikasi' => 'Telekomunikasi',
                    'Energi' => 'Energi',
                    'Lainnya' => 'Lainnya',
                ])
                ->native(false),
            TextInput::make('website')->url()->nullable(),
            Grid::make(2)->schema([
                TextInput::make('salary_from')->numeric()->required(),
                TextInput::make('salary_to')->numeric()->required(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->disk('public')
                    ->square()
                    ->defaultImageUrl(url('/images/placeholder.png'))
                    ->label('Foto'),
                TextColumn::make('posisi')->searchable()->sortable(),
                TextColumn::make('perusahaan')->searchable(),
                TextColumn::make('lokasi')->searchable(),
                TextColumn::make('tipe_pekerjaan'),
                TextColumn::make('salary_from')->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                TextColumn::make('salary_to')->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListLokers::route('/'),
            'create' => Pages\CreateLoker::route('/create'),
            'edit' => Pages\EditLoker::route('/{record}/edit'),
        ];
    }
}

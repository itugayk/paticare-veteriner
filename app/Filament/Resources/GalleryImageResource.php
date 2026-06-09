<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryImageResource\Pages;
use App\Models\GalleryImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GalleryImageResource extends Resource
{
    protected static ?string $model = GalleryImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'İçerik Yönetimi';
    protected static ?string $navigationLabel = 'Galeri';
    protected static ?string $modelLabel = 'Görsel';
    protected static ?string $pluralModelLabel = 'Galeri';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\FileUpload::make('image')->label('Görsel')->image()->directory('gallery')->required()->imageEditor()->columnSpanFull(),
            Forms\Components\TextInput::make('title')->label('Başlık'),
            Forms\Components\Select::make('category')->label('Kategori')->options([
                'klinik' => 'Klinik', 'mutlu-dostlar' => 'Mutlu Dostlar', 'ekip' => 'Ekip',
            ]),
            Forms\Components\TextInput::make('sort_order')->label('Sıra')->numeric()->default(0),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('')->height(56)->width(80),
                Tables\Columns\TextColumn::make('title')->label('Başlık')->searchable()->placeholder('—'),
                Tables\Columns\TextColumn::make('category')->label('Kategori')->badge(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleryImages::route('/'),
            'create' => Pages\CreateGalleryImage::route('/create'),
            'edit' => Pages\EditGalleryImage::route('/{record}/edit'),
        ];
    }
}

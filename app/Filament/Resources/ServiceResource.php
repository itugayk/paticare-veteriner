<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = 'İçerik Yönetimi';
    protected static ?string $navigationLabel = 'Hizmetler';
    protected static ?string $modelLabel = 'Hizmet';
    protected static ?string $pluralModelLabel = 'Hizmetler';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->columns(2)->schema([
                Forms\Components\TextInput::make('name')->label('Hizmet adı')->required()->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),
                Forms\Components\Select::make('icon')->label('İkon')->options([
                    'stethoscope' => 'Stetoskop', 'syringe' => 'Şırınga', 'scalpel' => 'Neşter',
                    'tooth' => 'Diş', 'ambulance' => 'Ambulans', 'scissors' => 'Makas', 'bag' => 'Çanta', 'paw' => 'Pati',
                ])->required(),
                Forms\Components\Select::make('color')->label('Renk')->options(['paw' => 'Turkuaz', 'peach' => 'Şeftali'])->required(),
                Forms\Components\TextInput::make('excerpt')->label('Kısa açıklama')->columnSpanFull(),
                Forms\Components\Textarea::make('description')->label('Detaylı açıklama')->rows(4)->columnSpanFull(),
                Forms\Components\TextInput::make('price_from')->label('Başlangıç ücreti')->placeholder('450₺'),
                Forms\Components\TextInput::make('duration_minutes')->label('Süre (dk)')->numeric()->default(30),
                Forms\Components\Toggle::make('is_emergency')->label('Acil hizmet'),
                Forms\Components\Toggle::make('is_featured')->label('Ana sayfada öne çıkar')->default(true),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                Forms\Components\TextInput::make('sort_order')->label('Sıra')->numeric()->default(0),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Hizmet')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('price_from')->label('Ücret')->placeholder('—'),
                Tables\Columns\TextColumn::make('duration_minutes')->label('Süre')->suffix(' dk'),
                Tables\Columns\IconColumn::make('is_emergency')->label('Acil')->boolean(),
                Tables\Columns\IconColumn::make('is_featured')->label('Öne çıkan')->boolean(),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}

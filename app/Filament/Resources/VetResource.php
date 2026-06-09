<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VetResource\Pages;
use App\Models\Vet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class VetResource extends Resource
{
    protected static ?string $model = Vet::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'İçerik Yönetimi';
    protected static ?string $navigationLabel = 'Hekimler';
    protected static ?string $modelLabel = 'Hekim';
    protected static ?string $pluralModelLabel = 'Hekimler';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->columns(2)->schema([
                Forms\Components\TextInput::make('name')->label('Ad Soyad')->required()->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('title')->label('Ünvan')->placeholder('Veteriner Hekim'),
                Forms\Components\TextInput::make('specialty')->label('Uzmanlık'),
                Forms\Components\TextInput::make('experience_years')->label('Deneyim (yıl)')->numeric()->default(0),
                Forms\Components\TextInput::make('sort_order')->label('Sıra')->numeric()->default(0),
                Forms\Components\Textarea::make('bio')->label('Biyografi')->rows(3)->columnSpanFull(),
                Forms\Components\TagsInput::make('focus_areas')->label('İlgi alanları')->columnSpanFull(),
                Forms\Components\FileUpload::make('photo')->label('Fotoğraf')->image()->directory('vets')->imageEditor()->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('photo')->label('')->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=Dr&background=ffe6d9&color=c8421a'),
                Tables\Columns\TextColumn::make('name')->label('Ad')->searchable()->weight('bold')->description(fn ($record) => $record->title),
                Tables\Columns\TextColumn::make('specialty')->label('Uzmanlık'),
                Tables\Columns\TextColumn::make('experience_years')->label('Deneyim')->suffix(' yıl'),
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
            'index' => Pages\ListVets::route('/'),
            'create' => Pages\CreateVet::route('/create'),
            'edit' => Pages\EditVet::route('/{record}/edit'),
        ];
    }
}

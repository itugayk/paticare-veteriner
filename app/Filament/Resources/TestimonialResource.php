<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Pet;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'İçerik Yönetimi';
    protected static ?string $navigationLabel = 'Yorumlar';
    protected static ?string $modelLabel = 'Yorum';
    protected static ?string $pluralModelLabel = 'Yorumlar';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->columns(2)->schema([
            Forms\Components\TextInput::make('author')->label('Yorum sahibi')->required(),
            Forms\Components\TextInput::make('pet_name')->label('Dost adı'),
            Forms\Components\Select::make('pet_species')->label('Tür')->options(Pet::SPECIES),
            Forms\Components\Select::make('rating')->label('Puan')->options([1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'])->default(5),
            Forms\Components\Textarea::make('body')->label('Yorum')->rows(4)->required()->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('author')->label('Yazan')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('pet_name')->label('Dost')->placeholder('—'),
                Tables\Columns\TextColumn::make('rating')->label('Puan')->formatStateUsing(fn ($state) => str_repeat('⭐', (int) $state)),
                Tables\Columns\TextColumn::make('body')->label('Yorum')->limit(60),
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}

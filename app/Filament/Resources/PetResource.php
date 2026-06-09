<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PetResource\Pages;
use App\Filament\Resources\PetResource\RelationManagers;
use App\Models\Pet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PetResource extends Resource
{
    protected static ?string $model = Pet::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $navigationGroup = 'Randevular & Hastalar';
    protected static ?string $navigationLabel = 'Evcil Hayvanlar';
    protected static ?string $modelLabel = 'Evcil Hayvan';
    protected static ?string $pluralModelLabel = 'Evcil Hayvanlar';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->columns(2)->schema([
                Forms\Components\Select::make('user_id')->label('Sahip')
                    ->relationship('user', 'name')->searchable()->preload()->required(),
                Forms\Components\TextInput::make('name')->label('Adı')->required(),
                Forms\Components\Select::make('species')->label('Tür')->options(Pet::SPECIES)->required(),
                Forms\Components\TextInput::make('breed')->label('Irk'),
                Forms\Components\Select::make('gender')->label('Cinsiyet')
                    ->options(['erkek' => 'Erkek', 'disi' => 'Dişi']),
                Forms\Components\DatePicker::make('birth_date')->label('Doğum tarihi')->native(false),
                Forms\Components\TextInput::make('weight_kg')->label('Ağırlık (kg)')->numeric()->step(0.1),
                Forms\Components\TextInput::make('color')->label('Renk'),
                Forms\Components\TextInput::make('microchip_no')->label('Mikroçip no'),
                Forms\Components\Toggle::make('is_neutered')->label('Kısırlaştırıldı'),
                Forms\Components\FileUpload::make('photo')->label('Fotoğraf')->image()->directory('pets')->imageEditor()->columnSpanFull(),
                Forms\Components\Textarea::make('notes')->label('Notlar')->rows(3)->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')->label('')->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=P&background=d6f2ed&color=1c7269'),
                Tables\Columns\TextColumn::make('name')->label('Adı')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('species')->label('Tür')->badge()
                    ->formatStateUsing(fn ($state) => Pet::SPECIES[$state] ?? $state),
                Tables\Columns\TextColumn::make('breed')->label('Irk')->placeholder('—')->toggleable(),
                Tables\Columns\TextColumn::make('user.name')->label('Sahip')->searchable(),
                Tables\Columns\TextColumn::make('vaccinations_count')->label('Aşı')->counts('vaccinations')->badge()->color('info'),
                Tables\Columns\IconColumn::make('is_neutered')->label('Kısır')->boolean()->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('species')->label('Tür')->options(Pet::SPECIES),
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\VaccinationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPets::route('/'),
            'create' => Pages\CreatePet::route('/create'),
            'edit' => Pages\EditPet::route('/{record}/edit'),
        ];
    }
}

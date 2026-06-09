<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VaccinationResource\Pages;
use App\Models\Vaccination;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VaccinationResource extends Resource
{
    protected static ?string $model = Vaccination::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationGroup = 'Randevular & Hastalar';
    protected static ?string $navigationLabel = 'Aşı Takvimi';
    protected static ?string $modelLabel = 'Aşı';
    protected static ?string $pluralModelLabel = 'Aşı Kayıtları';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->columns(2)->schema([
            Forms\Components\Select::make('pet_id')->label('Dost')
                ->relationship('pet', 'name')->searchable()->preload()->required(),
            Forms\Components\Select::make('vet_id')->label('Uygulayan hekim')
                ->relationship('vet', 'name')->searchable()->preload(),
            Forms\Components\TextInput::make('name')->label('Aşı adı')->required(),
            Forms\Components\TextInput::make('batch_no')->label('Lot no'),
            Forms\Components\DatePicker::make('administered_at')->label('Uygulama tarihi')->native(false),
            Forms\Components\DatePicker::make('next_due_at')->label('Sonraki tarih')->native(false),
            Forms\Components\Textarea::make('notes')->label('Notlar')->rows(2)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('next_due_at', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('pet.name')->label('Dost')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('name')->label('Aşı')->searchable(),
                Tables\Columns\TextColumn::make('administered_at')->label('Uygulandı')->date('d M Y')->placeholder('—'),
                Tables\Columns\TextColumn::make('next_due_at')->label('Sonraki')->date('d M Y')->placeholder('—')->sortable()
                    ->badge()->color(fn ($record) => match ($record->reminder_status) {
                        'overdue' => 'danger', 'due_soon' => 'warning', 'ok' => 'success', default => 'gray',
                    })
                    ->formatStateUsing(fn ($state, $record) => $state?->format('d M Y') . match ($record->reminder_status) {
                        'overdue' => ' (gecikti)', 'due_soon' => ' (yaklaşıyor)', default => '',
                    }),
                Tables\Columns\TextColumn::make('vet.name')->label('Hekim')->placeholder('—')->toggleable(),
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
            'index' => Pages\ListVaccinations::route('/'),
            'create' => Pages\CreateVaccination::route('/create'),
            'edit' => Pages\EditVaccination::route('/{record}/edit'),
        ];
    }
}

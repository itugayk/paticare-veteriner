<?php

namespace App\Filament\Resources\PetResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class VaccinationsRelationManager extends RelationManager
{
    protected static string $relationship = 'vaccinations';
    protected static ?string $title = 'Aşı Kayıtları';
    protected static ?string $modelLabel = 'aşı';

    public function form(Form $form): Form
    {
        return $form->columns(2)->schema([
            Forms\Components\TextInput::make('name')->label('Aşı adı')->required()->columnSpanFull(),
            Forms\Components\Select::make('vet_id')->label('Uygulayan hekim')
                ->relationship('vet', 'name')->searchable()->preload(),
            Forms\Components\TextInput::make('batch_no')->label('Lot no'),
            Forms\Components\DatePicker::make('administered_at')->label('Uygulama tarihi')->native(false),
            Forms\Components\DatePicker::make('next_due_at')->label('Sonraki tarih')->native(false),
            Forms\Components\Textarea::make('notes')->label('Notlar')->rows(2)->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->defaultSort('next_due_at', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Aşı')->weight('bold'),
                Tables\Columns\TextColumn::make('administered_at')->label('Uygulandı')->date('d M Y')->placeholder('—'),
                Tables\Columns\TextColumn::make('next_due_at')->label('Sonraki')->date('d M Y')->placeholder('—')
                    ->badge()->color(fn ($record) => match ($record->reminder_status) {
                        'overdue' => 'danger', 'due_soon' => 'warning', 'ok' => 'success', default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('vet.name')->label('Hekim')->placeholder('—')->toggleable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Aşı Ekle'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}

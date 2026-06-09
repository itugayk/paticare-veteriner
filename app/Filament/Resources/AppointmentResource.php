<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use App\Models\Pet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Randevular & Hastalar';
    protected static ?string $navigationLabel = 'Randevular';
    protected static ?string $modelLabel = 'Randevu';
    protected static ?string $pluralModelLabel = 'Randevular';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Randevu Detayı')->columns(2)->schema([
                Forms\Components\Select::make('service_id')->label('Hizmet')
                    ->relationship('service', 'name')->searchable()->preload(),
                Forms\Components\Select::make('vet_id')->label('Hekim')
                    ->relationship('vet', 'name')->searchable()->preload()->placeholder('Fark etmez'),
                Forms\Components\DatePicker::make('date')->label('Tarih')->required()->native(false),
                Forms\Components\TextInput::make('time_slot')->label('Saat')->required()->placeholder('14:30'),
                Forms\Components\Select::make('status')->label('Durum')->required()
                    ->options(Appointment::STATUSES)->default('pending'),
            ]),
            Forms\Components\Section::make('Sahip & Dost Bilgisi')->columns(2)->schema([
                Forms\Components\Select::make('user_id')->label('Kayıtlı sahip')
                    ->relationship('user', 'name')->searchable()->preload()->placeholder('Misafir'),
                Forms\Components\Select::make('pet_id')->label('Kayıtlı dost')
                    ->relationship('pet', 'name')->searchable()->preload()->placeholder('—'),
                Forms\Components\TextInput::make('owner_name')->label('Sahip adı')->required(),
                Forms\Components\TextInput::make('owner_phone')->label('Telefon')->tel()->required(),
                Forms\Components\TextInput::make('owner_email')->label('E-posta')->email(),
                Forms\Components\TextInput::make('pet_name')->label('Dost adı'),
                Forms\Components\Select::make('pet_species')->label('Tür')->options(Pet::SPECIES),
                Forms\Components\Textarea::make('notes')->label('Notlar')->columnSpanFull()->rows(3),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('date', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('date')->label('Tarih')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('time_slot')->label('Saat')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('owner_name')->label('Sahip')->searchable()->description(fn ($record) => $record->owner_phone),
                Tables\Columns\TextColumn::make('pet_name')->label('Dost')->searchable()
                    ->formatStateUsing(fn ($state, $record) => trim(($state ?? '—') . ' · ' . (Pet::SPECIES[$record->pet_species] ?? ''), ' ·')),
                Tables\Columns\TextColumn::make('service.name')->label('Hizmet')->badge()->color('info'),
                Tables\Columns\TextColumn::make('vet.name')->label('Hekim')->placeholder('Fark etmez')->toggleable(),
                Tables\Columns\TextColumn::make('status')->label('Durum')->badge()
                    ->formatStateUsing(fn ($state) => Appointment::STATUSES[$state] ?? $state)
                    ->color(fn ($state) => match ($state) {
                        'confirmed' => 'success', 'completed' => 'gray',
                        'cancelled' => 'danger', default => 'warning',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('Durum')->options(Appointment::STATUSES),
                Tables\Filters\SelectFilter::make('vet')->label('Hekim')->relationship('vet', 'name'),
            ])
            ->actions([
                Tables\Actions\Action::make('confirm')->label('Onayla')->icon('heroicon-m-check')->color('success')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->action(fn ($record) => $record->update(['status' => 'confirmed'])),
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}

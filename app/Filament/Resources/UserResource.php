<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Randevular & Hastalar';
    protected static ?string $navigationLabel = 'Sahipler';
    protected static ?string $modelLabel = 'Kullanıcı';
    protected static ?string $pluralModelLabel = 'Sahipler';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->columns(2)->schema([
            Forms\Components\TextInput::make('name')->label('Ad Soyad')->required(),
            Forms\Components\TextInput::make('email')->label('E-posta')->email()->required()->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('phone')->label('Telefon')->tel(),
            Forms\Components\Select::make('role')->label('Rol')->options([
                'owner' => 'Evcil Hayvan Sahibi', 'admin' => 'Yönetici',
            ])->default('owner')->required(),
            Forms\Components\TextInput::make('password')->label('Şifre')->password()
                ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                ->dehydrated(fn ($state) => filled($state))
                ->required(fn (string $operation) => $operation === 'create')
                ->helperText('Düzenlerken boş bırakırsanız değişmez.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Ad')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('email')->label('E-posta')->searchable()->icon('heroicon-m-envelope'),
                Tables\Columns\TextColumn::make('phone')->label('Telefon')->placeholder('—'),
                Tables\Columns\TextColumn::make('role')->label('Rol')->badge()
                    ->formatStateUsing(fn ($state) => $state === 'admin' ? 'Yönetici' : 'Sahip')
                    ->color(fn ($state) => $state === 'admin' ? 'danger' : 'success'),
                Tables\Columns\TextColumn::make('pets_count')->label('Dost')->counts('pets')->badge()->color('info'),
                Tables\Columns\TextColumn::make('created_at')->label('Kayıt')->date('d M Y')->sortable()->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')->label('Rol')->options(['owner' => 'Sahip', 'admin' => 'Yönetici']),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

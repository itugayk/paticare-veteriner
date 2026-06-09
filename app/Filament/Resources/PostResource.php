<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'İçerik Yönetimi';
    protected static ?string $navigationLabel = 'Blog Yazıları';
    protected static ?string $modelLabel = 'Yazı';
    protected static ?string $pluralModelLabel = 'Blog Yazıları';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->columns(2)->schema([
                Forms\Components\TextInput::make('title')->label('Başlık')->required()->columnSpanFull()->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('category')->label('Kategori')->default('Bakım Rehberi'),
                Forms\Components\TextInput::make('author')->label('Yazar'),
                Forms\Components\TextInput::make('read_minutes')->label('Okuma süresi (dk)')->numeric()->default(4),
                Forms\Components\Textarea::make('excerpt')->label('Özet')->rows(2)->columnSpanFull(),
                Forms\Components\FileUpload::make('cover')->label('Kapak görseli')->image()->directory('posts')->imageEditor()->columnSpanFull(),
                Forms\Components\RichEditor::make('body')->label('İçerik')->columnSpanFull(),
                Forms\Components\Toggle::make('is_published')->label('Yayında')->default(true),
                Forms\Components\DateTimePicker::make('published_at')->label('Yayın tarihi')->default(now())->native(false),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('cover')->label('')->height(40)->width(64),
                Tables\Columns\TextColumn::make('title')->label('Başlık')->searchable()->limit(45)->weight('bold'),
                Tables\Columns\TextColumn::make('category')->label('Kategori')->badge()->color('info'),
                Tables\Columns\TextColumn::make('published_at')->label('Yayın')->date('d M Y')->sortable(),
                Tables\Columns\IconColumn::make('is_published')->label('Yayında')->boolean(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}

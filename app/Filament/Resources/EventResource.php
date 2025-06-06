<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Traits\HasTenantSelect;

class EventResource extends Resource
{
    use HasTenantSelect;

    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Site public';
    
    protected static ?string $modelLabel = 'Événement';
    protected static ?string $pluralModelLabel = 'Événements';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                static::getTenantFormField(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Titre'),
                
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->label('Date'),
                
                Forms\Components\TextInput::make('time')
                    ->required()
                    ->maxLength(255)
                    ->label('Heure'),
                
                Forms\Components\TextInput::make('location')
                    ->required()
                    ->maxLength(255)
                    ->label('Lieu'),
                
                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->label('Description'),
                
                Forms\Components\Toggle::make('members_only')
                    ->label('Visible uniquement par les membres')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tenant.name')
                    ->label('Organisation')
                    ->searchable()
                    ->visible(fn () => auth()->user()->hasRole('super_admin')),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Titre'),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable()
                    ->label('Date'),
                Tables\Columns\TextColumn::make('time')
                    ->label('Heure'),
                Tables\Columns\TextColumn::make('location')
                    ->label('Lieu'),
                Tables\Columns\IconColumn::make('members_only')
                    ->boolean()
                    ->label('Privé'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tenant')
                    ->label('Organisation')
                    ->relationship('tenant', 'name')
                    ->multiple()
                    ->preload()
                    ->visible(fn () => auth()->user()->hasRole('super_admin')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
} 
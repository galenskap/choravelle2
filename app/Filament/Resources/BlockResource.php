<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlockResource\Pages;
use App\Models\Block;
use App\Enum\BlockTemplatesEnum;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BlockResource extends Resource
{
    protected static ?string $model = Block::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Site public';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(12)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Block name'))
                            ->columnSpanFull()
                            ->required(),
                        TextInput::make('slug')
                            ->label(__('Unique identifier'))
                            ->columnSpan(6)
                            ->required(),
                        Select::make('template')
                            ->label(__('Template'))
                            ->options(BlockTemplatesEnum::class)
                            ->columnSpan(6)
                            ->required()
                            ->live(),
                    ]),
                
                Section::make()
                    ->columns(12)
                    ->schema([
                        TextInput::make('content.title')
                            ->label(__('Title'))
                            ->columnSpanFull(),
                        FileUpload::make('content.image')
                            ->hidden(fn (Get $get) => ($get('template') !== 'banner' && $get('template') !== 'illustration'))
                            ->label(__('Image'))
                            ->columnSpanFull()
                            ->image(),
                        TextInput::make('content.image_alt')
                            ->hidden(fn (Get $get) => $get('template') !== 'illustration')
                            ->label(__('Alternative text'))
                            ->columnSpan(6),
                        Select::make('content.image_position')
                            ->hidden(fn (Get $get) => $get('template') !== 'illustration')
                            ->label(__('Position'))
                            ->options([
                                'left' => __('Left'),
                                'right' => __('Right'),
                            ])
                            ->columnSpan(6),
                        RichEditor::make('content.text')
                            ->hidden(fn (Get $get) => $get('template') === 'cards' || $get('template') === 'icons' || $get('template') === 'agenda-repertoire')
                            ->columnSpanFull()
                            ->label(__('Text')),
                        RichEditor::make('content.agenda')
                            ->hidden(fn (Get $get) => $get('template') !== 'agenda-repertoire')
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bulletList',
                                'bold',
                                'italic',
                                'link',
                                'strike',
                            ])
                            ->label(__('Contenu de l\'agenda')),
                        Section::make()
                            ->hidden(fn (Get $get) => $get('template') !== 'cards')
                            ->label(__('Cards'))
                            ->schema([
                                Repeater::make('content.cards')
                                    ->nullable()
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label(__('Image'))
                                            ->image(),
                                        TextInput::make('title')
                                            ->label(__('Title')),
                                        RichEditor::make('text')
                                            ->label(__('Text')),
                                        TextInput::make('cta.label')
                                            ->label(__('CTA - Label')),
                                        TextInput::make('cta.route')
                                            ->label(__('CTA - Route')),
                                    ]),
                            ]),
                        Section::make()
                            ->hidden(fn (Get $get) => $get('template') !== 'icons')
                            ->label(__('Icons'))
                            ->schema([
                                Repeater::make('content.icons')
                                    ->nullable()
                                    ->schema([
                                        FileUpload::make('icon')
                                            ->label(__('Icon'))
                                            ->image(),
                                        TextInput::make('title')
                                            ->label(__('Title')),
                                        RichEditor::make('text')
                                            ->label(__('Text')),
                                    ]),
                            ]),
                        TextInput::make('content.cta.label')
                            ->hidden(fn (Get $get) => $get('template') === 'icons' || $get('template') === 'agenda-repertoire')
                            ->label(__('CTA - Label'))
                            ->columnSpan(6),
                        TextInput::make('content.cta.route')
                            ->hidden(fn (Get $get) => $get('template') === 'icons' || $get('template') === 'agenda-repertoire')
                            ->label(__('CTA - Route'))
                            ->columnSpan(6),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('template')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlocks::route('/'),
            'create' => Pages\CreateBlock::route('/create'),
            'edit' => Pages\EditBlock::route('/{record}/edit'),
        ];
    }
}

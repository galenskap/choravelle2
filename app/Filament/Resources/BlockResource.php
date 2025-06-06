<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlockResource\Pages;
use App\Models\Block;
use App\Models\BlockTemplate;
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
use App\Filament\Traits\HasTenantSelect;

class BlockResource extends Resource
{
    use HasTenantSelect;

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
                        static::getTenantFormField(),
                        TextInput::make('name')
                            ->label(__('Block name'))
                            ->columnSpanFull()
                            ->required(),
                        TextInput::make('slug')
                            ->label(__('Unique identifier'))
                            ->columnSpan(6)
                            ->required(),
                        Select::make('block_template_id')
                            ->label(__('Template'))
                            ->relationship('template', 'name')
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
                            ->hidden(function (Get $get) {
                                $template = BlockTemplate::find($get('block_template_id'));
                                return !in_array($template?->slug, ['banner', 'illustration']);
                            })
                            ->label(__('Image'))
                            ->columnSpanFull()
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                            ->maxSize(5120), // 5MB max
                        TextInput::make('content.image_alt')
                            ->hidden(function (Get $get) {
                                $template = BlockTemplate::find($get('block_template_id'));
                                return $template?->slug !== 'illustration';
                            })
                            ->label(__('Alternative text'))
                            ->columnSpan(6),
                        Select::make('content.image_position')
                            ->hidden(function (Get $get) {
                                $template = BlockTemplate::find($get('block_template_id'));
                                return $template?->slug !== 'illustration';
                            })
                            ->label(__('Position'))
                            ->options([
                                'left' => __('Left'),
                                'right' => __('Right'),
                            ])
                            ->columnSpan(6),
                        RichEditor::make('content.text')

                            ->hidden(function (Get $get) {
                                $template = BlockTemplate::find($get('block_template_id'));
                                return in_array($template?->slug, ['cards', 'icons', 'agenda-repertoire', 'videos']);
                            })
                            ->columnSpanFull()
                            ->label(__('Text')),
                        Section::make()
                            ->hidden(function (Get $get) {
                                $template = BlockTemplate::find($get('block_template_id'));
                                return $template?->slug !== 'cards';
                            })
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
                            ->hidden(function (Get $get) {
                                $template = BlockTemplate::find($get('block_template_id'));
                                return $template?->slug !== 'icons';
                            })
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
                            ->hidden(function (Get $get) {
                                $template = BlockTemplate::find($get('block_template_id'));
                                return in_array($template?->slug, ['icons', 'agenda-repertoire', 'videos']);
                            })
                            ->label(__('CTA - Label'))
                            ->columnSpan(6),
                        TextInput::make('content.cta.route')
                            ->hidden(function (Get $get) {
                                $template = BlockTemplate::find($get('block_template_id'));
                                return in_array($template?->slug, ['icons', 'agenda-repertoire', 'videos']);
                            })
                            ->label(__('CTA - Route'))
                            ->columnSpan(6),
                    ]),
                Section::make()
                    ->hidden(function (Get $get) {
                        $template = BlockTemplate::find($get('block_template_id'));
                        return $template?->slug !== 'videos';
                    })
                    ->schema([
                        Repeater::make('content.videos')
                            ->label('Vidéos')
                            ->maxItems(3)
                            ->schema([
                                TextInput::make('url')
                                    ->label('URL YouTube')
                                    ->required()
                                    ->url()
                                    ->rules(['regex:/^https?:\/\/(www\.)?youtube\.com\/watch\?v=[\w-]+|https?:\/\/youtu\.be\/[\w-]+/'])
                                    ->helperText('Format: https://www.youtube.com/watch?v=XXXX ou https://youtu.be/XXXX'),
                                TextInput::make('title')
                                    ->label('Légende')
                                    ->required(),
                            ]),
                        TextInput::make('content.channel_url')
                            ->label('URL de la chaîne YouTube')
                            ->url()
                            ->required(),
                    ]),
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('template')
                    ->searchable()
                    ->sortable(),
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

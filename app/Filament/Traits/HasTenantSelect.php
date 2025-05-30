<?php

namespace App\Filament\Traits;

use App\Models\Tenant;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Illuminate\Database\Eloquent\Model;

trait HasTenantSelect
{
    public static function getTenantFormField(): Hidden|Select
    {
        if (auth()->user()->hasRole('super_admin')) {
            return Select::make('tenant_id')
                ->label('Tenant')
                ->options(Tenant::pluck('name', 'id'))
                ->required()
                ->searchable()
                ->preload();
        }

        return Hidden::make('tenant_id')
            ->default(auth()->user()->tenant_id);
    }

    public static function bootHasTenantSelect(): void
    {
        static::creating(function (Model $record) {
            if (!$record->tenant_id) {
                $record->tenant_id = auth()->user()->tenant_id;
            }
        });
    }
} 
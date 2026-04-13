<?php

namespace App\Filament\Resources\RiskRecords\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Section;
use Closure;

class RiskRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->label(__('messages.projects'))
                    ->relationship('project', 'project_name')
                    ->required(),
                TextInput::make('failure_mode')
                    ->label(__('messages.failure_mode'))
                    ->required(),
                TextInput::make('gate_state')
                    ->label(__('messages.gate_state'))
                    ->placeholder('e.g. Prototype, Scale-up'),
                
                TextInput::make('severity')
                    ->label(__('messages.severity'))
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(10)
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (Set $set, Get $get) => self::updateRpn($set, $get)),
                
                TextInput::make('occurrence')
                    ->label(__('messages.occurrence'))
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(10)
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (Set $set, Get $get) => self::updateRpn($set, $get)),
                
                TextInput::make('detectability')
                    ->label(__('messages.detectability'))
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(10)
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (Set $set, Get $get) => self::updateRpn($set, $get)),
                
                TextInput::make('rpn')
                    ->label(__('messages.rpn'))
                    ->numeric()
                    ->readOnly()
                    ->required(),

                TextInput::make('risk_owner')
                    ->label(__('messages.risk_owner'))
                    ->placeholder('e.g. Quality Manager'),
                
                \Filament\Forms\Components\DatePicker::make('review_date')
                    ->label(__('messages.review_date')),

                Textarea::make('mitigation')
                    ->label(__('messages.mitigation'))
                    ->live()
                    ->columnSpanFull(),

                Section::make('Adjusted Risk Assessment')
                    ->schema([
                        TextInput::make('severity_adj')
                            ->label('Adjusted Severity')
                            ->numeric()
                            ->readOnly()
                            ->hidden(fn (?App\Models\RiskRecord $record) => $record === null)
                            ->dehydrated(),
                        
                        TextInput::make('occurrence_adj')
                            ->label('Adjusted Occurrence')
                            ->numeric()
                            ->live()
                            ->minValue(1)
                            ->maxValue(10)
                            ->rules([
                                function (Get $get) {
                                    return function (string $attribute, $value, Closure $fail) use ($get) {
                                        if (($value < $get('occurrence')) && empty(trim($get('mitigation')))) {
                                            $fail('Cannot lower occurrence logic without a clear mitigation plan.');
                                        }
                                    };
                                },
                            ])
                            ->afterStateUpdated(fn (Set $set, Get $get) => self::updateRpnAdj($set, $get)),

                        TextInput::make('detectability_adj')
                            ->label('Adjusted Detectability')
                            ->numeric()
                            ->live()
                            ->minValue(1)
                            ->maxValue(10)
                            ->rules([
                                function (Get $get) {
                                    return function (string $attribute, $value, Closure $fail) use ($get) {
                                        if (($value < $get('detectability')) && empty(trim($get('mitigation')))) {
                                            $fail('Cannot lower detectability without a clear mitigation plan.');
                                        }
                                    };
                                },
                            ])
                            ->afterStateUpdated(fn (Set $set, Get $get) => self::updateRpnAdj($set, $get)),

                        TextInput::make('rpn_adj')
                            ->label('Adjusted RPN')
                            ->numeric()
                            ->readOnly(),
                    ])->columns(2),
            ]);
    }

    protected static function updateRpn(Set $set, Get $get): void
    {
        $severity = (int) $get('severity');
        $occurrence = (int) $get('occurrence');
        $detectability = (int) $get('detectability');

        $set('rpn', $severity * $occurrence * $detectability);
        $set('severity_adj', $severity);

        if (!$get('occurrence_adj')) {
            $set('occurrence_adj', $occurrence);
        }
        if (!$get('detectability_adj')) {
            $set('detectability_adj', $detectability);
        }

        self::updateRpnAdj($set, $get);
    }

    protected static function updateRpnAdj(Set $set, Get $get): void
    {
        $sev_adj = (int) $get('severity_adj') ?: (int) $get('severity');
        $occ_adj = (int) $get('occurrence_adj') ?: (int) $get('occurrence');
        $det_adj = (int) $get('detectability_adj') ?: (int) $get('detectability');

        $set('rpn_adj', $sev_adj * $occ_adj * $det_adj);
    }
}

<?php

use Filament\Infolists\ComponentContainer;
use Pelmered\FilamentMoneyField\Infolists\Components\MoneyEntry;
use Pelmered\FilamentMoneyField\Tests\Support\Components\InfolistTestComponent;

it('formats infolist money in usd', function (): void {
    $entry = MoneyEntry::make('price');

    $component = ComponentContainer::make(InfolistTestComponent::make())
        ->components([$entry])
        ->state([$entry->getName() => 100000000]);

    $entry = $component->getComponent('price');

    expect($entry->formatState($entry->getState()))->toEqual('$1,000,000.00');
});

it('formats infolist money in sek', function (): void {
    $entry = MoneyEntry::make('price')->currency('SEK')->locale('sv_SE');

    $component = ComponentContainer::make(InfolistTestComponent::make())
        ->components([$entry])
        ->state([$entry->getName() => 1000000]);

    $entry = $component->getComponent('price');

    $formatted = $entry->formatState($entry->getState());
    $expected  = '10 000,00 kr';

    expect(replaceNonBreakingSpaces($formatted))->toEqual(replaceNonBreakingSpaces($expected));
});

it('formats infolist money in short format in USD', function (): void {
    $entry = MoneyEntry::make('price')->short();

    $component = ComponentContainer::make(InfolistTestComponent::make())
        ->components([$entry])
        ->state([$entry->getName() => 123456789]);

    $entry = $component->getComponent('price');

    expect($entry->formatState($entry->getState()))->toEqual('$1.23M');
});

it('formats infolist money in short format in sek', function (): void {
    $entry = MoneyEntry::make('price')->short()->currency('SEK')->locale('sv_SE');

    $component = ComponentContainer::make(InfolistTestComponent::make())
        ->components([$entry])
        ->state([$entry->getName() => 123456]);

    $entry = $component->getComponent('price');

    $formatted = $entry->formatState($entry->getState());
    $expected  = '1,23K kr';

    expect(replaceNonBreakingSpaces($formatted))->toEqual(replaceNonBreakingSpaces($expected));
});

it('formats infolist money in sek with no decimals', function (): void {
    $entry = MoneyEntry::make('price')->currency('SEK')->locale('sv_SE')->decimals(0);

    $component = ComponentContainer::make(InfolistTestComponent::make())
        ->components([$entry])
        ->state([$entry->getName() => 1000000]);

    $entry = $component->getComponent('price');

    $formatted = $entry->formatState($entry->getState());
    $expected  = '10 000 kr';

    expect(replaceNonBreakingSpaces($formatted))->toEqual(replaceNonBreakingSpaces($expected));
});

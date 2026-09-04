<?php

use App\Models\Stack;
use App\Models\StackItem;
use Illuminate\Database\QueryException;

it('allows two different technologies in the same category for one stack', function () {
    $stack = Stack::factory()->create();

    StackItem::create([
        'stack_id' => $stack->id,
        'category' => 'backend',
        'value' => 'Laravel',
        'version' => '13.0',
    ]);

    StackItem::create([
        'stack_id' => $stack->id,
        'category' => 'backend',
        'value' => 'Laravel Horizon',
        'version' => '5.0',
    ]);

    expect($stack->stackItems()->where('category', 'backend')->count())->toBe(2);
});

it('rejects an exact duplicate stack item', function () {
    $stack = Stack::factory()->create();

    StackItem::create([
        'stack_id' => $stack->id,
        'category' => 'backend',
        'value' => 'Laravel',
        'version' => '13.0',
    ]);

    expect(fn () => StackItem::create([
        'stack_id' => $stack->id,
        'category' => 'backend',
        'value' => 'Laravel',
        'version' => '13.0',
    ]))->toThrow(QueryException::class);
});

<?php

use App\Models\University;

test("university factory creates valid university", function (): void {
    $university = University::factory()->create();

    expect($university)->toBeInstanceOf(University::class);
    expect($university->name)->toBeString();
    expect($university->label)->toBeString();
});

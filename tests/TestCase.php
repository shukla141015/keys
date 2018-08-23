<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Spatie\Snapshots\MatchesSnapshots;
use Illuminate\Contracts\Console\Kernel;

abstract class TestCase extends BaseTestCase
{
    use MatchesSnapshots;

    protected function getSnapshotDirectory(): string
    {
        return base_path('tests/Files/_snapshots_');
    }

    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        // Sqlite has foreign key constraints disabled by default
        DB::connection()->getSchemaBuilder()->enableForeignKeyConstraints();

        return $app;
    }
}

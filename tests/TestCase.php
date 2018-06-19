<?php

namespace Tests;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Spatie\Snapshots\MatchesSnapshots;
use Illuminate\Contracts\Console\Kernel;

abstract class TestCase extends BaseTestCase
{
    use MatchesSnapshots;

    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow('7 March 2018 12:00:15');
    }

    protected function getSnapshotDirectory(): string
    {
        return base_path('tests/_snapshots_');
    }

    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        Hash::driver('bcrypt')->setRounds(4);

        return $app;
    }
}

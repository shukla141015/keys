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

    protected $testFilePath;

    protected $tempFilePath;

    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow('7 March 2018 12:00:00');

        $this->testFilePath = base_path('tests/Files/');

        $this->tempFilePath = $this->testFilePath.'Temp/';
    }

    public function tearDown()
    {
        $this->emptyTempFilesDirectory();

        parent::tearDown();
    }

    public function progressTime($minutes = 1)
    {
        $newTime = now()->addMinutes($minutes);

        Carbon::setTestNow($newTime);

        return $this;
    }

    protected function emptyTempFilesDirectory()
    {
        $fileNames = scandir($this->tempFilePath);

        $fileNames = array_filter($fileNames, function ($name) {
            return substr($name, 0, 1) !== '.';
        });

        foreach ($fileNames as $name) {
            unlink($this->tempFilePath.$name);
        }
    }

    protected function getSnapshotDirectory(): string
    {
        return $this->testFilePath.'_snapshots_';
    }

    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        Hash::driver('bcrypt')->setRounds(4);

        return $app;
    }
}

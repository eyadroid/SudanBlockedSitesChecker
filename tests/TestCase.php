<?php

use App\Exceptions\Handler;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    public function disableExceptionHandling()
    {
        $this->app->instance(\Illuminate\Contracts\Debug\ExceptionHandler::class, new class extends Handler
        {
            public function render($request, \Throwable $e)
            {
                throw $e;
            }
        });
    }
}

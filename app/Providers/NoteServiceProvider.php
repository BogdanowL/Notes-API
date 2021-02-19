<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class NoteServiceProvider extends ServiceProvider
{

    public function register()
    {
       $this->app->bind('noteService', 'App\Services\NoteLogic');
    }


    public function boot()
    {
        //
    }
}

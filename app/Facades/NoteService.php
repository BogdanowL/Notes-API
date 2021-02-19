<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class NoteService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'noteService';
    }


}

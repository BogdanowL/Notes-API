<?php

namespace App\Http\Controllers\API;

use App\Facades\NoteService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNoteRequest;
use App\Notes;

class NotesController extends Controller
{

    public function index()
    {
        return Notes::latest()->paginate(5);
    }

    public function store(StoreNoteRequest $request)
    {
        NoteService::createNote($request->validated());
    }

    public function update(StoreNoteRequest $request, $id)
    {
        NoteService::updateNote($request->validated(), $id);
    }

    public function destroy($id)
    {
       NoteService::deleteNote($id);
    }
}

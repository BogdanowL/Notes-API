<?php


namespace App\Services;


use App\Notes;

class NoteLogic
{

    public function createNote($data)
    {
         Notes::create([
            'title' => $data['title'],
            'description' => $data['description']
        ]);
    }

    public function updateNote($fields, $id)
    {
        $note = Notes::find($id);
        $note->fill($fields);
        $note->save();
    }

    public function deleteNote($id)
    {
        Notes::find($id)->delete();
    }





}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct(Message $messages)
    {
        $this->messages = $messages;
    }

    public function getByProjet(Projet $projet)
    {
        return $projet->messages;
    }

    public function createInProjet(Projet $projet)
    {
        $message = $this->messages->newInstance(Input::all());
        $message->projet()->associate($projet);
        $message->user()->associate($this->me());
        $message->save();
        return $message;
    }

    public function getUpdates($lastMessageId, Projet $projet)
    {
        return $this->messages->gtByProjet($chatRoom)->afterId($lastMessageId)->get();
    }
}

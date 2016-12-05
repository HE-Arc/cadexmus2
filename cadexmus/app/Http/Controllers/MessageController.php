<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Projet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;

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

    public function show(Message $message)
    {
        return $message;
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
        return $this->messages->byProjet($projet)->afterId($lastMessageId)->get();
    }

}

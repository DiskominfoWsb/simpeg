<?php

namespace App\Repositories;

class PetajabRepository
{
    public function petajab()
    {
        return Task::where('user_id', $user->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }
}
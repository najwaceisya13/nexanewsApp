<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy
{
    public function approve(User $user, Comment $comment): bool
    {
        return $user->isAdmin();
    }
}
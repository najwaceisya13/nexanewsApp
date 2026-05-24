<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy
{
    /**
     * Hanya admin yang boleh menghapus komentar
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->isAdmin();
    }
    public function approve(User $user, Comment $comment): bool
    {
        return $user->isAdmin();
    }
}
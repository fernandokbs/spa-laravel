<?php

namespace App\Policies;

use App\Article;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Articles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the Article.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $Article
     * @return mixed
     */
    public function view(User $user, Article $Article)
    {
        return true;
    }

    /**
     * Determine whether the user can create Articles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the Article.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $Article
     * @return mixed
     */
    public function update(User $user, Article $Article)
    {
        return $user->id == $Article->user_id;
    }

    /**
     * Determine whether the user can delete the Article.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $Article
     * @return mixed
     */
    public function delete(User $user, Article $Article)
    {
        return $user->id == $Article->user_id;
    }

    /**
     * Determine whether the user can restore the Article.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $Article
     * @return mixed
     */
    public function restore(User $user, Article $Article)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the Article.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $Article
     * @return mixed
     */
    public function forceDelete(User $user, Article $Article)
    {
        return false;
    }
}

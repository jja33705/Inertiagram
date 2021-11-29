<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class FollowsController extends Controller
{
    public function store(User $user)
    {
        auth()->user()->following()->toggle($user->profile);

        return Redirect::route('profile.index', [
            'name' => $user->name,
        ]);
    }
}

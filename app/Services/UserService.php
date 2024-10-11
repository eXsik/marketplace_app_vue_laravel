<?php

namespace App\Services;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{

  public function updateUserInfo(User $user, array $fields): void
  {
    $user->fill($fields);

    if ($user->isDirty('email')) {
      $user->email_verified_at = null;
    }

    $user->save();
  }

  public function updateUserPassword(User $user, array $fields): void
  {
    $user->update([
      'password' => Hash::make($fields['password'])
    ]);
  }


  public function deleteUser(User $user): void
  {
    $user->delete();
  }
}

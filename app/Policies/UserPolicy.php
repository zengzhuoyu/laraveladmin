<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //只允许查看、更新自己的个人信息（edit、update）
    public function update(User $currentUser,User $user)
    {
        return $currentUser->id === $user->id;
    }

    //只有当前用户拥有管理员权限且删除的用户不是自己时才显示链接
    public function destroy(User $currentUser,User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}

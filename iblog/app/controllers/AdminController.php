<?php
     
class AdminController extends UserController
{    
    /* get functions */
    public function listUser()
    {
        return $this->listUserView('admin.dashboard');
    }

    public function showUser(User $user)
    {
        return $this->showUserView($user, 'admin.dashboard');
    }
     
    public function newUser()
    {
        return $this->newUserView('admin.dashboard');
    }
     
    public function editUser(User $user)
    {
        return $this->editUserView($user, 'admin.dashboard');
    }

    public function deleteUser(User $user)
    {   
        return $this->deleteUserView($user, 'user.list');
    }

}

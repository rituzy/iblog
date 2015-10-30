<?php
     
class StandardUserController extends UserController
{    
    /* get functions */
    public function showUser(User $user)
    {
        return $this->showUserView($user, 'users.dashboard');
    }
     
    public function newUser()
    {
        return $this->newUserView('users.dashboard');
    }
     
    public function editUser(User $user)
    {
        return $this->editUserView($user, 'users.dashboard');
    }

    public function deleteUser(User $user)
    {   
        return $this->deleteUserView($user, 'logout');
    }
    
}

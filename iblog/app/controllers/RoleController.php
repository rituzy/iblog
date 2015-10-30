<?php
     
class RoleController extends BaseController
{
    /* get functions */
    public function listRole()
    {
        $roles = Role::getRolesOrdered();
        $this->layout->title = trans('messages.Role listings');
        $this->layout->main = View::make('admin.dashboard')
                                    ->nest('content','roles.list',compact('roles'));
    }
     
    public function newRole()
    {
        $this->layout->title = trans('messages.New').' '.Lang::choice('messages.Roles', 1);
        $this->layout->main = View::make('admin.dashboard')
                                    ->nest('content','roles.new');
     }
     
    public function editRole(Role $role)
    {
        $this->layout->title = trans('messages.Edit').' '.Lang::choice('messages.Roles', 1);
        $this->layout->main = View::make('admin.dashboard')
                                    ->nest('content', 'roles.edit', compact('role'));
    }
     
    public function deleteRole(Role $role)
    {
        $role->softDelete();
        return Redirect::route('role.list')
                         ->with('success', Lang::choice('messages.Roles', 1).' '.trans('messages.is deleted') );
    }
     
    /* post functions */
    public function saveRole()
    {
        $inputs = [            
            'name' => Input::get('name'),            
        ];        

        $valid = Validator::make($inputs, Role::$rules);
        if ($valid->passes())
        {            
            $role = new Role();
            $role->name = $inputs['name'];
            $role->save();
            return Redirect::route('role.new')
                             ->with('success', Lang::choice('messages.Roles', 1).' '.trans('messages.is saved') );
        }
        else
            return Redirect::back()
                             ->withErrors($valid)
                             ->withInput();
    }
     
    public function updateRole(Role $role)
    {
        $inputs = [            
            'name' => Input::get('name'),            
        ];

        $valid = Validator::make($inputs, Role::$rules);
        if ($valid->passes())
        {           
            $role->name = $inputs['name'];            
            if(count($role->getDirty()) > 0) /* avoiding resubmission of same content */
            {
                $role->save();
                return Redirect::back()
                                 ->with('success', Lang::choice('messages.Roles', 1).' '.trans('messages.is updated') );
            }
            else
                return Redirect::back()
                                 ->with('success',trans('messages.Nothing to update!') );
        }
        else
            return Redirect::back()
                             ->withErrors($valid)
                             ->withInput();
    }
     
}

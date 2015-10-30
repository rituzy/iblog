<?php
 
class UserGroupSeeder extends Seeder {
 
	public function run()
	{
		DB::table('users')->truncate();
	    DB::table('roles')->truncate();
	    DB::table('users_roles')->truncate();

		$role = new Role;
		$role->name = 'admin';
		$role->save();
		$role = new Role;
		$role->name = 'user';
		$role->save();
			
		$user_adm = new User;
        $user_adm->username = 'admin';
        $user_adm->password = Hash::make('admin123');
        $user_adm->email    = 'admin@admin.com';
        
		$user_adm->save();
		$user_adm -> addRole('admin');		

		$user_user = new User;
        $user_user->username = 'user';
        $user_user->password = Hash::make('user123');
        $user_user->email    = 'user@user.com';
        		
		$user_user->save();
		$user_user->addRole('user');	
	    
	}
}
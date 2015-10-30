<?php
 
class UserTableSeeder extends Seeder {
 
public function run()
{
	// Uncomment the below to wipe the table clean before populating
	DB::table('user')->truncate();
	DB::table('roles')->truncate();
	 
	$user = array(
		'username' => 'administrator',
		'password' => Hash::make('Qazwsx12'),
		'created_at' => DB::raw('NOW()'),
		'updated_at' => DB::raw('NOW()'),
	);
	 
	// Uncomment the below to run the seeder
	DB::table('users')->insert($user);
	}

	$user = array(
		'username' => 'user',
		'password' => Hash::make('Qazwsx12'),
		'created_at' => DB::raw('NOW()'),
		'updated_at' => DB::raw('NOW()'),
	);
	 
	// Uncomment the below to run the seeder
	DB::table('users')->insert($user);
	}
 
}
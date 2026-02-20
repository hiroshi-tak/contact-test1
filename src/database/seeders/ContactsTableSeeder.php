<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::factory()->count(35)->create();
        /*
        $param = [
            'category_id'=> '1',
            'first_name' => 'tony',
            'last_name'  => 'tony',
            'gender'     => '1',
            'email'      => 'test@test',
            'tel'        => '111-1111-1111',
            'address'    => 'あ',
            'building'   => 'あ',
            'detail'     => 'あ',
        ];
        DB::table('contacts')->insert($param);
        */
    }
}

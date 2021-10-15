<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('ticket_status')->truncate();
        \DB::table('ticket_status')->insert(array (
            0 =>
            array (
                'option' => 'new',
                'created_at' => '2021-10-04 07:47:40',
                'updated_at' => '2021-10-04 07:47:40',
            ),
            1 =>
            array (
                'option' => 'Open',
                'created_at' => '2021-10-04 07:47:40',
                'updated_at' => '2021-10-04 07:47:40',
            ),
            2 =>
            array (
                'option' => 'Reply',
                'created_at' => '2021-10-04 07:47:40',
                'updated_at' => '2021-10-04 07:47:40',
            ),
            3 =>
            array (
                'option' => 'Pending',
                'created_at' => '2021-10-04 07:47:40',
                'updated_at' => '2021-10-04 07:47:40',
            ),
            4 =>
            array (
                'option' => 'Complete',
                'created_at' => '2021-10-04 07:47:40',
                'updated_at' => '2021-10-04 07:47:40',
            ),
        ));
    }
}

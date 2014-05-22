<?php
    class ContactTableSeeder extends Seeder
    {
        public function run()
        {
            DB::table("contacts")->delete();
            
            Contact::create(array("name" => "___NAME____",
                                  "number" => "___NUMBER____"));

        }
    }
?>
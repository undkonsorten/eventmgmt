<?php
namespace Undkonsorten\Eventmgmt\Seeder;


use Faker\Provider\DateTime;
use TildBJ\Seeder\Faker;
use TildBJ\Seeder\Seed;


class EventSeeder extends \TildBJ\Seeder\Seeder\DatabaseSeeder
{
    public function run(){
        $this->factory->create('sys_category',10)->each(function (Seed $seed, Faker $faker) {
            $seed->set(
                array (
                    'pid' => 68,
                    'sys_language_uid' => 0,
                    'hidden' => 0,
                    'title' => $faker->getWord(),
                    'subtitle' => $faker->getText(),
                    'short_title ' => $faker->getText(),
                    'teaser ' => $faker->getText(),
                    'description ' => $faker->getText(),
                    'start' => DateTime::dateTime('now')->getTimestamp(),
                    'end' => DateTime::dateTime('+80 days')->getTimestamp(),
                    'calendar' => '11',
                )
            );
        });
    }

}

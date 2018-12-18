<?php
/**
 * Created by IntelliJ IDEA.
 * User: eike
 * Date: 24.04.18
 * Time: 11:31
 */

namespace Undkonsorten\Eventmgmt\Seeder;


use TildBJ\Seeder\Faker;
use TildBJ\Seeder\Seed;


class CalendarSeeder extends \TildBJ\Seeder\Seeder\DatabaseSeeder
{
    public function run(){
        $this->factory->create('tx_eventmgmt_domain_model_calendar',1)->each(function (Seed $seed, Faker $faker) {
            $seed->set(
                array (
                    'pid' => 68,
                    'sys_language_uid' => 0,
                    'hidden' => 0,
                    'name' => 'Calendar 1',
                    'subtitle' => $faker->getText(),
                    'single_pid' => 69,
                )
            );
        });
    }
}

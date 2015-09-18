<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/*
 * User
 */
$factory->define(Crm\Entities\User::class, function (Faker\Generator $faker) {
    return [
        'group_id' => rand(1,10),
        'name' =>  $faker->name,
        'username' => $faker->userName,
        'password' => bcrypt(str_random(10)),
        'recovery' => bcrypt($faker->sentence),
        'remember_token' => str_random(10),
    ];
    

});

/*
 * User Group
 */
$factory->define(Crm\Entities\UserGroup::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});

/*
 * Client
 */
$factory->define(Crm\Entities\Client::class, function (Faker\Generator $faker) {
    return [
        'cod' => $faker->numerify("##########"),
        'cnpj' => $faker->numerify("##############"),
        'razao' => $faker->company,
        'uf' => $faker->stateAbbr,
        'phone' => $faker->phoneNumber
    ];
});

/*
 * Team
 */
$factory->define(Crm\Entities\Team::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'slug' => $faker->word,
        'type' => rand(1,2)
    ];
});

/*
 * Team Member
 */
$factory->define(Crm\Entities\Member::class, function (Faker\Generator $faker) {
    return [
        'user_id'   => rand(1,10),
        'team_id'   => rand(1,10),
        'sap'       => $faker->numerify("400####")
    ];
});



/*
 * Portfolio
 */
$factory->define(Crm\Entities\Portfolio::class, function (Faker\Generator $faker) {
    return [
        'client_id'     => rand(1,10),
        'team_id'       => rand(1,10),
        'member_id'     => rand(1,10),
        'responsible'   => $faker->name,
        'phone'         => json_encode([$faker->phoneNumber,$faker->phoneNumber,$faker->phoneNumber]),
        'email'         => $faker->email,
    ];
});

/*
 * Portfolio Config
 */
$factory->define(Crm\Entities\PortfolioConfig::class, function (Faker\Generator $faker) {
    return [
        'portfolio_id'      => rand(1,10),
        'seg'               => $faker->time("H:i"),
        'ter'               => $faker->time("H:i"),
        'qua'               => $faker->time("H:i"),
        'qui'               => $faker->time("H:i"),
        'sex'               => $faker->time("H:i"),
    ];
});



/*
 * Sale
 */
$factory->define(Crm\Entities\Sale::class, function (Faker\Generator $faker) {
    return [
        'client_id'     => rand(1,10),
        'team_id'       => rand(1,10),
        'member_id'     => rand(1,10),
        'number'        => $faker->numerify('##########'),
        'value'         => $faker->randomFloat(2,1199,10199)
    ];
});
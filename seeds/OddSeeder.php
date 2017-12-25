<?php

use Phinx\Seed\AbstractSeed;

class OddSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        //insert some odds in the database
        $odds = [
            ['1/5', '1.20', '-500'],
            ['2/9', '1.22', '-450'],
            ['1/4', '1.25', '-400'],
            ['2/7', '1.28', '-350'],
            ['3/10', '1.30', '-333.30'],
            ['1/3', '1.33', '-300'],
            ['7/20', '1.35', '-285.70'],
            ['4/11', '1.36', '-275'],
            ['2/5', '1.40', '-250'],
            ['4/9', '1.44', '-225'],
            ['9/20', '1.45', '-222.20'],
        ];

        $odds_table = $this->table('odds');
        foreach ($odds as $odd) {
            $odds_table->insert([
                'moneyline' => $odd[2],
                'decimal' => $odd[1],
                'fractional' => $odd[0],
            ]);
        }
        $odds_table->save();
    }
}

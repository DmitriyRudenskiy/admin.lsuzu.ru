<?php

use Illuminate\Database\Seeder;
use App\Entities\Variants;

class AddPriceToVariantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->getData() as $key => $value) {

            $model = Variants::where('id', $key)->first();

            if ($model !== null) {
                $model->price = $value;
                $model->save();
            }
        }
    }

    /**
     * @return array
     */
    protected function getData()
    {
        return [
            '4' => 2140000,
            '5' => 2170000,
            '6' => 2320000,
            '7' => 2390000,
            '8' => 2700000,
            '9' => 2710000,
            '10' => 2770000,
            '11' => 2830000,
            '12' => 3020000,
            '13' => 3070000,
            '14' => 3120000,
            '15' => 3170000,
            '16' => 4100000,
            '17' => 4170000,
            '18' => 4250000,
            '19' => 4630000,
            '20' => 4700000,
            '21' => 4760000,
            '22' => 5800000,
            '23' => 5850000,
            '24' => 6200000,
            '25' => 6250000,
            '26' => 6500000
        ];
    }
}

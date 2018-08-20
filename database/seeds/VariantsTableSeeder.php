<?php

use Illuminate\Database\Seeder;
use App\Entities\Variants;

class VariantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->getData() as $value) {
            Variants::forceCreate($value);
        }
    }

    /**
     * @return array
     */
    protected function getData()
    {
        return [
            [
                "id" => 1,
                "parent_id" => null,
                "title" => "ELF"
            ],
            [
                "id" => 2,
                "parent_id" => null,
                "title" => "FORWARD"
            ],
            [
                "id" => 3,
                "parent_id" => null,
                "title" => "GIGA"
            ],
            [
                "id" => 4,
                "parent_id" => 1,
                "title" => "3.5 SHORT NMR85E"
            ],
            [
                "id" => 5,
                "parent_id" => 1,
                "title" => "3.5 LONG NMR85H"
            ],
            [
                "id" => 6,
                "parent_id" => 1,
                "title" => "5.2 SHORT NMR85E"
            ],
            [
                "id" => 7,
                "parent_id" => 1,
                "title" => "5.2 LONG NMR85H"
            ],
            [
                "id" => 8,
                "parent_id" => 1,
                "title" => "7.5 SHORT NPR75L-H"
            ],
            [
                "id" => 9,
                "parent_id" => 1,
                "title" => "7.5 NORMAL NPR75L-K"
            ],
            [
                "id" => 10,
                "parent_id" => 1,
                "title" => "7.5 LONG NPR75L-L"
            ],
            [
                "id" => 11,
                "parent_id" => 1,
                "title" => "7.5 EXTRALONG NPR75L-M"
            ],
            [
                "id" => 12,
                "parent_id" => 1,
                "title" => "9.5 SHORT NQR90L-H"
            ],
            [
                "id" => 13,
                "parent_id" => 1,
                "title" => "9.5 NORMAL NQR90L-K"
            ],
            [
                "id" => 14,
                "parent_id" => 1,
                "title" => "9.5 LONG NQR90L-L"
            ],
            [
                "id" => 15,
                "parent_id" => 1,
                "title" => "9.5 EXTRALONG NQR90L-M"
            ],

            [
                "id" => 16,
                "parent_id" => 2,
                "title" => "12.0 NORMAL FSR90SL-LCUS"
            ],
            [
                "id" => 17,
                "parent_id" => 2,
                "title" => "12.0 LONG FSR90SL-NCUS"
            ],
            [
                "id" => 18,
                "parent_id" => 2,
                "title" => "12.0 EXTRALONG FSR90SL-PCUS"
            ],
            [
                "id" => 19,
                "parent_id" => 2,
                "title" => "18.0 NORMAL FVR34UL-MDUS"
            ],
            [
                "id" => 20,
                "parent_id" => 2,
                "title" => "18.0 LONG FVR34UL-QDUS"
            ],
            [
                "id" => 21,
                "parent_id" => 2,
                "title" => "18.0 EXTRALONG FVR34UL-SDUS"
            ],
            [
                "id" => 22,
                "parent_id" => 3,
                "title" => "6x4 SHORT CYZ52M"
            ],
            [
                "id" => 23,
                "parent_id" => 3,
                "title" => "6x4 NORMAL CYZ52P"
            ],
            [
                "id" => 24,
                "parent_id" => 3,
                "title" => "6x4 LONG CYZ52Q"
            ],
            [
                "id" => 25,
                "parent_id" => 3,
                "title" => "6x4 EXTRALONG CYZ52T"
            ],
            [
                "id" => 26,
                "parent_id" => 3,
                "title" => "6x4 TRACTOR EXZ52K"
            ],
        ];
    }
}

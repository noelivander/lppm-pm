<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\RelatedLink;

class RelatedLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RelatedLink::create(['nama'=>'ITH','url'=>'https://ith.ac.id/']);
        RelatedLink::create(['nama'=>'PDDikti','url'=>'https://pddikti.kemdikbud.go.id/']);
        RelatedLink::create(['nama'=>'BIMA','url'=>'https://bima.kemdikbud.go.id/']);
        RelatedLink::create(['nama'=>'SINTA','url'=>'https://sinta.kemdikbud.go.id/']);
        RelatedLink::create(['nama'=>'ARJUNA','url'=>'https://arjuna.kemdikbud.go.id/']);
        RelatedLink::create(['nama'=>'RAMA','url'=>'https://rama.kemdikbud.go.id/']);
        RelatedLink::create(['nama'=>'GARUDA','url'=>'https://garuda.kemdikbud.go.id/']);
        RelatedLink::create(['nama'=>'ANJANI','url'=>'https://anjani.kemdikbud.go.id/']);
        RelatedLink::create(['nama'=>'KEMENDIKBUD','url'=>'https://www.kemdikbud.go.id/']);
    }
}

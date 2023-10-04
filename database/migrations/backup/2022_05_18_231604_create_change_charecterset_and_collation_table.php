<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangeCharectersetAndCollationTable extends Migration
{
    public function up()
    {
        DB::statement('ALTER DATABASE database CHARACTER SET utf8 COLLATE utf8_general_ci');
    }

    public function down()
    {
        DB::statement('ALTER DATABASE database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    }
}

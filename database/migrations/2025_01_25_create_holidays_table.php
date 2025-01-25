<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('holidays-de.holidays_table_name'), function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date');
            $table->string('holiday', 255);
            $table->boolean('all_states');
            $table->boolean('baden_wurttemberg');
            $table->boolean('bayern');
            $table->boolean('berlin');
            $table->boolean('brandenburg');
            $table->boolean('bremen');
            $table->boolean('hamburg');
            $table->boolean('hessen');
            $table->boolean('mecklenburg_vorpommern');
            $table->boolean('niedersachsen');
            $table->boolean('nordrhein_westfalen');
            $table->boolean('rheinland_pfalz');
            $table->boolean('saarland');
            $table->boolean('sachsen');
            $table->boolean('sachsen_anhalt');
            $table->boolean('schleswig_holstein');
            $table->boolean('thuringen');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('holidays-de.holidays_table_name'));
    }
};

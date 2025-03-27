<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('approvisionnements', function (Blueprint $table) {
            $table->foreignId('destination_id')->nullable()->constrained('destinations')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('approvisionnements', function (Blueprint $table) {
            $table->dropForeign(['destination_id']);
            $table->dropColumn('destination_id');
        });
    }
};

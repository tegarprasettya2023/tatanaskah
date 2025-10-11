<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up(): void
{
    Schema::table('personal_letters', function (Blueprint $table) {
        if (!Schema::hasColumn('personal_letters', 'tempat')) {
            $table->string('tempat')->nullable()->after('letter_date');
        }
    });
}


public function down(): void
{
    Schema::table('personal_letters', function (Blueprint $table) {
        $table->dropColumn('tempat');
    });
}

};

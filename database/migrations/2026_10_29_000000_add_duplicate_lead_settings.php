<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('duplicate_message', 500)
                ->default('Este numero ya se encuentra registrado. Uno de nuestros asesores lo estara contactando pronto.')
                ->after('success_message');
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->index('phone');
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropIndex(['phone']);
        });

        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('duplicate_message');
        });
    }
};

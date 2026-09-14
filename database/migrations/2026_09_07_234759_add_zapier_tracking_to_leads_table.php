<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('zapier_status')->default('disabled');
            $table->timestamp('zapier_sent_at')->nullable();
            $table->unsignedSmallInteger('zapier_response_code')->nullable();
            $table->text('zapier_response_body')->nullable();
            $table->text('zapier_error')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'zapier_status',
                'zapier_sent_at',
                'zapier_response_code',
                'zapier_response_body',
                'zapier_error',
            ]);
        });
    }
};

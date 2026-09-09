<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->text('message')->nullable()->change();

            $table->string('designation')->nullable()->after('email');
        });
    }
 
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('designation');
            $table->text('message')->nullable(false)->change();
        });
    }
};

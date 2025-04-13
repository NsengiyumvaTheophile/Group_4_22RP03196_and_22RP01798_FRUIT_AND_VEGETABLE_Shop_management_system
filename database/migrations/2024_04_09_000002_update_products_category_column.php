<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // First, add the category_id column
            $table->foreignId('category_id')->nullable()->after('description');

            // Then, drop the old category column
            $table->dropColumn('category');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // First, add back the category column
            $table->string('category')->after('description');

            // Then, drop the foreign key and category_id column
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};

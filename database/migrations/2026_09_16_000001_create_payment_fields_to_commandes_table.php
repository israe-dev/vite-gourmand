<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->decimal('total', 10, 2)->after('prix_menu')->default(0);
            $table->string('payment_status')->default('pending')->after('total');
            $table->string('payment_method')->nullable()->after('payment_status');
            $table->string('payment_provider_id')->nullable()->after('payment_method');
            $table->timestamp('paid_at')->nullable()->after('payment_provider_id');
        });
    }

    public function down()
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn([
                'total',
                'payment_status',
                'payment_method',
                'payment_provider_id',
                'paid_at',
            ]);
        });
    }
};
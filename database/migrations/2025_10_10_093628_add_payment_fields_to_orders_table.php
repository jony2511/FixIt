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
        Schema::table('orders', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('orders', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->after('order_number');
            }
            if (!Schema::hasColumn('orders', 'shipping_email')) {
                $table->string('shipping_email')->nullable()->after('shipping_name');
            }
            if (!Schema::hasColumn('orders', 'payment_details')) {
                $table->text('payment_details')->nullable()->after('payment_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('orders', 'transaction_id')) {
                $columns[] = 'transaction_id';
            }
            if (Schema::hasColumn('orders', 'shipping_email')) {
                $columns[] = 'shipping_email';
            }
            if (Schema::hasColumn('orders', 'payment_details')) {
                $columns[] = 'payment_details';
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};

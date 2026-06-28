<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('payment_channel')->nullable()->after('metode_pembayaran');
            $table->string('va_number')->nullable()->after('payment_channel');
            $table->string('bill_key')->nullable()->after('va_number');
            $table->string('biller_code')->nullable()->after('bill_key');
            $table->string('transaction_id')->nullable()->after('biller_code');
            $table->timestamp('expiry_time')->nullable()->after('transaction_id');
            $table->json('payment_details')->nullable()->after('expiry_time');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn([
                'payment_channel',
                'va_number',
                'bill_key',
                'biller_code',
                'transaction_id',
                'expiry_time',
                'payment_details',
            ]);
        });
    }
};

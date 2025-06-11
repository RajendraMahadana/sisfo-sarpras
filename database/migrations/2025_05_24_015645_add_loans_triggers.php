<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        // Trigger untuk mengurangi stok saat status loan diubah menjadi 'approved'
        DB::unprepared('
            CREATE TRIGGER trg_loan_approved
            AFTER UPDATE ON loans
            FOR EACH ROW
            BEGIN
                IF OLD.status != "approved" AND NEW.status = "approved" THEN
                    UPDATE items
                    SET quantity = quantity - NEW.quantity
                    WHERE id = NEW.item_id;
                END IF;
            END
        ');

        // Trigger untuk menambahkan kembali stok saat return dengan status 'returned'
        DB::unprepared('
            CREATE TRIGGER update_stock_after_return AFTER INSERT ON itemreturn
            FOR EACH ROW
            BEGIN
                UPDATE items
                SET quantity = quantity + (SELECT quantity FROM loans WHERE id = NEW.loan_id)
                WHERE id = (SELECT item_id FROM loans WHERE id = NEW.loan_id);
            END;    
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_loan_approved');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_returned_item');
    }
};

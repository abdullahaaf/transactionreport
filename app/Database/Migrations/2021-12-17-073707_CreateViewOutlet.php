<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateViewOutlet extends Migration
{
    public function up()
    {
        //
        $db = \Config\Database::connect();
        $db->query("CREATE OR REPLACE VIEW view_laporan_outlet as SELECT
        users.id as id_user, users.name, merchants.id as id_merchant,merchants.merchant_name,transactions.outlet_id, outlets.outlet_name, SUM(transactions.bill_total) AS total_transaction, date(transactions.created_at) AS transaction_date
        FROM transactions
        JOIN outlets ON transactions.outlet_id = outlets.id
        JOIN merchants ON transactions.merchant_id = merchants.id
        JOIN users ON merchants.user_id = users.id
        GROUP BY transactions.outlet_id, date(transactions.created_at)
        ORDER BY date(transactions.created_at) ASC");
    }

    public function down()
    {
        //
        $db = \Config\Database::connect();
        $db->query("DROP VIEW view_laporan_outlet");
    }
}

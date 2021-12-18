<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Datatable;

class LaporanModel extends Datatable
{
    // datatable
    protected $table_datatables = 'view_laporan_merchant';
    protected $select = array('id_user', 'name', 'id_merchant','merchant_name','total_transaction','transaction_date'); 
    protected $column_order = array('id_user', 'name', 'id_merchant','merchant_name','total_transaction','transaction_date', null);
    protected $column_search = array('id_user', 'name', 'id_merchant','merchant_name','total_transaction','transaction_date');
    protected $order = array('id_user' => 'desc');
    // end datatable

    public function getMerchant($id_user)
    {
        $query = $this->db->query("SELECT id,user_id,merchant_name from merchants where user_id=".$id_user);
        return $query->getResult();
    }

    public function getOutlet($id_user)
    {
        $query = $this->db->query("SELECT DISTINCT(outlet_id) as id_outlet, outlet_name FROM `view_laporan_outlet` WHERE id_user=".$id_user);
        return $query->getResult();
    }

    public function getMerchantTransaction($id_merchant,$tanggal_awal,$tanggal_akhir)
    {
        $query = $this->db->query("SELECT * FROM view_laporan_merchant WHERE id_merchant=".$id_merchant." HAVING transaction_date between '$tanggal_awal' AND '$tanggal_akhir'");
        return $query->getResult();
    }

    public function getOutletTransaction($id_outlet,$tanggal_awal,$tanggal_akhir)
    {
        $query = $this->db->query("SELECT * FROM view_laporan_outlet WHERE  outlet_id =".$id_outlet." HAVING transaction_date between '$tanggal_awal' AND '$tanggal_akhir'");
        return $query->getResult();
    }
}

?>
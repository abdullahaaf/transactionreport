<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\LaporanModel;
use \Firebase\JWT\JWT;

class LaporanController extends BaseController
{
    use ResponseTrait;

    public function merchantPage()
    {
        return view('merchant');
    }

    public function outletPage()
    {
        return view('outlet');
    }

    public function getMerchant()
    {
        $laporan = new LaporanModel();
        $merchant = $laporan->getMerchant($this->decoded_token['uid']);
        return $this->respond($merchant,200);
    }

    public function getOutlet()
    {
        $laporan = new LaporanModel();
        $data_outlet = $laporan->getOutlet($this->decoded_token['uid']);
        return $this->respond($data_outlet,200);
    }

    public function merchantAPI()
    {
        $laporan = new LaporanModel();

        $tanggal_awal = $this->request->getGet('tanggal-awal');
        $tanggal_akhir = $this->request->getGet('tanggal-akhir');
        if (!isset($tanggal_awal)) {
            $tanggal_awal = date('Y-m-d');
            $tanggal_akhir = date('Y-m-d');
        }
        $merchant_id = (int)$this->request->getGet('merchant_id');
        $range_tanggal = $this->displayDates($tanggal_awal, $tanggal_akhir);

        $data_gabungan = array();
        $transaksi = $laporan->getMerchantTransaction($merchant_id,$tanggal_awal,$tanggal_akhir);

        for($i = 0 ; $i < count($range_tanggal) ; ++$i) {
            if (isset($transaksi[$i])) {
                $data_row = [
                    'tanggal' => $transaksi[$i]->transaction_date,
                    'omset' => number_format($transaksi[$i]->total_transaction)
                ];
            }else {
                $data_row = [
                    'tanggal' => $range_tanggal[$i],
                    'omset' => 0
                ];
            }
            $data_gabungan[] = $data_row;
        }

        return $this->respond($data_gabungan,200);
    }

    public function outletAPI()
    {
        $laporan = new LaporanModel();

        $tanggal_awal = $this->request->getGet('tanggal-awal');
        $tanggal_akhir = $this->request->getGet('tanggal-akhir');
        if (!isset($tanggal_awal)) {
            $tanggal_awal = date('Y-m-d');
            $tanggal_akhir = date('Y-m-d');
        }
        $outlet_id = (int)$this->request->getGet('outlet_id');
        $range_tanggal = $this->displayDates($tanggal_awal, $tanggal_akhir);

        $transaksi = $laporan->getOutletTransaction($outlet_id,$tanggal_awal,$tanggal_akhir);

        $data_gabungan = array();

        for($i = 0 ; $i < count($range_tanggal) ; ++$i) {
            if (isset($transaksi[$i])) {
                $data_row = [
                    'tanggal' => $transaksi[$i]->transaction_date,
                    'omset' => number_format($transaksi[$i]->total_transaction)
                ];
            }else {
                $data_row = [
                    'tanggal' => $range_tanggal[$i],
                    'omset' => 0
                ];
            }
            $data_gabungan[] = $data_row;
        }

        return $this->respond($data_gabungan,200);
    }

    function displayDates($date1, $date2, $format = 'Y-m-d' ) {
      $dates = array();
      $current = strtotime($date1);
      $date2 = strtotime($date2);
      $stepVal = '+1 day';
      while( $current <= $date2 ) {
         $dates[] = date($format, $current);
         $current = strtotime($stepVal, $current);
      }
      return $dates;
   }

    
}

?>
<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BalanceLogsModel;
use CodeIgniter\RESTful\ResourceController;

class BalanceLogsController extends ResourceController{

    public function withdraw($userId){
        $data = $this->request->getJSON();
        $amount = $data->amount;


        $db = \Config\Database::connect();
        $userModel = new UserModel();

        $balanceLogsModel = new BalanceLogsModel();

        if($amount < 50000){
            return $this->fail('minimum Withdrawal Rp 50,000');
        }

        $db->transStart();

       
        $user = $userModel->find($userId);
if (!$user) {
    return $this->fail('User not found');
}

        if($user['saldo']< $amount){
            $db->transRollback();
            return $this->fail('balance low');
        }

        $userModel->update($userId,[
            'saldo'=>$user['saldo']-$amount
        ]);

        $balanceLogsModel->insert([
               'user_id' => $userId,
               'type' => 'out',
               'from_source' => 'withdrawal',
               'reference_table' => 'users',
               'reference_id' => $userId,
               'amount'=>$amount,
               'created_by' => $userId,
       
    ]);
        $db->transComplete();
        if($db->transStatus()===false){
              log_message('error', 'DB Transaksi Gagal. saldo_user=' . $user['saldo'] . ', amount=' . $amount);
            return $this->fail('Withdrawal failed');
        }

        return $this->respond([
            'message'=>'Withdrawal success',
            'status' =>'pending'
        ]);
    }


     public function detailSaldo($userId)
    {
        // Inisialisasi model yang dibutuhkan
        $userModel = new UserModel();
        $balanceLogsModel = new BalanceLogsModel();

        // 1. Ambil data user untuk memastikan user ada
        $user = $userModel->find($userId);
        if (!$user) {
            // Jika user tidak ditemukan, tampilkan halaman error 404
            throw PageNotFoundException::forPageNotFound("User dengan ID {$userId} tidak ditemukan.");
        }

        // 2. Hitung Total Bonus
        // Menggunakan selectSum untuk menjumlahkan kolom 'amount'
        // dengan filter user_id dan type = 'bonus'
        $totalBonusData = $balanceLogsModel
            ->selectSum('amount', 'total_bonus') // 'total_bonus' adalah alias untuk hasil penjumlahannya
            ->where('user_id', $userId)
            ->where('type', 'bonus') // Pastikan 'type' ini sesuai dengan yang Anda gunakan di database
            ->first();

        // 3. Hitung Total Withdraw
        // Sama seperti bonus, tapi dengan type = 'withdraw'
        $totalWithdrawData = $balanceLogsModel
            ->selectSum('amount', 'total_withdraw')
            ->where('user_id', $userId)
            ->where('type', 'withdraw') // Pastikan 'type' ini sesuai dengan yang Anda gunakan
            ->first();

        // 4. Siapkan data untuk dikirim ke view
        // Gunakan null coalescing operator (??) untuk memberi nilai 0 jika tidak ada data (hasilnya null)
       $data = [
            
                'total_bonus_received' => (float)($totalBonusData['total_bonus'] ?? 0),
                'total_withdrawn'      => (float)($totalWithdrawData['total_withdraw'] ?? 0),
                'total_saldo'          =>($user['saldo'])
            
        ];

        // 5. Return the data as a JSON response
        return $this->respond($data);
       
       
    }

}


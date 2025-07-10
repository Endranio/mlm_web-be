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


}


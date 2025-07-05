<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\WithdrawModel;
use CodeIgniter\RESTful\ResourceController;

class WithdrawController extends ResourceController{

    public function withdraw($userId){
        $data = $this->request->getJSON();
        $amount = $data->amount;


        $db = \Config\Database::connect();
        $userModel = new UserModel();

        $withdrawModel = new WithdrawModel();

        if($amount < 50000){
            return $this->fail('minimum Withdrawal Rp 50,000');
        }

        $db->transStart();

        $user=$userModel->find($userId);
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

        $withdrawModel->insert([
        'user_id' => $userId,
        'amount'  => $amount,
        'status'  => 'pending',
       
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


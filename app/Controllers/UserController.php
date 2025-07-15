<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BalanceLogsModel;
use CodeIgniter\RESTful\ResourceController;

class UserController extends ResourceController
{
    protected $format = 'json';

    public function login()
    {
        $data = $this->request->getJSON();

$username = $data->username ;
$password = $data->password ;
$userModel = new UserModel();
$user = $userModel->where('username', $username)->first();

if (!$user) {
    return $this->failNotFound('Username tidak ditemukan.');
}
        if (!password_verify($password,$user['password'])) {
            return $this->failUnauthorized('Password wrong.');
        }

        
        return $this->respond([
            'message' => 'Login berhasil',
            'data'    => [
                'id'       => $user['id'],
                'username' => $user['username'],
                'created_at' => $user['created_at']
        
            ]
        ]);
    }

    public function register()
    {
        $data = $this->request->getJSON();

        $username = $data->username;
        $password = $data->password;
        $upline = $data->upline;
        $sponsor = $data->sponsor;
        $position = $data->position;


        $userModel = new UserModel();

        $hashedPassword = password_hash($password,PASSWORD_DEFAULT);

         $upline = $userModel->where('username', $upline)->first();
         $sponsor = $userModel->where('username',$sponsor)->first();
         
        $userData = [
        'username'    => $username,
        'password'    => $hashedPassword,
        'upline_id'   => $upline['id'],               
        'sponsor_id'  => $sponsor['id'],      
        'position'    => $position,
        'point_left'  => 0,
        'point_right' => 0,
        'saldo'       => 0,
        'pair_count'  =>0,
        ];

        $userModel -> insert($userData);
       
        if($position === "left"){
            $upline['point_left']+=1;
            $userModel->update($upline['id'],[
                'point_left' => $upline['point_left']
            ]);
        } elseif($position === 'right'){
            $upline['point_right']+=1;
            $userModel->update($upline['id'],[
                'point_right' => $upline['point_right']+1
            ]);
            
        }

          if($position === "left"){
            $userModel->update($sponsor['id'],[
                'point_left' => $sponsor['point_left']+1
            ]);
        } elseif($position === 'right'){
            $userModel->update($sponsor['id'],['point_right' => $sponsor['point_right']+1]);
            
        }

        $balanceLogsModel = new BalanceLogsModel();

        $pairUpline = min($upline['point_left'],$upline['point_right']);
        if($pairUpline>$upline['pair_count']){
            $newPairs = $pairUpline - $upline['pair_count'];
            $bonus = 10000 * $newPairs;
            $userModel->update($upline['id'],[
                'saldo' => $upline['saldo']+$bonus,
                'pair_count' => $pairUpline
            ]);
            $balanceLogsModel->insert([
                'user_id' => $upline['id'],
                'type' => 'in',
                'from_source' => 'pairing',
                'reference_table' => 'users',
                'reference_id' => $userModel->getInsertID(),
                'amount'=>$bonus,
                'created_by' => $userModel->getInsertID(),
            ]);
        }

        
        $pairSponsor = min($sponsor['point_left'],$sponsor['point_right']);
        if($pairSponsor>$sponsor['pair_count']){
            $newPairs = $pairSponsor - $sponsor['pair_count'];
            $bonus = 10000 * $newPairs;
            $userModel->update($sponsor['id'],[
                'saldo' => $sponsor['saldo']+$bonus,
                'pair_count' => $pairSponsor
            ]);
            $balanceLogsModel->insert([
               'user_id' => $sponsor['id'],
               'type' => 'in',
               'from_source' => 'pairing',
               'reference_table' => 'users',
               'reference_id' => $userModel->getInsertID(),
               'amount'=>$bonus,
               'created_by' => $userModel->getInsertID(),
           ]);
        }
       

        return $this->respond([
            'message'=>"Register success"
        ]);
    }

    public function getNetwork($username)
{
    $userModel = new UserModel();

    // Cari user utama
    $user = $userModel->where('username', $username)->first();
    if (!$user) return $this->failNotFound('User tidak ditemukan.');

    // Panggil fungsi rekursif
    $tree = $this->buildTree($user['id']);

    return $this->respond($tree);
}

private function buildTree($userId)
{
    $userModel = new UserModel();

    // Ambil user sekarang
    $user = $userModel->find($userId);

    // Ambil anak-anaknya (kiri dan kanan)
    $children = $userModel->where('upline_id', $userId)->findAll();

    // Pisahkan kiri dan kanan
    $left = null;
    $right = null;

    foreach ($children as $child) {
        if ($child['position'] === 'left') {
            $left = $this->buildTree($child['id']);
        } elseif ($child['position'] === 'right') {
            $right = $this->buildTree($child['id']);
        }
    }

    return [
        'id'       => $user['id'],
        'username' => $user['username'],
        'position' => $user['position'],
        'left'     => $left,
        'right'    => $right
    ];
}

}

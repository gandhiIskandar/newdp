<?php

namespace App\Livewire\Forms;

use App\Models\Member;
use App\Models\MemberAccount;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Form;

class TransactionForm extends Form
{
    #[Rule(['required', 'numeric'])]
    public $type = 0;

    #[Rule(['required'])]
    public $amount = 0;

    #[Rule(['required'])]
    public $under_name = ""; // diisi aja supaya bisa masuk validate ketika input transaksi di user lama

    #[Rule(['numeric'])]
    public $member_account_id = 1; // nilai awal adalah 1 karena selected awal ada di id 1

    #[Rule(['numeric'])]
    public $bank_id = 1; // nilai awal adalah 1 karena selected awal ada di id 1

    #[Rule(['numeric'])]
    public $account_id = 1; // nilai awal adalah 1 karena selected awal ada di id 1

    #[Rule(['numeric'])]
    public $astaga = 1; // member_bank_id nilai awal adalah 1 karena selected awal ada di id 1

    #[Rule(['numeric'])]
    public $account_number = 0;

    #[Rule(['required'])]
    public $username = '';

    public $member;

    // type = 1 -> wd
    // type = 2 -> depo

    public function create($user_id = null)
    {
        if ($this->validate()) {
            // dd(request()->all());

            //  dd($this->account_id);

            //indikator untuk member baru atau lama
            // jika value = 1 (baru)
            // jika value = 0 (lama)
            $new = 0;

            if ($user_id == null) {

                $this->member = $this->createMember($this->username);

                $user_id = $this->member->id;
                $member_account = $this->createMemberAccount();

                //setting member account id dari member account yang baru dibuat karena ini adalah transaksi member baru, ini berlaku jika tipe adalah withdraw

                if ($this->type == 1) {

                    $this->member_account_id = $member_account->id;
                }

                $new = 1;
            }

            if ($new == 0) {
                $this->memberTransactionSum($user_id, $this->amount, $this->type);
            }

            $data = [
                'type_id' => $this->type,
                'account_id' => $this->account_id, //kalau wd ambil account_id dari data user, kalau depo ambil dari inputan
                'amount' => $this->amount,
                'member_id' => $user_id,
                'website_id' => session('website_id'),
                'new' => $new,

            ];

            if ($this->type == 2) { // jika tipenya adalah deposit

                $data['bank_id'] = $this->bank_id;

                updateSaldoRekeningAdmin($this->account_id, $this->amount, 'tambah');
            } else {

                $data['member_account_id'] = $this->member_account_id;
                updateSaldoRekeningAdmin($this->account_id, $this->amount, 'kurang');
            }



            $transaction = Transaction::create($data);

            // dd(request());
            $admin = Auth::user();

            // $this->logform->store($user->name, $ip, $activity, $target, $deskripsi);

            $formattedAmount = toRupiah($this->amount, true);

            insertLog($admin->name, request()->ip(), 'Insert Transaksi', $user_id, $this->type == 1 ? "Witdraw $formattedAmount" : "Deposit $formattedAmount", 0);

            $this->reset();

            $this->amount = 0;

            flash('Berhasil Tambah Transaksi', 'alert-success');

            return $transaction;
        }
    }

    public function createMember($username)
    {
        //create member juga melakukan sum total transaksi inisiasi
        return Member::create([
            'username' => $username,
            'total_wd' => $this->type == 1 ? $this->amount : 0,
            'total_depo' => $this->type == 2 ? $this->amount : 0,
            'website_id' => session('website_id'),

        ]);
    }

    public function createMemberAccount()
    {

        return MemberAccount::create([
            'member_id' => $this->member->id,
            'bank_id' => $this->astaga,
            'under_name' => $this->under_name,
            'number' => $this->account_number,
        ]);
    }

    public function updateTransaction($transaction)
    {
        if ($this->amount != 0 && $this->type != 0) {

            $old_type = $transaction->type_id;
            $old_amount = $transaction->amount;

            $new_amount = $this->amount;
            $new_type = $this->type;

            if ($new_type != $old_type) { //cek jika ada perubahan jenis transaksi
                //jika ada maka lakukan perubahan sum transaksi di data member terlebih dahulu
                $this->updateMemberTransactionSumDiffrentType(
                    $transaction->member,
                    $old_type,
                    $old_amount,
                    $new_type,
                    $new_amount
                );

                if ($new_type == 1) { //jika tipe baru adalah withdraw
                    $transaction->member_account_id = $this->member_account_id;
                    $transaction->bank_id = null;

                    //kurangi dulu dengan jumlah yang lama
                    updateSaldoRekeningAdmin($this->account_id, $old_amount, 'kurang');

                    //lalu kurangi dengan saldo yang baru karena ini adalah withdraw

                    updateSaldoRekeningAdmin($this->account_id, $new_amount, 'kurang');
                } else {

                    $transaction->member_account_id = null;
                    $transaction->bank_id = $this->bank_id;

                    //kurangi dulu dengan jumlah yang lama
                    updateSaldoRekeningAdmin($this->account_id, $old_amount, 'kurang');

                    //lalu kurangi dengan saldo yang baru karena ini adalah withdraw

                    updateSaldoRekeningAdmin($this->account_id, $new_amount, 'tambah');
                }
            } else {

                //kurangi dulu dengan jumlah yang lama
                updateSaldoRekeningAdmin($this->account_id, $old_amount, 'kurang');

                if ($transaction->type_id == 1) {

                    $ket = 'kurang';
                } else {
                    $ket = 'tambah';
                }

                updateSaldoRekeningAdmin($this->account_id, $new_amount, $ket);

                $this->updateMemberTransactionSumSameType(
                    $transaction->member,
                    $transaction->type_id,
                    $new_amount,
                    $old_amount
                );
            }

            $admin = Auth::user();

            $formattedOldAmount = toRupiah($old_amount, true);
            $formattedNewAmount = toRupiah($new_amount, true);

            insertLog($admin->name, request()->ip(), 'Update Transaksi', $transaction->member_id, $transaction->type_id == 1 ? "Witdraw from $formattedOldAmount to $formattedNewAmount" : "Deposit from $formattedOldAmount to $formattedNewAmount ", 0);

            $transaction->type_id = $new_type;
            $transaction->amount = $new_amount;

            $transaction->save();
        }
    }

    public function updateMemberTransactionSumSameType($member, $type_id, $new_amount, $old_amount)
    {
        //kurangi dulu amount kesalahan di tipe yang sama  sesuai dengan old_amount lalu tambah dengan amount baru

        switch ($type_id) {
            case 1:
                $member->total_wd -= $old_amount;
                $member->total_wd += $new_amount;
                break;

            case 2:

                $member->total_depo -= $old_amount;
                $member->total_depo += $new_amount;
                break;
        }

        $member->save();

        // type 1 = total_wd
        // type 2 = total_depo

    }

    public function updateMemberTransactionSumDiffrentType($member, $old_type, $old_amount, $new_type, $new_amount)
    {

        //kurangi dulu amount kesalahan di old_type atau tipe lama sesuai dengan old_amount

        // type 1 = total_wd
        // type 2 = total_depo

        switch ($old_type) {
            case 1:
                $member->total_wd -= $old_amount;
                break;

            case 2:
                $member->total_depo -= $old_amount;
                break;
        }

        //tambah amount di type yang baru

        switch ($new_type) {
            case 1:
                $member->total_wd += $new_amount;
                break;

            case 2:
                $member->total_depo += $new_amount;
                break;
        }

        $member->save();
    }

    //fungsi ini berlaku untuk member yang sudah terdaftar
    public function memberTransactionSum($user_id, $amount, $type)
    {

        $this->member = Member::findOrFail($user_id);

        if ($type == 1) {

            $this->member->total_wd += $amount;
        }
        if ($type == 2) {

            $this->member->total_depo += $amount;
        }

        $this->member->save();
    }
}

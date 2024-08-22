<?php

namespace App\Livewire;

use App\Models\Bank;
use App\Models\Member;
use App\Models\MemberAccount;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class MemberEditModal extends Component
{
    public $member;

    public $edit = 0; //0 adalah false untuk create member

    #[Rule(['required'])]
    public $username = '';

    #[Rule(['required'])]
    public $under_name = '';

    #[Rule(['required'])]
    public $account_number = '';

    #[Rule(['required'])]
    public $bank_id = '';

    public $username_exist = 0;

    public function render()
    {
        if ($this->edit == 0) {
            $this->checkUsernameNonEditState();
            //     $this->checkPhoneNumberNonEditState();
        } else {

            $this->checkUsername();
            // $this->checkPhoneNumber();
        }

        return view('livewire.member-edit-modal', ['banks' => Bank::all()]);
    }

    public function checkUsernameNonEditState()
    {
        $exist = Member::where('username', $this->username)->get()->first();

        if ($exist) {
            $this->username_exist = 1;
        } else {
            $this->username_exist = 0;
        }
    }

    // public function checkPhoneNumberNonEditState()
    // {
    //     $exist = Member::where('phone_number', $this->phone_number)->get()->first();

    //     if ($exist) {
    //         $this->pn_exist = 1;
    //     } else {
    //         $this->pn_exist = 0;
    //     }
    // }

    public function checkUsername()
    {
        if ($this->username != '') {

            $exists = Member::where('username', $this->username)->whereNotIn('id', [$this->member->id])->first();

            if (! $exists) {

                $this->username_exist = 2;
                if ($this->username == $this->member->username) {
                    $this->username_exist = 0; //jika data sama maka akan default
                }
            } else {

                $this->username_exist = 1;
            }
        } else {
            $this->username_exist = 0;
        }
    }

    #[On('confirmRemoveMember')]
    public function deleteConfirmation($member)
    {

        $member = (object) $member;

        $this->dispatch('confirmRemoveMemberJS', member: $member);
    }

    // public function checkPhoneNumber()
    // {
    //     if ($this->phone_number != '') {
    //         $exists = Member::where('phone_number', $this->phone_number)->whereNotIn('id', [$this->member->id])->first();

    //         if (!$exists) {
    //             $this->pn_exist = 2;

    //             if ($this->phone_number == $this->member->phone_number) {
    //                 $this->pn_exist = 0; //jika data sama maka akan default
    //             }
    //         } else {
    //             $this->pn_exist = 1;
    //         }
    //     } else {
    //         $this->pn_exist = 0;
    //     }
    // }

    public function insert()
    {
        if ($this->validate()) {

            $member = Member::create([
                'username' => $this->username,
                //   'phone_number' => $this->phone_number,
                'website_id' => session('website_id'),
            ]);

            MemberAccount::create([
                'member_id' => $member->id,
                'bank_id' => $this->bank_id,
                'number' => $this->account_number,
                'under_name' => $this->under_name,
            ]);

            flash('Berhasil Tambah Member', 'alert-success');

            $this->dispatch('reloadPowerGridMember');
        }
    }

    public function procceedMember()
    {
        if ($this->edit == 0) {

            $this->insert();
        } else {
            $this->updateMemberData();
        }
    }

    #[On('showCreateModalMember')]
    public function showCreateMember()
    {

        $this->edit = 0;

        $this->reset();

        $this->dispatch('showEditModalJS');
    }

    #[On('showEditModal')]
    public function showEdit($member_id)
    {

        $this->edit = 1;

        $this->member = Member::find($member_id);

        $this->username = $this->member->username;
        //    $this->phone_number = $this->member->phone_number;

        $this->dispatch('showEditModalJS');
    }

    public function updateMemberData()
    {
        if ($this->username_exist == 1) {
            flash('Username  telah terdaftar', 'alert-danger');
        } elseif ($this->username_exist == 0) {
            flash('Data tidak diupdate, karena tidak ada perubahan data', 'alert-info');
        } elseif ($this->username_exist != 1) {
            if ($this->validate()) {
                $this->member->username = $this->username;
                //   $this->member->phone_number = $this->phone_number;
                $this->member->save();
                flash('Data member berhasil diubah', 'alert-success');

                $this->dispatch('reloadPowerGridMember');
            } else {
                flash('Data tidak boleh kosong', 'alert-danger');
            }
        }
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Bank;
use App\Models\Currency;
use App\Models\Expenditure;
use App\Models\Member;
use App\Models\Privilege;
use App\Models\PrivilegeType;
use App\Models\Role;
use App\Models\Task;
use App\Models\Transaction;
use App\Models\Type;
use App\Models\User;
use App\Models\Website;
use App\Models\Whitelist;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->generatePrivileges();
        $this->generateWebsite();
        $this->generateUserandRole();
        $this->generateAccount();
        $this->generateType();
        $this->generateCurrencies();

        Whitelist::create(['ip_address' => '127.0.0.1']);

        // Member::factory(20)->create();
        // Transaction::factory(30)->create();
        // Expenditure::factory(15)->create();
        // Task::factory(25)->create();
    }

    public function generateUserandRole()
    {

        $roles = ['Costumer Service', 'Marketing', 'Admin', 'Super Admin'];
        $iteration = 1;
        foreach ($roles as $role) {

            //factory role
            Role::factory()->create([
                'name' => $role,
            ]);
            //end factory role

            //factory user

            $user = User::factory()->create([
                'name' => $role,
                'email' => str_replace(' ', '', $role) . '@gmail.com',
                'password' => bcrypt('password'),
                'role_id' => $iteration,

            ]);

            $user->privileges()->sync([2, 3, 4]);

            $iteration = $iteration + 1;
        }
    }

    public function generateAccount()
    {
        $accounts = [
            'BCA', 'BRI', 'Mandiri', 'BSI', 'BNI', 'CIMB', 'Danamon', 'Permata', 'BJB', 'PANIN', 'OCBC', 'DKI', 'SUMUT', 'NEO', 'JAGO', 'SeaBank', 'Jenius', 'DANA', 'OVO', 'ShopeePay', 'GOPAY',
            'LinkAja', 'Sakuku', 'AstraPay',
        ];

        foreach ($accounts as $account) {
            Bank::create([

                'name' => $account,

            ]);
        }
    }

    public function generateType()
    {
        $types = ['Withdraw', 'Deposit', 'Pengeluaran', 'Pemasukan'];

        foreach ($types as $type) {
            Type::factory()->create([
                'name' => $type,
            ]);
        }
    }

    public function generateCurrencies()
    {
        $currencies = ['BTC', 'USD', 'USDT', 'IDR'];

        foreach ($currencies as $currency) {
            Currency::create([
                'name' => $currency,
            ]);
        }
    }

    public function generateWebsite()
    {
        $websites = ['GPS TOTO', 'JAPRI SLOT', 'JPHK88', 'HKS188', 'TT Atas', 'Fitur Umum'];



        foreach ($websites as $website) {
            Website::create([
                'name' => $website,
            ]);
        }
    }

    public function generatePrivileges()
    {

        $p_types = ['Account', 'Service', 'Member', 'Pembukuan Kas', 'Pengeluaran', 'Lihat Transaksi', 'Lihat Log', 'Lihat Member', 'Lihat Buku Kas', 'Lihat Pengeluaran', 'Log', 'Rekening Admin', 'Rekening Member', 'Lihat Rekening Admin', 'TT Atas Level', 'Pinjam Atas Level', 'Lihat TT Atas', 'Lihat Pinjam Atas'];

        //type = 1 id 1-3
        $privilegeAccount = ['Ganti Password', 'Edit User Data', 'Lihat Dashboard'];
        //end type 1

        //type = 2 id 4-12
        $privilegeService = ['Lihat Deposit', 'Catat Deposit', 'Edit Deposit', 'Hapus Deposit', 'Lihat Withdraw', 'Catat Withdraw', 'Edit Withdraw', 'Hapus Withdraw', 'null'];
        //end type 2

        //ketika catat deposit atau wd sudah bisa tambah user

        //type = 3 id 13-15
        $privilegeMember = ['Lihat Member', 'Update Data Member', 'Hapus Member'];
        //end type 3

        //type = 4 id 16-19
        $privilegePembukuanKas = ['Lihat Kas', 'Catat Kas', 'Edit Kas', 'Hapus Kas'];
        //end type 4

        //type = 5 id 20-23
        $privilegePengeluaran = ['Lihat Pengeluaran', 'Catat Pengeluaran', 'Edit Pegeluaran', 'Hapus Pengeluaran'];
        //end type 5

        //type 6
        // id 24-29
        $privilegeLihatTransaksi = ['Username', 'Jenis Transaksi', 'Jumlah', 'Dari Rekening', 'Tujuan Rekening', 'Tanggal'];

        //type 7
        // id 30 - 35
        $privilegeLihatLog = ['Tanggal', 'Username', 'Ip', 'Aktivitas', 'Target', 'Deskripsi'];

        //type 8
        // id 36-39
        $privilegeLihatMember =
            [
                'Username', 'Total Depo', 'Total Withdraw', 'Depo - Withdraw',
            ];

        //type 9
        //40-44
        $privilegeLihatBukuKas = [
            'Type', 'Jumlah', 'Detail', 'User', 'Tanggal',
        ];

        //type 10
        //45-50
        $privilegeLihatPengeluaran = [
            'Tanggal', 'User', 'Jumlah', 'Mata Uang', 'Detail', 'Bank',
        ];

        //type 11
        //51-54
        $privilegeLog = ['Tambah Log', 'Lihat Log', 'Update Log', 'Delete Log'];

        //type 12
        //55-58
        $privilegeRekeningAdmin = ['Tambah Rekening Admin', 'Lihat Rekening Admin', 'Update Rekening Admin', 'Delete Rekening Admin'];

        //type 13
        //59 - 62

        $privilegeRekeningMember = ['Tambah Rekening Member', 'Lihat Rekening Member', 'Update Rekening Member', 'Delete Rekening Member'];

        //type 14
        //63 - 67

        $privilegeLihatAdminAccount = ['Bank', 'Website', 'Nomor Rekening', 'Atas Nama', 'Saldo'];

        //type 15
        //68 - 71
        $privilegeTTAtas = ['Lihat TT Atas', 'Tambah TT ATas', 'Update TT Atas', 'Delete TT Atas'];

        //type 16
        //72 - 75
        $privilegePinjamAtas = ['Lihat Pinjam Atas', 'Tambah Pinjam ATas', 'Update Pinjam Atas', 'Delete Pinjam Atas'];

        //type 17
        //76-80

        $privilegeLihatTTAtas = ['Website', 'Rekening TT Atas', 'Rekening Website', 'Jumlah', 'Tanggal'];

        //type 18
        //81-85

        $privilegeLihatPinjamAtas = ['Website', 'Rekening Pinjam Atas', 'Rekening Website', 'Jumlah', 'Tanggal'];


        $iteration = 1;

        foreach ($p_types as $type) {
            PrivilegeType::create([
                'name' => $type,
            ]);

            $x = null;

            switch ($iteration) {
                case 1:
                    $x = $privilegeAccount;
                    break;
                case 2:
                    $x = $privilegeService;
                    break;
                case 3:
                    $x = $privilegeMember;
                    break;
                case 4:
                    $x = $privilegePembukuanKas;
                    break;
                case 5:
                    $x = $privilegePengeluaran;
                    break;
                case 6:
                    $x = $privilegeLihatTransaksi;
                    break;
                case 7:
                    $x = $privilegeLihatLog;
                    break;
                case 8:
                    $x = $privilegeLihatMember;
                    break;
                case 9:
                    $x = $privilegeLihatBukuKas;
                    break;
                case 10:
                    $x = $privilegeLihatPengeluaran;
                    break;
                case 11:
                    $x = $privilegeLog;
                    break;
                case 12:
                    $x = $privilegeRekeningAdmin;
                    break;
                case 13:
                    $x = $privilegeRekeningMember;
                    break;
                case 14:
                    $x = $privilegeLihatAdminAccount;
                    break;
                case 15:
                    $x = $privilegeTTAtas;
                    break;
                case 16:
                    $x = $privilegePinjamAtas;
                    break;
                case 17:
                    $x = $privilegeLihatTTAtas;
                    break;
                case 18:
                    $x = $privilegeLihatPinjamAtas;
                    break;
            }

            foreach ($x as $item) {
                Privilege::create([
                    'name' => $item,
                    'privilege_type_id' => $iteration,
                ]);
            }

            $iteration++;
        }
    }
}

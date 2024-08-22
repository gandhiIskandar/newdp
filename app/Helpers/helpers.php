<?php

if (! function_exists('toBaht')) {
    function toBaht($amount)
    {

        return '฿ '.number_format($amount, 0, ',', '.');
    }
}

if (! function_exists('updateSaldoRekeningAdmin')) {

    function updateSaldoRekeningAdmin($account_id, $balance, $ket)
    {

        $account = App\Models\Account::find($account_id);

        if ($ket == 'tambah') {
            $account->balance += $balance;
        } else {
            $account->balance -= $balance;
        }

        $account->save();
    }
}

if (! function_exists('insertLog')) {

    function insertLog($username, $ip, $activity, $target, $deskripsi, $key)
    {

        $data = [
            'username' => $username,
            'ip' => $ip,
            'website_id' => session('website_id'),
            'activity' => $activity,
            'deskripsi' => $deskripsi,

        ];

        //key 0 :member, key 1 :user, key 2 : keterangan tambahan

        if ($key == 0) {
            $data['member_id'] = $target;
        } elseif ($key == 1) {
            $data['user_id'] = $target;
        } else {
            $data['keterangan'] = $target;
        }

        App\Models\Log::create($data);
    }
}

if (! function_exists('toRupiah')) {
    function toRupiah($amount, $prefix = false)
    {
        if ($prefix) {
            return 'Rp '.number_format($amount, 0, ',', '.');
        }

        return number_format($amount, 0, ',', '.');
    }
}

if (! function_exists('changeToComa')) {
    function changeToComa($amount)
    {

        return str_replace('.', ',', $amount);
    }
}

if (! function_exists('changeToDot')) {
    function changeToDot($amount)
    {

        return str_replace(',', '.', $amount);
    }
}

if (! function_exists('privilegeViewTransaction')) {
    function privilegeViewTransaction()
    {
        return in_array(4, session('privileges')) || in_array(8, session('privileges'));
    }
}

if (! function_exists('privilegeAddTransaction')) {
    function privilegeAddTransaction()
    {
        return in_array(5, session('privileges')) || in_array(9, session('privileges'));
    }
}

if (! function_exists('privilegeAddDeposit')) {
    function privilegeAddDeposit()
    {
        return in_array(5, session('privileges'));
    }
}
if (! function_exists('privilegeAddWithdraw')) {
    function privilegeAddWithdraw()
    {
        return in_array(9, session('privileges'));
    }
}

if (! function_exists('privilegeEditWithdraw')) {
    function privilegeEditWithdraw()
    {
        return in_array(10, session('privileges'));
    }
}

if (! function_exists('privilegeEditDeposit')) {
    function privilegeEditDeposit()
    {
        return in_array(6, session('privileges'));
    }
}

if (! function_exists('privilegeRemoveWithdraw')) {
    function privilegeRemoveWithdraw()
    {
        return in_array(11, session('privileges'));
    }
}

if (! function_exists('privilegeRemoveDeposit')) {
    function privilegeRemoveDeposit()
    {
        return in_array(7, session('privileges'));
    }
}

if (! function_exists('privilegeEditTransaction')) {
    function privilegeEditTransaction()
    {
        return privilegeEditDeposit() || privilegeEditWithdraw();
    }
}

if (! function_exists('privilegeRemoveTransaction')) {
    function privilegeRemoveTransaction()
    {
        return privilegeRemoveDeposit() || privilegeRemoveWithdraw();
    }
}

if (! function_exists('privilegeChangePassword')) {
    function privilegeChangePassword()
    {
        return in_array(1, session('privileges'));
    }
}

if (! function_exists('privilegeEditUserData')) {
    function privilegeEditUserData()
    {
        return in_array(2, session('privileges'));
    }
}

if (! function_exists('privilegeViewDashboard')) {
    function privilegeViewDashboard()
    {
        return in_array(3, session('privileges'));
    }
}

if (! function_exists('privilegeViewMember')) {
    function privilegeViewMember()
    {
        return in_array(13, session('privileges'));
    }
}

if (! function_exists('privilegeEditMember')) {
    function privilegeEditMember()
    {
        return in_array(14, session('privileges'));
    }
}

if (! function_exists('privilegeRemoveMember')) {
    function privilegeRemoveMember()
    {
        return in_array(15, session('privileges'));
    }
}

if (! function_exists('privilegeViewCashBook')) {
    function privilegeViewCashBook()
    {
        return in_array(16, session('privileges'));
    }
}

if (! function_exists('privilegeAddCashBook')) {
    function privilegeAddCashBook()
    {
        return in_array(17, session('privileges'));
    }
}

if (! function_exists('privilegeEditCashBook')) {
    function privilegeEditCashBook()
    {
        return in_array(18, session('privileges'));
    }
}

if (! function_exists('privilegeRemoveCashBook')) {
    function privilegeRemoveCashBook()
    {
        return in_array(19, session('privileges'));
    }
}

if (! function_exists('privilegeViewExpenditure')) {
    function privilegeViewExpenditure()
    {
        return in_array(20, session('privileges'));
    }
}

if (! function_exists('privilegeAddExpenditure')) {
    function privilegeAddExpenditure()
    {
        return in_array(21, session('privileges'));
    }
}

if (! function_exists('privilegeEditExpenditure')) {
    function privilegeEditExpenditure()
    {
        return in_array(22, session('privileges'));
    }
}

if (! function_exists('privilegeRemoveExpenditure')) {
    function privilegeRemoveExpenditure()
    {
        return in_array(23, session('privileges'));
    }
}

if (! function_exists('privilegeViewUsernameTransaction')) {
    function privilegeViewUsernameTransaction()
    {
        return in_array(24, session('privileges'));
    }
}
if (! function_exists('privilegeViewTypeTransaction')) {
    function privilegeViewTypeTransaction()
    {
        return in_array(25, session('privileges'));
    }
}
if (! function_exists('privilegeViewAmountTransaction')) {
    function privilegeViewAmountTransaction()
    {
        return in_array(26, session('privileges'));
    }
}
if (! function_exists('privilegeViewFromAccountTransaction')) {
    function privilegeViewFromAccountTransaction()
    {
        return in_array(27, session('privileges'));
    }
}
if (! function_exists('privilegeViewToAccountTransaction')) {
    function privilegeViewToAccountTransaction()
    {
        return in_array(28, session('privileges'));
    }
}
if (! function_exists('privilegeViewDateTransaction')) {
    function privilegeViewDateTransaction()
    {
        return in_array(29, session('privileges'));
    }
}

if (! function_exists('privilegeViewDateLog')) {
    function privilegeViewDateLog()
    {
        return in_array(30, session('privileges'));
    }
}if (! function_exists('privilegeViewUsernameLog')) {
    function privilegeViewUsernameLog()
    {
        return in_array(31, session('privileges'));
    }
}if (! function_exists('privilegeViewIpLog')) {
    function privilegeViewIpLog()
    {
        return in_array(32, session('privileges'));
    }
}if (! function_exists('privilegeViewActivityLog')) {
    function privilegeViewActivityLog()
    {
        return in_array(33, session('privileges'));
    }
}
if (! function_exists('privilegeViewTargetLog')) {
    function privilegeViewTargetLog()
    {
        return in_array(34, session('privileges'));
    }
}
if (! function_exists('privilegeViewDeskripsiLog')) {
    function privilegeViewDeskripsiLog()
    {
        return in_array(35, session('privileges'));
    }
}

if (! function_exists('privilegeViewUsernameMember')) {
    function privilegeViewUsernameMember()
    {
        return in_array(36, session('privileges'));
    }
}if (! function_exists('privilegeViewTotalDepoMember')) {
    function privilegeViewTotalDepoMember()
    {
        return in_array(37, session('privileges'));
    }
}if (! function_exists('privilegeViewTotalWithdrawMember')) {
    function privilegeViewTotalWithdrawMember()
    {
        return in_array(38, session('privileges'));
    }
}if (! function_exists('privilegeViewSumMember')) {
    function privilegeViewSumMember()
    {
        return in_array(39, session('privileges'));
    }
}if (! function_exists('privilegeViewTypeCash')) {
    function privilegeViewTypeCash()
    {
        return in_array(40, session('privileges'));
    }
}if (! function_exists('privilegeViewAmountCash')) {
    function privilegeViewAmountCash()
    {
        return in_array(41, session('privileges'));
    }
}if (! function_exists('privilegeViewDetailCash')) {
    function privilegeViewDetailCash()
    {
        return in_array(42, session('privileges'));
    }
}if (! function_exists('privilegeViewUserCash')) {
    function privilegeViewUserCash()
    {
        return in_array(43, session('privileges'));
    }
}if (! function_exists('privilegeViewDateCash')) {
    function privilegeViewDateCash()
    {
        return in_array(44, session('privileges'));
    }
}if (! function_exists('privilegeViewDateExp')) {
    function privilegeViewDateExp()
    {
        return in_array(45, session('privileges'));
    }
}if (! function_exists('privilegeViewUserExp')) {
    function privilegeViewUserExp()
    {
        return in_array(46, session('privileges'));
    }
}if (! function_exists('privilegeViewAmountExp')) {
    function privilegeViewAmountExp()
    {
        return in_array(47, session('privileges'));
    }
}if (! function_exists('privilegeViewCurrencyExp')) {
    function privilegeViewCurrencyExp()
    {
        return in_array(48, session('privileges'));
    }
}if (! function_exists('privilegeViewDetailExp')) {
    function privilegeViewDetailExp()
    {
        return in_array(49, session('privileges'));
    }
}if (! function_exists('privilegeViewBankExp')) {
    function privilegeViewBankExp()
    {
        return in_array(50, session('privileges'));
    }
}
if (! function_exists('privilegeAddLog')) {
    function privilegeAddLog()
    {
        return in_array(51, session('privileges'));
    }
}if (! function_exists('privilegeViewLog')) {
    function privilegeViewLog()
    {
        return in_array(52, session('privileges'));
    }
}if (! function_exists('privilegeUpdateLog')) {
    function privilegeUpdateLog()
    {
        return in_array(53, session('privileges'));
    }
}if (! function_exists('privilegeDeleteLog')) {
    function privilegeDeleteLog()
    {
        return in_array(54, session('privileges'));
    }
}
if (! function_exists('privilegeAddAdminAccount')) {
    function privilegeAddAdminAccount()
    {
        return in_array(55, session('privileges'));
    }
}if (! function_exists('privilegeViewAdminAccount')) {
    function privilegeViewAdminAccount()
    {
        return in_array(56, session('privileges'));
    }
}if (! function_exists('privilegeUpdateAdminAccount')) {
    function privilegeUpdateAdminAccount()
    {
        return in_array(57, session('privileges'));
    }
}if (! function_exists('privilegeDeleteAdminAccount')) {
    function privilegeDeleteAdminAccount()
    {
        return in_array(58, session('privileges'));
    }
}
if (! function_exists('privilegeAddMemberAccount')) {
    function privilegeAddMemberAccount()
    {
        return in_array(59, session('privileges'));
    }
}if (! function_exists('privilegeViewMemberAccount')) {
    function privilegeViewMemberAccount()
    {
        return in_array(60, session('privileges'));
    }
}if (! function_exists('privilegeUpdateMemberAccount')) {
    function privilegeUpdateMemberAccount()
    {
        return in_array(61, session('privileges'));
    }
}
if (! function_exists('privilegeDeleteMemberAccount')) {
    function privilegeDeleteMemberAccount()
    {
        return in_array(62, session('privileges'));
    }
}
if (! function_exists('privilegeViewBankAdminAccount')) {
    function privilegeViewBankAdminAccount()
    {
        return in_array(63, session('privileges'));
    }
}
if (! function_exists('privilegeViewWebsiteAdminAccount')) {
    function privilegeViewWebsiteAdminAccount()
    {
        return in_array(64, session('privileges'));
    }
}if (! function_exists('privilegeViewNumberAdminAccount')) {
    function privilegeViewNumberAdminAccount()
    {
        return in_array(65, session('privileges'));
    }
}if (! function_exists('privilegeViewNameAdminAccount')) {
    function privilegeViewNameAdminAccount()
    {
        return in_array(66, session('privileges'));
    }
}if (! function_exists('privilegeViewBalanceAdminAccount')) {
    function privilegeViewBalanceAdminAccount()
    {
        return in_array(67, session('privileges'));
    }
}
if (! function_exists('privilegeViewTTAtas')) {
    function privilegeViewTTAtas()
    {
        return in_array(68, session('privileges'));
    }
}if (! function_exists('privilegeCreateTTAtas')) {
    function privilegeCreateTTAtas()
    {
        return in_array(69, session('privileges'));
    }
}if (! function_exists('privilegeUpdateTTAtas')) {
    function privilegeUpdateTTAtas()
    {
        return in_array(70, session('privileges'));
    }
}if (! function_exists('privilegeDeleteTTAtas')) {
    function privilegeDeleteTTAtas()
    {
        return in_array(71, session('privileges'));
    }
}

if (! function_exists('privilegeViewPinjamAtas')) {
    function privilegeViewPinjamAtas()
    {
        return in_array(72, session('privileges'));
    }
}if (! function_exists('privilegeCreatePinjamAtas')) {
    function privilegeCreatePinjamAtas()
    {
        return in_array(73, session('privileges'));
    }
}if (! function_exists('privilegeUpdatePinjamAtas')) {
    function privilegeUpdatePinjamAtas()
    {
        return in_array(74, session('privileges'));
    }
}if (! function_exists('privilegeDeletePinjamAtas')) {
    function privilegeDeletePinjamAtas()
    {
        return in_array(75, session('privileges'));
    }
}
if (! function_exists('privilegeViewWebsiteTTAtas')) {
    function privilegeViewWebsiteTTAtas()
    {
        return in_array(76, session('privileges'));
    }
}if (! function_exists('privilegeViewRekeningTransferTTAtas')) {
    function privilegeViewRekeningTransferTTAtas()
    {
        return in_array(77, session('privileges'));
    }
}if (! function_exists('privilegeViewRekeningWebsiteTTAtas')) {
    function privilegeViewRekeningWebsiteTTAtas()
    {
        return in_array(78, session('privileges'));
    }
}if (! function_exists('privilegeViewAmountTTAtas')) {
    function privilegeViewAmountTTAtas()
    {
        return in_array(79, session('privileges'));
    }
}
if (! function_exists('privilegeViewDateTTAtas')) {
    function privilegeViewDateTTAtas()
    {
        return in_array(80, session('privileges'));
    }
}
if (! function_exists('privilegeViewWebsitePinjamAtas')) {
    function privilegeViewWebsitePinjamAtas()
    {
        return in_array(81, session('privileges'));
    }
}if (! function_exists('privilegeViewRekeningTransferPinjamAtas')) {
    function privilegeViewRekeningTransferPinjamAtas()
    {
        return in_array(82, session('privileges'));
    }
}if (! function_exists('privilegeViewRekeningWebsitePinjamAtas')) {
    function privilegeViewRekeningWebsitePinjamAtas()
    {
        return in_array(83, session('privileges'));
    }
}if (! function_exists('privilegeViewAmountPinjamAtas')) {
    function privilegeViewAmountPinjamAtas()
    {
        return in_array(84, session('privileges'));
    }
}if (! function_exists('privilegeViewDatePinjamAtas')) {
    function privilegeViewDatePinjamAtas()
    {
        return in_array(85, session('privileges'));
    }
}
<?php

namespace App\Services\Manage;

use App\Models\Manage\Wallet as WalletModel;
use Illuminate\Support\Facades\Auth;

class WalletService {

    /**
     * @param $data
     * @return int|null
     */
    public function store($data):? int
    {
        $data['owner_id']   = Auth::id();

        return WalletModel::create($data)->wallet_id;
    }

    /**
     * @param WalletModel $wallet
     * @param array $data
     * @return void
     */
    public function update(WalletModel $wallet, array $data): void
    {
        $data['owner_id']   = Auth::id();

        $wallet->update($data);
    }

    /**
     * @param WalletModel $wallet
     * @return bool
     */
    public function destroy(WalletModel $wallet): bool
    {
        return $wallet->delete();
    }
}

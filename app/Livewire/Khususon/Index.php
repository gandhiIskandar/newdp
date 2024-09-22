<?php

namespace App\Livewire\Khususon;

use App\Models\Task;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]

class Index extends Component
{
    public $totalUsersToday;

    public $totalTransaksi;

    public $error = null;

    public $tasks;

    public $finishedTask = [];

    public $transactions;

    public $currencyData;

    //TODO KONFIGURASI BAGAIMANA CARANYA KETIKA SELECT BERUBAH MAKA AKAN REFRESH!! PAKAI JQUERY ONCHANGE, SEBELUM REFRESH KIRIM DISPATCH DLU KE FUNC PHP UNTUK SET SESSION

    public function render()
    {

        // dd(Route::current());

        // dd($this->getWebSummary());

        $this->getStat();
        $this->getTodoList();
        $this->proccessDataStats();

        return view('livewire.khususon.index');
    }

    #[\Livewire\Attributes\On('reloadTransaction')]
    public function getStat()
    {
        $db = DB::table('transactions');
        if (session('website_id') != 6) {
            $db->where('website_id', session('website_id'));
        }
        $totals = $db
            ->whereDate('created_at', Carbon::today())

            ->selectRaw('
            SUM(CASE WHEN type_id = 1 THEN amount ELSE 0 END) AS total_wd,
            SUM(CASE WHEN type_id = 2 AND new = 0 THEN amount ELSE 0 END) AS total_re_depo,
            SUM(CASE WHEN type_id = 2 AND new = 1 THEN amount ELSE 0 END) AS total_new_depo
        ')
            ->first();

        $this->totalTransaksi = $totals;

        $this->transactions = Transaction::with(['member', 'type'])->whereDate('created_at', Carbon::today())->where('website_id', session('website_id'))->orderBy('created_at', 'desc')->get();
    }


    public function getTodoList()
    {

        $user = session('user_data');

        $this->tasks = Task::where('user_id', $user->id)->where('is_completed', 0)->get();
    }

    public function updateTask()
    {

        Task::whereIn('id', $this->finishedTask)->update(['is_completed' => 1]);

        $this->finishedTask = [];
    }

    public function getCurrencyAPI($base, $target, $key)
    { //default = USD

        $response = Cache::remember($key,120,function()use($base, $target){
           return Http::get("https://api.freecurrencyapi.com/v1/latest?apikey=fca_live_52gDWLXcOQ6eRGarR3sLdQXCg5v2IAyIJj6PoJJb&currencies=$target&base_currency=$base")->json();
        }); 

  
        return $response;
    }

    public function proccessDataStats()
    {

        try {

            $listCoins = $this->getCryptoDataAPI();

            $btc = $listCoins[0];
            $usdt = $listCoins[2];

            $usd_to_idr = $this->getCurrencyAPI('USD', 'IDR', 'usd')['data']['IDR'];

            $price_btc = $btc['price'] * $usd_to_idr; //usd dikalikan ke rupiah untuk mengetahui harga btc dan usdt

            $price_usdt = $usdt['price'] * $usd_to_idr;

            $bath_to_idr = $this->getCurrencyAPI('THB', 'IDR', 'thb')['data']['IDR'];

          

            $data = [
                (object) [
                    'currency' => 'BTC',
                    'price' => toRupiah(intval($price_btc), true),
                    'isCrypto' => true,
                    'src' => $btc['iconUrl'],
                ],
                (object) [
                    'currency' => 'USDT',
                    'price' => toRupiah(intval($price_usdt), true),
                    'isCrypto' => true,
                    'src' => $usdt['iconUrl'],
                ],
                (object) [
                    'currency' => 'USD',
                    'price' => toRupiah(intval($usd_to_idr), true),
                    'isCrypto' => false,
                    'src' => 'ph-duotone ph-currency-circle-dollar',
                ],
                (object) [
                    'currency' => 'BATH',
                    'price' => toRupiah(intval($bath_to_idr), true),
                    'isCrypto' => false,
                    'src' => 'ph-duotone ph-currency-btc',
                ],
            ];

            $this->currencyData = collect($data);
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            $this->error = 'Terjadi kesalahan dalam pemanggilan API, Mohon periksa koneksi internet';
        } catch (Exception $e) {
            $this->error = 'Terjadi kesalahan dalam pemanggilan API';
        }
    }

    public function getCryptoDataAPI()
    { 

        $response = Http::get('https://api.coinranking.com/v2/coins');

        return $response->json()['data']['coins'];
    }
}

<?php


namespace App\Components;


use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class PolygonApi
{

    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $apiKey;

    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $cryptoUrl;

    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $currencyUrl;

    /**
     * @var
     */
    private $currentDate;

    /**
     * @var \string[][]
     */
    private $currencyCods = [
        'X:BTCUSD' => ['symbol' => 'Bitcoin', 'name' => 'BTC'],
        'X:LTCUSD' => ['symbol' => 'Litecoin', 'name' => 'LTC'],
        'X:DOTUSD' => ['symbol' => 'Polkadot', 'name' => 'DOT'],
        'X:DOGEUSD' => ['symbol' => 'Dogecoin', 'name' => 'DOGE'],
        'X:ETCUSD' => ['symbol' => 'Ethereum', 'name' => 'ETH'],
        'X:BTCEUR' => ['symbol' => 'Bitcoin', 'name' => 'BTC'],
        'X:LTCEUR' => ['symbol' => 'Litecoin', 'name' => 'LTC'],
        'X:DOTEUR' => ['symbol' => 'Polkadot', 'name' => 'DOT'],
        'X:DOGEEUR' => ['symbol' => 'Dogecoin', 'name' => 'DOGE'],
        'X:ETCEUR' => ['symbol' => 'Ethereum', 'name' => 'ETH'],
    ];

    /**
     * @var
     */
    private $crypto;

    /**
     * Class constants.
     */
    private const EUR = 'EUR';
    private const USD = 'USD';
    private const EMPTY_VAL = 'No data.';

    /**
     * PolygonApi constructor.
     */
    public function __construct($currentDate)
    {
        $this->currentDate = $currentDate;
        $this->apiKey = config('app.apiKey');
        $this->cryptoUrl = config('app.cryptoUrl');
        $this->currencyUrl = config('app.currencyUrl');
    }

    /**
     * @return array
     */
    public function getCryptoByDay()
    {
        $result = $this->getCryptoData();
        if ($result['status'] === 'error') {
            return $result;
        }
        foreach ($result['response'] as $item) {
            if (in_array($item->T, array_keys($this->currencyCods))) {
                $this->crypto[$item->T] = $item;
            }
        }
        return [
            'status' => 'ok',
            'response' => $this->crypto
        ];
    }

    /**
     * @return array
     */
    function getCryptoData()
    {
        $url = sprintf($this->cryptoUrl, $this->currentDate) . $this->apiKey;
        $response = Http::get($url);
        if ($response->object()->status === 'ERROR') {
            return [
                'status' => 'error',
                'message' => $response->object()->error
            ];
        }
        return [
            'status' => 'ok',
            'response' => $response->object()->results
        ];
    }

    /**
     * @return array
     */
    public function prepareToVisible()
    {
        $cCurrencies = [];
        $crypto = $this->crypto;
        foreach ($this->currencyCods as $key => $val) {
            $currency = self::USD;
            if (strpos($key, self::EUR)) {
                $currency = self::EUR;
            }
            $cCurrencies[$currency][$key]['name'] = $val['name'];
            $cCurrencies[$currency][$key]['symbol'] = $val['symbol'];
            $cCurrencies[$currency][$key]['opening_price'] = isset($crypto[$key]) ? round($crypto[$key]->o, 2) : self::EMPTY_VAL;
            $cCurrencies[$currency][$key]['closing_price'] = isset($crypto[$key]) ? round($crypto[$key]->c, 2) : self::EMPTY_VAL;
            $cCurrencies[$currency][$key]['change'] = isset($crypto[$key]) ? abs(round((1 - $crypto[$key]->c / $crypto[$key]->o) * 100, 2)) : self::EMPTY_VAL;
        }
        return $cCurrencies;
    }
}
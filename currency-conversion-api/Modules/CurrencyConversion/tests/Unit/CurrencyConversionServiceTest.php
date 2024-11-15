<?php

namespace Modules\CurrencyConversion\Tests\Unit;

use Modules\CurrencyConversion\Http\Dtos\CurrencyConversionDto;
use Modules\CurrencyConversion\Http\Repositories\Interfaces\ICurrencyConversionRepository;
use Modules\CurrencyConversion\Http\Repositories\Interfaces\ISupportedCurrencyRepository;
use Modules\CurrencyConversion\Http\Services\CurrencyConversionService;
use Tests\TestCase;
use Modules\CurrencyConversion\Models\Currency;
use Carbon\Carbon;

class CurrencyConversionServiceTest extends TestCase
{
    public function test_get_currency_calculation()
    {
        $supportedCurrencyRepository = $this->createMock(ISupportedCurrencyRepository::class);
        $currencyConversionRepository = $this->createMock(ICurrencyConversionRepository::class);

        // Mock the Currency model instance to simulate lastRates() return value
        $mockCurrency = new Currency();

        // Set up the mock Currency instance to return a JSON string of rates
        $mockCurrency->json = json_encode([
            "AED" => 3.996561,
            "AFN" => 72.725294,
            "ALL" => 98.323637,
            "AMD" => 420.572784,
            "ANG" => 1.958573,
            "AOA" => 991.788876,
            "ARS" => 1076.134061,
            "AUD" => 1.658911,
            "AWG" => 1.961263,
            "AZN" => 1.854055,
            "BAM" => 1.955673,
            "BBD" => 2.194258,
            "BDT" => 129.861596,
            "BGN" => 1.955673,
            "BHD" => 0.409773,
            "BIF" => 3157.495671,
            "BMD" => 1.08808,
            "BND" => 1.438807,
            "BOB" => 7.536512,
            "BRL" => 6.202599,
            "BSD" => 1.08673,
            "BTC" => 0.000016025179,
            "BTN" => 91.400085,
            "BWP" => 14.52806,
            "BYN" => 3.55647,
            "BYR" => 21326.35992,
            "BZD" => 2.190558,
            "CAD" => 1.518035,
            "CDF" => 3141.834075,
            "CHF" => 0.940411,
            "CLF" => 0.037867,
            "CLP" => 1044.862384,
            "CNY" => 7.750069,
            "CNH" => 7.74636,
            "COP" => 4807.788876,
            "CRC" => 557.263938,
            "CUC" => 1.08808,
            "CUP" => 28.834109,
            "CVE" => 110.257865,
            "CZK" => 25.448554,
            "DJF" => 193.517477,
            "DKK" => 7.490671,
            "DOP" => 65.395768,
            "DZD" => 144.348659,
            "EGP" => 53.012569,
            "ERN" => 16.321194,
            "ETB" => 130.513654,
            "EUR" => 1,
            "FJD" => 2.449054,
            "FKP" => 0.832565,
            "GBP" => 0.842134,
            "GEL" => 2.975941,
            "GGP" => 0.832565,
            "GHS" => 17.713854,
            "GIP" => 0.832565,
            "GMD" => 77.801881,
            "GNF" => 9372.39349,
            "GTQ" => 8.396457,
            "GYD" => 227.255294,
            "HKD" => 8.462217,
            "HNL" => 27.394227,
            "HRK" => 7.495813,
            "HTG" => 143.010745,
            "HUF" => 410.101365,
            "IDR" => 17244.973386,
            "ILS" => 4.083046,
            "IMP" => 0.832565,
            "INR" => 91.544325,
            "IQD" => 1423.607875,
            "IRR" => 45799.994199,
            "ISK" => 149.556959,
            "JEP" => 0.832565,
            "JMD" => 172.258853,
            "JOD" => 0.771562,
            "JPY" => 166.427256,
            "KES" => 140.190928,
            "KGS" => 93.361362,
            "KHR" => 4416.714184,
            "KMF" => 493.825338,
            "KPW" => 979.271384,
            "KRW" => 1501.920195,
            "KWD" => 0.333617,
            "KYD" => 0.905641,
            "KZT" => 531.465608,
            "LAK" => 23851.456515,
            "LBP" => 97316.602407,
            "LKR" => 318.359398,
            "LRD" => 208.656497,
            "LSL" => 19.126862,
            "LTL" => 3.212817,
            "LVL" => 0.658169,
            "LYD" => 5.236661,
            "MAD" => 10.680109,
            "MDL" => 19.452741,
            "MGA" => 5009.675812,
            "MKD" => 61.606013,
            "MMK" => 3534.040058,
            "MNT" => 3697.294469,
            "MOP" => 8.705337,
            "MRU" => 43.145208,
            "MUR" => 49.899742,
            "MVR" => 16.767718,
            "MWK" => 1884.378057,
            "MXN" => 22.063032,
            "MYR" => 4.764161,
            "MZN" => 69.539577,
            "NAD" => 19.126862,
            "NGN" => 1792.615173,
            "NIO" => 39.987412,
            "NOK" => 11.960672,
            "NPR" => 146.240536,
            "NZD" => 1.824566,
            "OMR" => 0.417113,
            "PAB" => 1.08683,
            "PEN" => 4.101835,
            "PGK" => 4.355718,
            "PHP" => 63.505807,
            "PKR" => 301.784871,
            "PLN" => 4.358718,
            "PYG" => 8585.444415,
            "QAR" => 3.961644,
            "RON" => 4.994725,
            "RSD" => 117.042426,
            "RUB" => 106.493109,
            "RWF" => 1485.903844,
            "SAR" => 4.086178,
            "SBD" => 9.05275,
            "SCR" => 14.801342,
            "SDG" => 654.483872,
            "SEK" => 11.534345,
            "SGD" => 1.443124,
            "SHP" => 0.832565,
            "SLE" => 24.754214,
            "SLL" => 22816.481435,
            "SOS" => 621.05981,
            "SRD" => 37.663916,
            "STD" => 22521.050642,
            "SVC" => 9.508385,
            "SYP" => 2733.832898,
            "SZL" => 19.121763,
            "THB" => 36.967545,
            "TJS" => 11.551952,
            "TMT" => 3.808279,
            "TND" => 3.365082,
            "TOP" => 2.548395,
            "TRY" => 37.349968,
            "TTD" => 7.366523,
            "TWD" => 34.750872,
            "TZS" => 2934.21012,
            "UAH" => 44.914893,
            "UGX" => 3978.742526,
            "USD" => 1.08808,
            "UYU" => 45.007087,
            "UZS" => 13905.100167,
            "VEF" => 3941625.468227,
            "VES" => 46.573289,
            "VND" => 27528.41357,
            "VUV" => 129.179027,
            "WST" => 3.047911,
            "XAF" => 655.914554,
            "XAG" => 0.032257,
            "XAU" => 0.0004,
            "XCD" => 2.94059,
            "XDR" => 0.816847,
            "XOF" => 655.914554,
            "XPF" => 119.331742,
            "YER" => 272.40112,
            "ZAR" => 19.216251,
            "ZMK" => 9794.025888,
            "ZMW" => 29.151114,
            "ZWL" => 350.361183,
        ]);

        // Configure the currencyConversionRepository mock to return the mock Currency instance
        $currencyConversionRepository->method('lastRates')->willReturn($mockCurrency);

        // Instantiate the service with the mocked dependencies
        $currencyConversionService = new CurrencyConversionService(
            $supportedCurrencyRepository,
            $currencyConversionRepository
        );

        // Define different currency conversion scenarios
        $scenarios = [
            ['from' => 'MKD', 'to' => 'USD', 'amount' => 1000, 'expected' => (1000 / 61.606013) * 1.08808],
            ['from' => 'EUR', 'to' => 'AED', 'amount' => 100, 'expected' => 100 * 3.996561],
            ['from' => 'USD', 'to' => 'AFN', 'amount' => 50, 'expected' => (50 / 1.08808) * 72.725294],
            ['from' => 'GBP', 'to' => 'CAD', 'amount' => 200, 'expected' => (200 / 0.842134) * 1.518035],
            ['from' => 'JPY', 'to' => 'CNY', 'amount' => 5000, 'expected' => (5000 / 166.427256) * 7.750069],
        ];

        foreach ($scenarios as $scenario) {
            $dto = new CurrencyConversionDto($scenario['from'], $scenario['to'], $scenario['amount']);

            // Perform the calculation
            $result = $currencyConversionService->getCurrencyCalculation($dto);

            // Assert the expected structure and calculated value
            $this->assertIsArray($result);
            $this->assertArrayHasKey('from', $result);
            $this->assertArrayHasKey('to', $result);
            $this->assertArrayHasKey('amount', $result);
            $this->assertArrayHasKey('amountCalculated', $result);

            // Additional assertions to verify the correctness of the calculation
            $this->assertEquals($scenario['from'], $result['from']);
            $this->assertEquals($scenario['to'], $result['to']);
            $this->assertEquals($scenario['amount'], $result['amount']);

            // Assert the calculated amount is close to the expected result
            $this->assertEqualsWithDelta($scenario['expected'], $result['amountCalculated'], 0.01);
        }
    }
}

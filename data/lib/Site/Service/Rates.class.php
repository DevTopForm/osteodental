<?php

class Site_Service_Rates{

	public static function GetRates($fromCache = true)
	{
		$cacheFileName = 'cache/rates.dat';

		//CONFIG
		$validCurrencies = array('EUR', 'USD', 'UAH');//RUR valid by default
		$currNames = array(
			'RUR' => 'Российский рубль',
			'USD' => 'Доллар США',
			'EUR' => 'Евро',
			'UAH' => 'Украинская гривна'
		);
		$currChars = array(
			'RUR' => '<span class="RUR"></span>',
			'USD' => '<span>$</span>',
			'EUR' => '<span>€</span>',
			'UAH' => '<span class="GRVN"></span>'
		);
		$currCharsPos = array(
			'RUR' => 'pre',
			'USD' => 'pre',
			'EUR' => 'pre',
			'UAH' => 'post'
		);
		//

		if (is_file($cacheFileName)) {
			$fileTime = filemtime($cacheFileName);

			if ((time() - $fileTime) > 3600) {
				$fromCache = false;
			}

		} else {
			$fromCache = false;
		}

		$rates = array(
			'RUR' => array(
				'code' => 'RUR',
				'char' => $currChars['RUR'],
				'charPos' => $currCharsPos['RUR'],
				'name' => $currNames['RUR'],
				'value' => 1
			)
		);

		if ($fromCache) {
			$rates = unserialize(file_get_contents($cacheFileName));

		} else {
			$ratesXML = simplexml_load_file('http://www.cbr.ru/scripts/XML_daily.asp');

			foreach ($ratesXML as $rate) {
				if (in_array($rate->CharCode, $validCurrencies)) {
					$currCode = (string) $rate->CharCode;

					$rates[$currCode] = array(
						'code' => $currCode,
						'char' => $currChars[$currCode],
						'charPos' => $currCharsPos[$currCode],
						'name' => $currNames[$currCode],
						'value' => (float) str_replace(',', '.', (string) $rate->Value) / (float) str_replace(',', '.', (string) $rate->Nominal)
					);
				}
			}

			file_put_contents('cache/rates.dat', serialize($rates));
		}

		return $rates;
	}

	public static function SetCurrency()
	{
		$rates = self::getRates();
		if (isset(Query::$post['new_currency']) && isset($rates[Query::$post['new_currency']]))
			$_SESSION['curr_currency'] = $rates[Query::$post['new_currency']];
	}

	public static function GetCurrency()
	{
		$currentRate = $_SESSION['curr_currency'];
		if (empty($currentRate))
		{
			$rates = self::GetRates();
			$currentRate = $rates['RUR'];
			self::SetCurrency($currentRate);
		}
		return $currentRate;
	}
}

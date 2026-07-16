<?php







global $apimo_dir, $apimo_url;

/**
 * ------------------------------------
 *  Lead origin helpers (country/language)
 *  Tries, in order:
 *   - Cloudflare country header (CF-IPCountry)
 *   - GeoIP (PHP geoip extension) if available
 *   - Fallback to site locale / Accept-Language
 * ------------------------------------
 */
if (!function_exists('apimo_get_client_ip')) {
	function apimo_get_client_ip(): string {
		$keys = [
			'HTTP_CF_CONNECTING_IP', // Cloudflare real IP
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_REAL_IP',
			'REMOTE_ADDR',
		];

		foreach ($keys as $key) {
			if (!empty($_SERVER[$key])) {
				$val = $_SERVER[$key];

				// X-Forwarded-For can be a comma-separated list
				if ($key === 'HTTP_X_FORWARDED_FOR') {
					$parts = array_map('trim', explode(',', $val));
					$val = $parts[0] ?? '';
				}

				if (filter_var($val, FILTER_VALIDATE_IP)) {
					return $val;
				}
			}
		}

		return '';
	}
}

if (!function_exists('apimo_guess_country_code')) {
	function apimo_guess_country_code(): string {
		// 1) Cloudflare (most reliable when enabled)
		if (!empty($_SERVER['HTTP_CF_IPCOUNTRY']) && preg_match('/^[A-Z]{2}$/', $_SERVER['HTTP_CF_IPCOUNTRY'])) {
			return $_SERVER['HTTP_CF_IPCOUNTRY'];
		}

		// 2) GeoIP extension (if installed on server)
		if (function_exists('geoip_country_code_by_name')) {
			$ip = apimo_get_client_ip();
			if ($ip) {
				$code = @geoip_country_code_by_name($ip);
				if (!empty($code) && preg_match('/^[A-Z]{2}$/', $code)) {
					return $code;
				}
			}
		}

		// 3) Fallback: try to infer from site locale or Accept-Language (language ≠ country, but better than hardcoding FR)
		if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			// e.g. it-IT,it;q=0.9,en-US;q=0.8 => IT
			$al = strtolower(trim(explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE'])[0] ?? ''));
			if (preg_match('/^[a-z]{2,3}-([a-z]{2})/', $al, $m)) {
				return strtoupper($m[1]);
			}
			// If only language provided, map the most common country
			$langOnly = preg_replace('/[^a-z].*$/', '', $al);
			$map = ['it'=>'IT','fr'=>'FR','de'=>'DE','es'=>'ES','pt'=>'PT','nl'=>'NL','en'=>'US'];
			if (!empty($map[$langOnly])) {
				return $map[$langOnly];
			}
		}

		$locale = function_exists('get_locale') ? get_locale() : '';
		// e.g. it_IT => IT
		if ($locale && preg_match('/^[a-z]{2}[_-]([A-Z]{2})$/', $locale, $m)) {
			return $m[1];
		}



		// Default
		return 'IT';
	}
}

if (!function_exists('apimo_guess_language')) {
	function apimo_guess_language(): string {
		/**
		 * Detect lead language preferring the visitor's browser settings.
		 * Priority:
		 *  1) Explicit POST field (set via JS): browser_lang
		 *  2) HTTP Accept-Language header
		 *  3) WordPress locale
		 * Fallback: 'en'
		 */
		// 1) Explicit from form (JS)
		if (!empty($_POST['browser_lang'])) {
			$raw = strtolower(trim((string) $_POST['browser_lang']));
			if (preg_match('/^([a-z]{2})\b/', $raw, $m)) {
				return $m[1];
			}
		}

		// 2) Browser header (best effort, no external GeoIP needed)
		if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			$header = (string) $_SERVER['HTTP_ACCEPT_LANGUAGE'];
			// Example: "it-IT,it;q=0.9,en-US;q=0.8,en;q=0.7"
			$parts = preg_split('/\s*,\s*/', $header);
			if (is_array($parts)) {
				foreach ($parts as $part) {
					if (preg_match('/^([a-z]{2})\b/i', $part, $m)) {
						return strtolower($m[1]);
					}
				}
			}
		}

		// 3) WP locale
		$locale = function_exists('determine_locale') ? determine_locale() : (function_exists('get_locale') ? get_locale() : '');
		if ($locale) {
			$lang = strtolower(substr($locale, 0, 2));
			if (preg_match('/^[a-z]{2}$/', $lang)) {
				return $lang;
			}
		}

		return 'en';
	}
}



if (!function_exists('apimo_country_code_to_flag')) {
	function apimo_country_code_to_flag(string $countryCode): string {
		$countryCode = strtoupper(trim($countryCode));
		if (!preg_match('/^[A-Z]{2}$/', $countryCode)) {
			return '🌍';
		}
		$flag = '';
		foreach (str_split($countryCode) as $letter) {
			$flag .= html_entity_decode('&#' . (127397 + ord($letter)) . ';', ENT_NOQUOTES, 'UTF-8');
		}
		return $flag;
	}
}

if (!function_exists('apimo_get_phone_country_options')) {
	function apimo_get_phone_country_options(): array {
		return [
			['code' => 'DE', 'name' => 'Deutschland', 'dial' => '+49'],
			['code' => 'AT', 'name' => 'Österreich', 'dial' => '+43'],
			['code' => 'CH', 'name' => 'Schweiz', 'dial' => '+41'],
			['code' => 'IT', 'name' => 'Italien', 'dial' => '+39'],
			['code' => 'FR', 'name' => 'Frankreich', 'dial' => '+33'],
			['code' => 'ES', 'name' => 'Spanien', 'dial' => '+34'],
			['code' => 'NL', 'name' => 'Niederlande', 'dial' => '+31'],
			['code' => 'BE', 'name' => 'Belgien', 'dial' => '+32'],
			['code' => 'LU', 'name' => 'Luxemburg', 'dial' => '+352'],
			['code' => 'GB', 'name' => 'Vereinigtes Königreich', 'dial' => '+44'],
			['code' => 'IE', 'name' => 'Irland', 'dial' => '+353'],
			['code' => 'PT', 'name' => 'Portugal', 'dial' => '+351'],
			['code' => 'US', 'name' => 'Vereinigte Staaten', 'dial' => '+1'],
			['code' => 'CA', 'name' => 'Kanada', 'dial' => '+1'],
			['code' => 'AF', 'name' => 'Afghanistan', 'dial' => '+93'],
			['code' => 'AL', 'name' => 'Albanien', 'dial' => '+355'],
			['code' => 'DZ', 'name' => 'Algerien', 'dial' => '+213'],
			['code' => 'AD', 'name' => 'Andorra', 'dial' => '+376'],
			['code' => 'AO', 'name' => 'Angola', 'dial' => '+244'],
			['code' => 'AG', 'name' => 'Antigua und Barbuda', 'dial' => '+1-268'],
			['code' => 'GQ', 'name' => 'Äquatorialguinea', 'dial' => '+240'],
			['code' => 'AR', 'name' => 'Argentinien', 'dial' => '+54'],
			['code' => 'AM', 'name' => 'Armenien', 'dial' => '+374'],
			['code' => 'AZ', 'name' => 'Aserbaidschan', 'dial' => '+994'],
			['code' => 'ET', 'name' => 'Äthiopien', 'dial' => '+251'],
			['code' => 'AU', 'name' => 'Australien', 'dial' => '+61'],
			['code' => 'BS', 'name' => 'Bahamas', 'dial' => '+1-242'],
			['code' => 'BH', 'name' => 'Bahrain', 'dial' => '+973'],
			['code' => 'BD', 'name' => 'Bangladesch', 'dial' => '+880'],
			['code' => 'BB', 'name' => 'Barbados', 'dial' => '+1-246'],
			['code' => 'BY', 'name' => 'Belarus', 'dial' => '+375'],
			['code' => 'BZ', 'name' => 'Belize', 'dial' => '+501'],
			['code' => 'BJ', 'name' => 'Benin', 'dial' => '+229'],
			['code' => 'BT', 'name' => 'Bhutan', 'dial' => '+975'],
			['code' => 'BO', 'name' => 'Bolivien', 'dial' => '+591'],
			['code' => 'BA', 'name' => 'Bosnien und Herzegowina', 'dial' => '+387'],
			['code' => 'BW', 'name' => 'Botswana', 'dial' => '+267'],
			['code' => 'BR', 'name' => 'Brasilien', 'dial' => '+55'],
			['code' => 'BN', 'name' => 'Brunei', 'dial' => '+673'],
			['code' => 'BG', 'name' => 'Bulgarien', 'dial' => '+359'],
			['code' => 'BF', 'name' => 'Burkina Faso', 'dial' => '+226'],
			['code' => 'BI', 'name' => 'Burundi', 'dial' => '+257'],
			['code' => 'CL', 'name' => 'Chile', 'dial' => '+56'],
			['code' => 'CN', 'name' => 'China', 'dial' => '+86'],
			['code' => 'CR', 'name' => 'Costa Rica', 'dial' => '+506'],
			['code' => 'DK', 'name' => 'Dänemark', 'dial' => '+45'],
			['code' => 'DO', 'name' => 'Dominikanische Republik', 'dial' => '+1-809'],
			['code' => 'DJ', 'name' => 'Dschibuti', 'dial' => '+253'],
			['code' => 'DM', 'name' => 'Dominica', 'dial' => '+1-767'],
			['code' => 'EC', 'name' => 'Ecuador', 'dial' => '+593'],
			['code' => 'SV', 'name' => 'El Salvador', 'dial' => '+503'],
			['code' => 'CI', 'name' => 'Elfenbeinküste', 'dial' => '+225'],
			['code' => 'ER', 'name' => 'Eritrea', 'dial' => '+291'],
			['code' => 'EE', 'name' => 'Estland', 'dial' => '+372'],
			['code' => 'SZ', 'name' => 'Eswatini', 'dial' => '+268'],
			['code' => 'FJ', 'name' => 'Fidschi', 'dial' => '+679'],
			['code' => 'FI', 'name' => 'Finnland', 'dial' => '+358'],
			['code' => 'GA', 'name' => 'Gabun', 'dial' => '+241'],
			['code' => 'GM', 'name' => 'Gambia', 'dial' => '+220'],
			['code' => 'GE', 'name' => 'Georgien', 'dial' => '+995'],
			['code' => 'GH', 'name' => 'Ghana', 'dial' => '+233'],
			['code' => 'GD', 'name' => 'Grenada', 'dial' => '+1-473'],
			['code' => 'GR', 'name' => 'Griechenland', 'dial' => '+30'],
			['code' => 'GL', 'name' => 'Grönland', 'dial' => '+299'],
			['code' => 'GT', 'name' => 'Guatemala', 'dial' => '+502'],
			['code' => 'GN', 'name' => 'Guinea', 'dial' => '+224'],
			['code' => 'GW', 'name' => 'Guinea-Bissau', 'dial' => '+245'],
			['code' => 'GY', 'name' => 'Guyana', 'dial' => '+592'],
			['code' => 'HT', 'name' => 'Haiti', 'dial' => '+509'],
			['code' => 'HN', 'name' => 'Honduras', 'dial' => '+504'],
			['code' => 'IN', 'name' => 'Indien', 'dial' => '+91'],
			['code' => 'ID', 'name' => 'Indonesien', 'dial' => '+62'],
			['code' => 'IQ', 'name' => 'Irak', 'dial' => '+964'],
			['code' => 'IR', 'name' => 'Iran', 'dial' => '+98'],
			['code' => 'IS', 'name' => 'Island', 'dial' => '+354'],
			['code' => 'IL', 'name' => 'Israel', 'dial' => '+972'],
			['code' => 'JM', 'name' => 'Jamaika', 'dial' => '+1-876'],
			['code' => 'JP', 'name' => 'Japan', 'dial' => '+81'],
			['code' => 'YE', 'name' => 'Jemen', 'dial' => '+967'],
			['code' => 'JO', 'name' => 'Jordanien', 'dial' => '+962'],
			['code' => 'CV', 'name' => 'Kap Verde', 'dial' => '+238'],
			['code' => 'KZ', 'name' => 'Kasachstan', 'dial' => '+7'],
			['code' => 'QA', 'name' => 'Katar', 'dial' => '+974'],
			['code' => 'KH', 'name' => 'Kambodscha', 'dial' => '+855'],
			['code' => 'CM', 'name' => 'Kamerun', 'dial' => '+237'],
			['code' => 'KE', 'name' => 'Kenia', 'dial' => '+254'],
			['code' => 'KG', 'name' => 'Kirgisistan', 'dial' => '+996'],
			['code' => 'KI', 'name' => 'Kiribati', 'dial' => '+686'],
			['code' => 'CO', 'name' => 'Kolumbien', 'dial' => '+57'],
			['code' => 'KM', 'name' => 'Komoren', 'dial' => '+269'],
			['code' => 'CG', 'name' => 'Kongo', 'dial' => '+242'],
			['code' => 'CD', 'name' => 'Demokratische Republik Kongo', 'dial' => '+243'],
			['code' => 'KP', 'name' => 'Nordkorea', 'dial' => '+850'],
			['code' => 'KR', 'name' => 'Südkorea', 'dial' => '+82'],
			['code' => 'XK', 'name' => 'Kosovo', 'dial' => '+383'],
			['code' => 'HR', 'name' => 'Kroatien', 'dial' => '+385'],
			['code' => 'CU', 'name' => 'Kuba', 'dial' => '+53'],
			['code' => 'KW', 'name' => 'Kuwait', 'dial' => '+965'],
			['code' => 'LA', 'name' => 'Laos', 'dial' => '+856'],
			['code' => 'LS', 'name' => 'Lesotho', 'dial' => '+266'],
			['code' => 'LV', 'name' => 'Lettland', 'dial' => '+371'],
			['code' => 'LB', 'name' => 'Libanon', 'dial' => '+961'],
			['code' => 'LR', 'name' => 'Liberia', 'dial' => '+231'],
			['code' => 'LY', 'name' => 'Libyen', 'dial' => '+218'],
			['code' => 'LI', 'name' => 'Liechtenstein', 'dial' => '+423'],
			['code' => 'LT', 'name' => 'Litauen', 'dial' => '+370'],
			['code' => 'MG', 'name' => 'Madagaskar', 'dial' => '+261'],
			['code' => 'MW', 'name' => 'Malawi', 'dial' => '+265'],
			['code' => 'MY', 'name' => 'Malaysia', 'dial' => '+60'],
			['code' => 'MV', 'name' => 'Malediven', 'dial' => '+960'],
			['code' => 'ML', 'name' => 'Mali', 'dial' => '+223'],
			['code' => 'MT', 'name' => 'Malta', 'dial' => '+356'],
			['code' => 'MA', 'name' => 'Marokko', 'dial' => '+212'],
			['code' => 'MH', 'name' => 'Marshallinseln', 'dial' => '+692'],
			['code' => 'MR', 'name' => 'Mauretanien', 'dial' => '+222'],
			['code' => 'MU', 'name' => 'Mauritius', 'dial' => '+230'],
			['code' => 'MX', 'name' => 'Mexiko', 'dial' => '+52'],
			['code' => 'FM', 'name' => 'Mikronesien', 'dial' => '+691'],
			['code' => 'MD', 'name' => 'Moldau', 'dial' => '+373'],
			['code' => 'MC', 'name' => 'Monaco', 'dial' => '+377'],
			['code' => 'MN', 'name' => 'Mongolei', 'dial' => '+976'],
			['code' => 'ME', 'name' => 'Montenegro', 'dial' => '+382'],
			['code' => 'MZ', 'name' => 'Mosambik', 'dial' => '+258'],
			['code' => 'MM', 'name' => 'Myanmar', 'dial' => '+95'],
			['code' => 'NA', 'name' => 'Namibia', 'dial' => '+264'],
			['code' => 'NR', 'name' => 'Nauru', 'dial' => '+674'],
			['code' => 'NP', 'name' => 'Nepal', 'dial' => '+977'],
			['code' => 'NZ', 'name' => 'Neuseeland', 'dial' => '+64'],
			['code' => 'NI', 'name' => 'Nicaragua', 'dial' => '+505'],
			['code' => 'NE', 'name' => 'Niger', 'dial' => '+227'],
			['code' => 'NG', 'name' => 'Nigeria', 'dial' => '+234'],
			['code' => 'MK', 'name' => 'Nordmazedonien', 'dial' => '+389'],
			['code' => 'NO', 'name' => 'Norwegen', 'dial' => '+47'],
			['code' => 'OM', 'name' => 'Oman', 'dial' => '+968'],
			['code' => 'TL', 'name' => 'Osttimor', 'dial' => '+670'],
			['code' => 'PK', 'name' => 'Pakistan', 'dial' => '+92'],
			['code' => 'PW', 'name' => 'Palau', 'dial' => '+680'],
			['code' => 'PA', 'name' => 'Panama', 'dial' => '+507'],
			['code' => 'PG', 'name' => 'Papua-Neuguinea', 'dial' => '+675'],
			['code' => 'PY', 'name' => 'Paraguay', 'dial' => '+595'],
			['code' => 'PE', 'name' => 'Peru', 'dial' => '+51'],
			['code' => 'PH', 'name' => 'Philippinen', 'dial' => '+63'],
			['code' => 'PL', 'name' => 'Polen', 'dial' => '+48'],
			['code' => 'PS', 'name' => 'Palästina', 'dial' => '+970'],
			['code' => 'RO', 'name' => 'Rumänien', 'dial' => '+40'],
			['code' => 'RU', 'name' => 'Russland', 'dial' => '+7'],
			['code' => 'RW', 'name' => 'Ruanda', 'dial' => '+250'],
			['code' => 'ZM', 'name' => 'Sambia', 'dial' => '+260'],
			['code' => 'WS', 'name' => 'Samoa', 'dial' => '+685'],
			['code' => 'SM', 'name' => 'San Marino', 'dial' => '+378'],
			['code' => 'ST', 'name' => 'São Tomé und Príncipe', 'dial' => '+239'],
			['code' => 'SA', 'name' => 'Saudi-Arabien', 'dial' => '+966'],
			['code' => 'SE', 'name' => 'Schweden', 'dial' => '+46'],
			['code' => 'SN', 'name' => 'Senegal', 'dial' => '+221'],
			['code' => 'RS', 'name' => 'Serbien', 'dial' => '+381'],
			['code' => 'SC', 'name' => 'Seychellen', 'dial' => '+248'],
			['code' => 'SL', 'name' => 'Sierra Leone', 'dial' => '+232'],
			['code' => 'ZW', 'name' => 'Simbabwe', 'dial' => '+263'],
			['code' => 'SG', 'name' => 'Singapur', 'dial' => '+65'],
			['code' => 'SK', 'name' => 'Slowakei', 'dial' => '+421'],
			['code' => 'SI', 'name' => 'Slowenien', 'dial' => '+386'],
			['code' => 'SO', 'name' => 'Somalia', 'dial' => '+252'],
			['code' => 'LK', 'name' => 'Sri Lanka', 'dial' => '+94'],
			['code' => 'KN', 'name' => 'St. Kitts und Nevis', 'dial' => '+1-869'],
			['code' => 'LC', 'name' => 'St. Lucia', 'dial' => '+1-758'],
			['code' => 'VC', 'name' => 'St. Vincent und die Grenadinen', 'dial' => '+1-784'],
			['code' => 'ZA', 'name' => 'Südafrika', 'dial' => '+27'],
			['code' => 'SD', 'name' => 'Sudan', 'dial' => '+249'],
			['code' => 'SS', 'name' => 'Südsudan', 'dial' => '+211'],
			['code' => 'SR', 'name' => 'Suriname', 'dial' => '+597'],
			['code' => 'SY', 'name' => 'Syrien', 'dial' => '+963'],
			['code' => 'TJ', 'name' => 'Tadschikistan', 'dial' => '+992'],
			['code' => 'TW', 'name' => 'Taiwan', 'dial' => '+886'],
			['code' => 'TZ', 'name' => 'Tansania', 'dial' => '+255'],
			['code' => 'TH', 'name' => 'Thailand', 'dial' => '+66'],
			['code' => 'TG', 'name' => 'Togo', 'dial' => '+228'],
			['code' => 'TO', 'name' => 'Tonga', 'dial' => '+676'],
			['code' => 'TT', 'name' => 'Trinidad und Tobago', 'dial' => '+1-868'],
			['code' => 'TD', 'name' => 'Tschad', 'dial' => '+235'],
			['code' => 'CZ', 'name' => 'Tschechien', 'dial' => '+420'],
			['code' => 'TN', 'name' => 'Tunesien', 'dial' => '+216'],
			['code' => 'TR', 'name' => 'Türkei', 'dial' => '+90'],
			['code' => 'TM', 'name' => 'Turkmenistan', 'dial' => '+993'],
			['code' => 'TV', 'name' => 'Tuvalu', 'dial' => '+688'],
			['code' => 'UG', 'name' => 'Uganda', 'dial' => '+256'],
			['code' => 'UA', 'name' => 'Ukraine', 'dial' => '+380'],
			['code' => 'HU', 'name' => 'Ungarn', 'dial' => '+36'],
			['code' => 'UY', 'name' => 'Uruguay', 'dial' => '+598'],
			['code' => 'UZ', 'name' => 'Usbekistan', 'dial' => '+998'],
			['code' => 'VU', 'name' => 'Vanuatu', 'dial' => '+678'],
			['code' => 'VA', 'name' => 'Vatikanstadt', 'dial' => '+379'],
			['code' => 'AE', 'name' => 'Vereinigte Arabische Emirate', 'dial' => '+971'],
			['code' => 'VE', 'name' => 'Venezuela', 'dial' => '+58'],
			['code' => 'VN', 'name' => 'Vietnam', 'dial' => '+84'],
			['code' => 'CF', 'name' => 'Zentralafrikanische Republik', 'dial' => '+236'],
			['code' => 'CY', 'name' => 'Zypern', 'dial' => '+357'],
		];
	}
}

$property_reglementation = [
	[
		"id" => 1,
		"culture" => "de_DE",
		"name" => "Energie - Konventioneller Verbrauch",
		"value" => "kWh\/m².year"
	],
	[
		"id" => 2,
		"culture" => "de_DE",
		"name" => "Energie - Geschätzte Emissionen",
		"value" => "kg CO2\/m².year"
	],
	[
		"id" => 3,
		"culture" => "de_DE",
		"name" => "„Carrez“-Gesetz",
		"value" => "m²"
	],
	[
		"id" => 4,
		"culture" => "de_DE",
		"name" => "ERP"
	],
	[
		"id" => 5,
		"culture" => "de_DE",
		"name" => "Termiten"
	],
	[
		"id" => 6,
		"culture" => "de_DE",
		"name" => "Asbest"
	],
	[
		"id" => 7,
		"culture" => "de_DE",
		"name" => "Gas"
	],
	[
		"id" => 8,
		"culture" => "de_DE",
		"name" => "Blei"
	],
	[
		"id" => 9,
		"culture" => "de_DE",
		"name" => "Elektrizität"
	],
	[
		"id" => 10,
		"culture" => "de_DE",
		"name" => "Boutin-Gesetz",
		"value" => "m²"
	],
	[
		"id" => 11,
		"culture" => "de_DE",
		"name" => "Abwasserentsorgung"
	],
	[
		"id" => 12,
		"culture" => "de_DE",
		"name" => "EPI (nicht erneuerbar)",
		"value" => "kWh\/m².year"
	],
	[
		"id" => 13,
		"culture" => "de_DE",
		"name" => "APE"
	],
	[
		"id" => 14,
		"culture" => "de_DE",
		"name" => "Antrag auf Ernennung eines Ad-hoc-Beauftragten"
	],
	[
		"id" => 15,
		"culture" => "de_DE",
		"name" => "Antrag auf Ernennung eines vorläufigen Verwalters"
	],
	[
		"id" => 16,
		"culture" => "de_DE",
		"name" => "Antrag auf Ernennung eines Sachverständigen"
	],
	[
		"id" => 17,
		"culture" => "de_DE",
		"name" => "Brandschutzvorschriften"
	],
	[
		"id" => 18,
		"culture" => "de_DE",
		"name" => "Barrierefreiheitsstandards für Menschen mit Behinderungen"
	],
	[
		"id" => 19,
		"culture" => "de_DE",
		"name" => "Hygienegenehmigung"
	],
	[
		"id" => 20,
		"culture" => "de_DE",
		"name" => "Energieverbrauch",
		"value" => "kWh\/m² year"
	],
	[
		"id" => 21,
		"culture" => "de_DE",
		"name" => "Energieverbrauch"
	],
	[
		"id" => 22,
		"culture" => "de_DE",
		"name" => "Grundsteuer",
		"value" => "€ \/ year"
	],
	[
		"id" => 23,
		"culture" => "de_DE",
		"name" => "Wohnsteuer",
		"value" => "€ \/ year"
	],
	[
		"id" => 24,
		"culture" => "de_DE",
		"name" => "Grundstücksabgaben",
		"value" => "CHF \/ an"
	],
	[
		"id" => 25,
		"culture" => "de_DE",
		"name" => "Grundsteuer",
		"value" => "€ \/ year"
	],
	[
		"id" => 26,
		"culture" => "de_DE",
		"name" => "Grundsteuer",
		"value" => "€ \/ year"
	],
	[
		"id" => 27,
		"culture" => "de_DE",
		"name" => "Nur für Bewohner"
	],
	[
		"id" => 28,
		"culture" => "de_DE",
		"name" => "Grundsteuer (IPTU)",
		"value" => "R$ \/ year"
	],
	[
		"id" => 29,
		"culture" => "de_DE",
		"name" => "Lokale Erschließungsabgabe",
		"value" => "€"
	],
	[
		"id" => 30,
		"culture" => "de_DE",
		"name" => "Minergie"
	],
	[
		"id" => 31,
		"culture" => "de_DE",
		"name" => "Volumen",
		"value" => "m³"
	],
	[
		"id" => 32,
		"culture" => "de_DE",
		"name" => "Nutzfläche",
		"value" => "m²"
	],
	[
		"id" => 33,
		"culture" => "de_DE",
		"name" => "Miteigentumsobjekt"
	],
	[
		"id" => 34,
		"culture" => "de_DE",
		"name" => "Kommunaler Steuersatz",
		"value" => "%"
	],
	[
		"id" => 35,
		"culture" => "de_DE",
		"name" => "Nummer des Grundbuchauszugs"
	],
	[
		"id" => 36,
		"culture" => "de_DE",
		"name" => "Baurecht"
	],
	[
		"id" => 37,
		"culture" => "de_DE",
		"name" => "Tausendstelanteile"
	],
	[
		"id" => 38,
		"culture" => "de_DE",
		"name" => "Wohnsteuer",
		"value" => "€ \/ year"
	],
	[
		"id" => 39,
		"culture" => "de_DE",
		"name" => "Budget des Stockwerkeigentums",
		"value" => "CHF"
	],
	[
		"id" => 40,
		"culture" => "de_DE",
		"name" => "Aktueller Erneuerungsfonds",
		"value" => "CHF"
	],
	[
		"id" => 41,
		"culture" => "de_DE",
		"name" => "Ausnutzungsziffer"
	],
	[
		"id" => 42,
		"culture" => "de_DE",
		"name" => "Belegungsquote",
		"value" => "%"
	],
	[
		"id" => 43,
		"culture" => "de_DE",
		"name" => "Bebauungskoeffizient"
	],
	[
		"id" => 44,
		"culture" => "de_DE",
		"name" => "Geschossflächenzahl"
	],
	[
		"id" => 45,
		"culture" => "de_DE",
		"name" => "Vorrangfrist CCH L443-11"
	],
	[
		"id" => 47,
		"culture" => "de_DE",
		"name" => "Grundstücksteilung \/ Abmarkung"
	],
	[
		"id" => 48,
		"culture" => "de_DE",
		"name" => "Beschluss des Vorstands \/ Aufsichtsgremiums"
	],
	[
		"id" => 49,
		"culture" => "de_DE",
		"name" => "Konformitätsbescheinigung"
	],
	[
		"id" => 50,
		"culture" => "de_DE",
		"name" => "Energieklasse"
	],
	[
		"id" => 51,
		"culture" => "de_DE",
		"name" => "Wärmedämmklasse"
	],
	[
		"id" => 52,
		"culture" => "de_DE",
		"name" => "Treibhausgas"
	],
	[
		"id" => 53,
		"culture" => "de_DE",
		"name" => "Energiepass"
	],
	[
		"id" => 54,
		"culture" => "de_DE",
		"name" => "Energieausweis"
	],
	[
		"id" => 55,
		"culture" => "de_DE",
		"name" => "Energieverbrauch \/ Endenergiebedarf",
		"value" => "kWh\/(m²·a)"
	],
	[
		"id" => 56,
		"culture" => "de_DE",
		"name" => "Energieeffizienzklasse"
	],
	[
		"id" => 57,
		"culture" => "de_DE",
		"name" => "Baujahr laut Ausweis"
	],
	[
		"id" => 58,
		"culture" => "de_DE",
		"name" => "Energieverbrauch => Warmwasser inbegriffen"
	],
	[
		"id" => 59,
		"culture" => "de_DE",
		"name" => "Spezifischer Primärenergieverbrauch",
		"value" => "kWh\/m²·year"
	],
	[
		"id" => 60,
		"culture" => "de_DE",
		"name" => "Eindeutiger PEB-Code"
	],
	[
		"id" => 61,
		"culture" => "de_DE",
		"name" => "K-Wert (Wärmedämmung)"
	],
	[
		"id" => 62,
		"culture" => "de_DE",
		"name" => "Ew-Wert (Energieeffizienz)"
	],
	[
		"id" => 63,
		"culture" => "de_DE",
		"name" => "CO2-Emission",
		"value" => "kg CO2\/m².year"
	],
	[
		"id" => 64,
		"culture" => "de_DE",
		"name" => "Hochwasserrisiken"
	],
	[
		"id" => 65,
		"culture" => "de_DE",
		"name" => "Bescheinigung => Konformität des Öltanks"
	],
	[
		"id" => 66,
		"culture" => "de_DE",
		"name" => "Bescheinigung => Konformität der Elektroinstallation"
	],
	[
		"id" => 67,
		"culture" => "de_DE",
		"name" => "„As Built“-Bescheinigung"
	],
	[
		"id" => 68,
		"culture" => "de_DE",
		"name" => "Gesamtprimärenergieverbrauch",
		"value" => "kWh\/an"
	],
	[
		"id" => 69,
		"culture" => "de_DE",
		"name" => "Registrierungsnummer"
	],
	[
		"id" => 70,
		"culture" => "de_DE",
		"name" => "Katasterertrag",
		"value" => "€"
	],
	[
		"id" => 71,
		"culture" => "de_DE",
		"name" => "Baugenehmigung erteilt"
	],
	[
		"id" => 72,
		"culture" => "de_DE",
		"name" => "Parzellierungsgenehmigung"
	],
	[
		"id" => 73,
		"culture" => "de_DE",
		"name" => "Vorkaufsrecht möglich"
	],
	[
		"id" => 74,
		"culture" => "de_DE",
		"name" => "Anzeige wegen baurechtlicher Zuwiderhandlung"
	],
	[
		"id" => 75,
		"culture" => "de_DE",
		"name" => "Letzte Nutzungsbestimmung"
	],
	[
		"id" => 76,
		"culture" => "de_DE",
		"name" => "Katasterrente",
		"value" => "€"
	],
	[
		"id" => 77,
		"culture" => "de_DE",
		"name" => "Nummer des Energieausweises"
	],
	[
		"id" => 78,
		"culture" => "de_DE",
		"name" => "MwSt. anwendbar"
	],
	[
		"id" => 79,
		"culture" => "de_DE",
		"name" => "Energiezertifizierung"
	],
	[
		"id" => 80,
		"culture" => "de_DE",
		"name" => "Geschätzte Emissionen",
		"value" => "kg éqCO2\/m².year"
	],
	[
		"id" => 81,
		"culture" => "de_DE",
		"name" => "Geschätzte Emissionen"
	],
	[
		"id" => 82,
		"culture" => "de_DE",
		"name" => "Anschlussmöglichkeit => Wasser \/ Gas \/ Strom"
	],
	[
		"id" => 83,
		"culture" => "de_DE",
		"name" => "Laudêmio",
		"value" => "BRL"
	],
	[
		"id" => 84,
		"culture" => "de_DE",
		"name" => "Immobilienprogramm"
	],
	[
		"id" => 85,
		"culture" => "de_DE",
		"name" => "Für Ausländer zugänglich"
	],
	[
		"id" => 86,
		"culture" => "de_DE",
		"name" => "Gebäudetyp"
	],
	[
		"id" => 87,
		"culture" => "de_DE",
		"name" => "Primärenergiebedarf",
		"value" => "kWh\/(m².a)"
	],
	[
		"id" => 88,
		"culture" => "de_DE",
		"name" => "Nebenkostenpauschale"
	],
	[
		"id" => 89,
		"culture" => "de_DE",
		"name" => "Energieeffizienzbewertung (aktuell)"
	],
	[
		"id" => 90,
		"culture" => "de_DE",
		"name" => "Energieeffizienzbewertung (potenziell)"
	],
	[
		"id" => 91,
		"culture" => "de_DE",
		"name" => "Umweltbelastungsbewertung (aktuell)"
	],
	[
		"id" => 92,
		"culture" => "de_DE",
		"name" => "Umweltbelastungsbewertung (potenziell)"
	],
	[
		"id" => 93,
		"culture" => "de_DE",
		"name" => "Besitzart"
	],
	[
		"id" => 94,
		"culture" => "de_DE",
		"name" => "Eigentumsverhältnis"
	],
	[
		"id" => 95,
		"culture" => "de_DE",
		"name" => "Mietwert",
		"value" => "CHF"
	],
	[
		"id" => 96,
		"culture" => "de_DE",
		"name" => "Steuerwert",
		"value" => "CHF"
	],
	[
		"id" => 97,
		"culture" => "de_DE",
		"name" => "Versicherungswert",
		"value" => "CHF"
	],
	[
		"id" => 98,
		"culture" => "de_DE",
		"name" => "Bauzone"
	],
	[
		"id" => 99,
		"culture" => "de_DE",
		"name" => "Schicht"
	],
	[
		"id" => 100,
		"culture" => "de_DE",
		"name" => "Mietreferenzindex"
	],
	[
		"id" => 101,
		"culture" => "de_DE",
		"name" => "Letzter Mietpreis",
		"value" => "€"
	],
	[
		"id" => 102,
		"culture" => "de_DE",
		"name" => "Energie - Konventioneller Verbrauch",
		"value" => "kWh\/m².year"
	],
	[
		"id" => 103,
		"culture" => "de_DE",
		"name" => "Effizienz der Gebäudehülle"
	],
	[
		"id" => 104,
		"culture" => "de_DE",
		"name" => "Gesamtenergieeffizienz"
	],
	[
		"id" => 105,
		"culture" => "de_DE",
		"name" => "Hausschwammdiagnose"
	],
	[
		"id" => 106,
		"culture" => "de_DE",
		"name" => "Zusatzmiete",
		"value" => "€"
	],
	[
		"id" => 107,
		"culture" => "de_DE",
		"name" => "Indexierter Katasterertrag",
		"value" => "€"
	],
	[
		"id" => 108,
		"culture" => "de_DE",
		"name" => "Grundsteuer",
		"value" => "€"
	],
	[
		"id" => 109,
		"culture" => "de_DE",
		"name" => "EPI (erneuerbar)",
		"value" => "kWh\/m².year"
	],
	[
		"id" => 110,
		"culture" => "de_DE",
		"name" => "Emissionsklasse"
	],
	[
		"id" => 111,
		"culture" => "de_DE",
		"name" => "Heizkosten",
		"value" => "€"
	],
	[
		"id" => 112,
		"culture" => "de_DE",
		"name" => "Leistungsniveau (Sommersaison)"
	],
	[
		"id" => 113,
		"culture" => "de_DE",
		"name" => "Leistungsniveau (Wintersaison)"
	],
	[
		"id" => 114,
		"culture" => "de_DE",
		"name" => "Katasterdaten - Sektion"
	],
	[
		"id" => 115,
		"culture" => "de_DE",
		"name" => "Katasterdaten - Blatt"
	],
	[
		"id" => 116,
		"culture" => "de_DE",
		"name" => "Katasterdaten - Flurstück"
	],
	[
		"id" => 117,
		"culture" => "de_DE",
		"name" => "Katasterdaten - Teilflurstück"
	],
	[
		"id" => 118,
		"culture" => "de_DE",
		"name" => "Katasterdaten - Untereinheit"
	],
	[
		"id" => 119,
		"culture" => "de_DE",
		"name" => "Katasterdaten - Untereinheit 2"
	],
	[
		"id" => 120,
		"culture" => "de_DE",
		"name" => "Energie - Niedrig geschätzte jährliche Ausgaben bei Standardnutzung",
		"value" => "€ \/ year"
	],
	[
		"id" => 121,
		"culture" => "de_DE",
		"name" => "Energie - Hoch geschätzte jährliche Ausgaben bei Standardnutzung",
		"value" => "€ \/ year"
	],
	[
		"id" => 122,
		"culture" => "de_DE",
		"name" => "Energie - Referenzjahr des Energiepreises"
	],
	[
		"id" => 123,
		"culture" => "de_DE",
		"name" => "Wohnlizenz - Nummer"
	],
	[
		"id" => 124,
		"culture" => "de_DE",
		"name" => "Wohnlizenz - Ausgestellt am"
	],
	[
		"id" => 125,
		"culture" => "de_DE",
		"name" => "IMI-Steuer",
		"value" => "€"
	],
	[
		"id" => 127,
		"culture" => "de_DE",
		"name" => "MwSt.-Regelung"
	],
	[
		"id" => 128,
		"culture" => "de_DE",
		"name" => "Urkunde - Nummer"
	],
	[
		"id" => 130,
		"culture" => "de_DE",
		"name" => "Baugenehmigung - Nummer"
	],
	[
		"id" => 131,
		"culture" => "de_DE",
		"name" => "Baugenehmigung - Ausgestellt am"
	],
	[
		"id" => 132,
		"culture" => "de_DE",
		"name" => "Bedingungen für Nebenkosten des Mieters"
	],
	[
		"id" => 133,
		"culture" => "de_DE",
		"name" => "Grundsteuer",
		"value" => "$ \/ year"
	],
	[
		"id" => 134,
		"culture" => "de_DE",
		"name" => "Gemeindesteuerklasse"
	],
	[
		"id" => 135,
		"culture" => "de_DE",
		"name" => "Höchstwert der Referenzmiete (nicht zu überschreitende Basismiete)",
		"value" => "€"
	],
	[
		"id" => 136,
		"culture" => "de_DE",
		"name" => "Mietvertrag"
	],
	[
		"id" => 137,
		"culture" => "de_DE",
		"name" => "Katasterkategorie"
	],
	[
		"id" => 138,
		"culture" => "de_DE",
		"name" => "Abfallgebühr",
		"value" => "€ \/ year"
	],
	[
		"id" => 139,
		"culture" => "de_DE",
		"name" => "Hochwasserrisiken P-Score"
	],
	[
		"id" => 140,
		"culture" => "de_DE",
		"name" => "Hochwasserrisiken G-Score"
	],
	[
		"id" => 141,
		"culture" => "de_DE",
		"name" => "Konnektivität - Gebäudeanschluss"
	],
	[
		"id" => 142,
		"culture" => "de_DE",
		"name" => "Konnektivität - Vertikale Verkabelung"
	],
	[
		"id" => 143,
		"culture" => "de_DE",
		"name" => "Asbestbescheinigung"
	],
	[
		"id" => 144,
		"culture" => "de_DE",
		"name" => "Gebäude mit überwiegend nicht wohnwirtschaftlicher Nutzung"
	],
	[
		"id" => 145,
		"culture" => "de_DE",
		"name" => "Energie - Endenergieverbrauch",
		"value" => "kWhEF\/m².an"
	],
	[
		"id" => 146,
		"culture" => "de_DE",
		"name" => "Energieeffizienzklasse"
	],
	[
		"id" => 147,
		"culture" => "de_DE",
		"name" => "Energie - Ademe-Referenz"
	],
	[
		"id" => 148,
		"culture" => "de_DE",
		"name" => "Konformitätsbescheinigung (Vermietung)"
	],
	[
		"id" => 149,
		"culture" => "de_DE",
		"name" => "Lizenz für lokale Beherbergung",
		"value" => "\/AL"
	],
	[
		"id" => 150,
		"culture" => "de_DE",
		"name" => "Erbbauzins",
		"value" => "£\/year"
	],
	[
		"id" => 151,
		"culture" => "de_DE",
		"name" => "Energieaudit"
	],
	[
		"id" => 152,
		"culture" => "de_DE",
		"name" => "Steueridentifikationsnummer der Immobilie"
	],
	[
		"id" => 153,
		"culture" => "de_DE",
		"name" => "Grundstückspreis ohne Steuern",
		"value" => "€"
	],
	[
		"id" => 154,
		"culture" => "de_DE",
		"name" => "Grundstücksbezogene Steuern",
		"value" => "€"
	]
];



// function getPropertyNameWithUnit($id, $property_reglementation) {
//     foreach ($property_reglementation as $item) {
//         if ($item["id"] == $id) {
//             // Check if 'value' key exists to append the unit, if applicable.
//             $unit = isset($item["value"]) ? " <strong> (" . $item["value"] . ") </strong>" : "";
//             return stripslashes($item["name"] . $unit);
//         }
//     }
//     return "Property not found"; 
// }

function getPropertyName($id, $property_reglementation)
{
	foreach ($property_reglementation as $item) {
		if ($item["id"] == $id) {
			return stripslashes($item["name"]);
		}
	}
	return "Property not found";
}

if (!function_exists('apimo_translate_property_value')) {
	function apimo_translate_property_value($value) {
		if (is_array($value)) {
			return array_map('apimo_translate_property_value', $value);
		}

		$value = trim((string) $value);

		$translations = [
			// IT / EN -> DE
			'Vendita' => 'Verkauf',
			'Affitto' => 'Miete',
			'Affitto stagionale' => 'Saisonmiete',
			'Libero' => 'Verfügbar',
			'Occupato' => 'Belegt',
			'Riservato' => 'Reserviert',
			'Autonomo' => 'Autonom',
			'Centralizzato' => 'Zentral',
			'Comune' => 'Gemeinschaftlich',
			'Privato' => 'Privat',
			'Senza riscaldamento' => 'Keine Heizung',
			'Piano terra' => 'Erdgeschoss',
			'Piano rialzato' => 'Hochparterre',
			'Primo piano' => '1. Etage',
			'Secondo piano' => '2. Etage',
			'Terzo piano' => '3. Etage',
			'Ultimo piano' => 'Letzte Etage',
			'Casa' => 'Haus',
			'Appartamento' => 'Wohnung',
			'Casa / Casa' => 'Haus / Haus',
			'Apartment' => 'Wohnung',
			'House' => 'Haus',
			'Villa' => 'Villa',
			'Land' => 'Grundstück',
			'Plot' => 'Grundstück',
			'Furnished' => 'Möbliert',
			'Barbecue' => 'Grill',
			'Fence' => 'Zaun',
			'Irrigation sprinkler' => 'Bewässerungsanlage',
			'Pool' => 'Pool',
			'Garden' => 'Garten',
			'Terrace' => 'Terrasse',
			'Balcony' => 'Balkon',
			'Garage' => 'Garage',
			'Parking' => 'Parkplatz',
			'Air-conditioning' => 'Klimaanlage',
			'Air conditioning' => 'Klimaanlage',
			'Fireplace' => 'Kamin',
			'Sea' => 'Meer',
			'Mountains' => 'Berge',
			'Hills' => 'Hügel',
			'Greenery' => 'Grünanlage',
			'Monument' => 'Denkmal',
			'Forest' => 'Wald',
			'Good condition' => 'Guter Zustand',
			'Excellent condition' => 'Sehr guter Zustand',
			'Requires renovation' => 'Renovierungsbedürftig',
			'New' => 'Neu',
			'Included' => 'Inbegriffen',
			'No' => 'Nein',
			'Yes' => 'Ja',
		];

		return $translations[$value] ?? $value;
	}
}

if (!function_exists('apimo_translate_property_list')) {
	function apimo_translate_property_list($values) {
		if (empty($values)) {
			return '';
		}

		if (!is_array($values)) {
			return apimo_translate_property_value($values);
		}

		$translated = array_map('apimo_translate_property_value', array_filter($values));
		$translated = array_map('esc_html', $translated);

		return implode(', ', $translated);
	}
}



$metas = get_post_meta(get_the_ID());
// echo "<pre>";
// print_r($metas);
// echo "</pre>";
// die();
$primary_color = get_option('apimo_style')['primary']['color'];
$secondary_color = get_option('apimo_style')['secondary']['color'];


$thumbnail = get_the_post_thumbnail_url(get_the_ID());

$city_term = wp_get_post_terms(get_the_ID(), 'city');


$city = $zip_code = '';

if (!empty($city_term)) {
	$city = $city_term[0]->name;
	$zip_code = get_term_meta($city_term[0]->term_id, 'zip_code', true);
	$city = $city . ' - ' . $zip_code;
}


// $condition = wp_get_post_terms(get_the_ID(), 'apimo_property_condition')[0]->name;
// $construction_years = get_post_meta(get_the_ID(), 'apimo_construction_year', true);
$apimo_archive_settings = get_option('apimo_style_archive');
// $external_areas = wp_get_post_terms(get_the_ID(), 'apimo_areas');
$type = $subtype = $flor = $condition = $construction_years = '';
$external_areas = [];

$type_terms = wp_get_post_terms(get_the_ID(), 'apimo_type');
$subtype_terms = wp_get_post_terms(get_the_ID(), 'apimo_subtype');
$condition_terms = wp_get_post_terms(get_the_ID(), 'apimo_property_condition');
$construction_years = get_post_meta(get_the_ID(), 'apimo_construction_year', true);
$external_areas = wp_get_post_terms(get_the_ID(), 'apimo_areas');
$floor_terms = wp_get_post_terms(get_the_ID(), 'apimo_floor');

if (!empty($type_terms)) {
	$type = $type_terms[0]->name;
}

if (!empty($subtype_terms)) {
	$subtype = $subtype_terms[0]->name;
}

if (!empty($condition_terms)) {
	$condition = $condition_terms[0]->name;
}

if (!empty($floor_terms)) {
	$flor = $floor_terms[0]->name;
}

foreach ($external_areas as $key => $external_areas_val) {
	if (!in_array($external_areas_val->term_id, array(49, 50, 51))) {
		unset($external_areas[$key]);
	}
}


$heating_type = !empty(wp_get_post_terms(get_the_ID(), 'apimo_heating_type')) ? wp_get_post_terms(get_the_ID(), 'apimo_heating_type')[0]->name : '';
$heating_access = !empty(wp_get_post_terms(get_the_ID(), 'apimo_heating_access')) ? wp_get_post_terms(get_the_ID(), 'apimo_heating_access')[0]->name : '';;
$heating_device = !empty(wp_get_post_terms(get_the_ID(), 'apimo_heating_device')) ? wp_get_post_terms(get_the_ID(), 'apimo_heating_device')[0]->name : '';;
$water_hot_device = !empty(wp_get_post_terms(get_the_ID(), 'apimo_water_hot_device')) ? wp_get_post_terms(get_the_ID(), 'apimo_water_hot_device')[0]->name : '';;
$water_hot_access = !empty(wp_get_post_terms(get_the_ID(), 'apimo_water_hot_access')) ? wp_get_post_terms(get_the_ID(), 'apimo_water_hot_access')[0]->name : '';;
$water_waste = !empty(wp_get_post_terms(get_the_ID(), 'apimo_water_waste')) ? wp_get_post_terms(get_the_ID(), 'apimo_water_waste')[0]->name : '';;
$apimo_category = !empty(wp_get_post_terms(get_the_ID(), 'apimo_category')) ? wp_get_post_terms(get_the_ID(), 'apimo_category')[0]->name : '';;
$availability = !empty(wp_get_post_terms(get_the_ID(), 'apimo_availability')) ? wp_get_post_terms(get_the_ID(), 'apimo_availability')[0]->name : '';;
$property_standing =  !empty(wp_get_post_terms(get_the_ID(), 'apimo_property_standing')) ? wp_get_post_terms(get_the_ID(), 'apimo_property_standing')[0]->name : '';

$grid_desktop = 'column-desktop-' . $apimo_archive_settings['view_1']['desktop'];
$grid_tablet = 'column-tablet-' . $apimo_archive_settings['view_1']['teblate'];
$grid_mobile = 'column-mobile-' . $apimo_archive_settings['view_1']['mobile'];

global $UNIT_AREA;
?>

<div class="apimo_container">
	<main>

<style id="mri-gallery-fix">
/* ===== Desktop/notebook: Kyero-like grid (3 cols × 2 rows) ===== */
@media (min-width: 992px){
  .apimo_property_gallery{
    position: relative;
    width: 100vw;
    margin-left: calc(50% - 50vw);
    margin-right: calc(50% - 50vw);
    padding-left: 2vw;
    padding-right: 2vw;
    box-sizing: border-box;

    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    gap: clamp(14px, 1.5vw, 22px);

    height: clamp(420px, 45vw, 620px);
    overflow: hidden;
  }
  .apimo_property_gallery > a:not(.apimo_view_all_images):nth-child(n+6){
    display: none !important;
  }
  .apimo_property_gallery > a{
    position: relative;
    display: block;
    width: 100%;
    height: 100%;
    overflow: hidden;
    border-radius: 16px;
  }
  .apimo_property_gallery > a:nth-child(1){ grid-column: 1; grid-row: 1 / span 2; }
  .apimo_property_gallery > a:nth-child(2){ grid-column: 2; grid-row: 1; }
  .apimo_property_gallery > a:nth-child(3){ grid-column: 3; grid-row: 1; }
  .apimo_property_gallery > a:nth-child(4){ grid-column: 2; grid-row: 2; }
  .apimo_property_gallery > a:nth-child(5){ grid-column: 3; grid-row: 2; }

  .apimo_property_gallery img.apimo_single-apimo-img{
    position: absolute;
    inset: 0;
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    display: block !important;
  }
  .apimo_property_gallery .apimo_view_all_images{
    position: absolute !important;
    right: calc(2vw + 12px);
    bottom: max(16px, 1.2vw);
    z-index: 99 !important;
    background: rgba(0,0,0,0.7) !important;
    color: #fff !important;
    padding: 10px 16px !important;
    border-radius: 999px !important;
    font-weight: 700;
    display: inline-flex !important;
    align-items: center;
    gap: 8px;
    text-decoration: none !important;
    width: auto !important;
    height: auto !important;
    box-shadow: 0 2px 12px rgba(0,0,0,0.18);
    white-space: nowrap;
  }
  .apimo_property_gallery .apimo_view_all_images img{
    width: 18px !important;
    height: 18px !important;
    filter: brightness(0) invert(1);
    display: inline-block !important;
  }
  .apimo_carousel_arrows{ display: none !important; }
}

/* ===== Mobile/tablet: Exactly one image visible, no peeking, smaller height ===== */
@media (max-width: 991.98px){
  .apimo_property_gallery{
    position: relative;
    width: 100%;
    padding: 0;              /* no side padding to avoid peek */
    box-sizing: border-box;

    display: flex;
    gap: 0;                  /* no gap between slides */
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scroll-padding: 0;
    -webkit-overflow-scrolling: touch;
  }
  .apimo_property_gallery > a{
    flex: 0 0 100%;          /* exactly one slide per viewport */
    max-width: 100%;
    position: relative;
    display: block;
    aspect-ratio: 16 / 9;    /* moderate height; can adjust to 2 / 1 for even slimmer */
    border-radius: 0;        /* edge-to-edge slide */
    overflow: hidden;
    scroll-snap-align: start;
  }
  .apimo_property_gallery img.apimo_single-apimo-img{
    position: absolute;
    inset: 0;
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    display: block !important;
  }
  .apimo_property_gallery > a:nth-child(n+1){
    display: block !important;
  }

  /* Hide the CTA on mobile */
  .apimo_property_gallery .apimo_view_all_images{
    display: none !important;
  }

  /* Arrows: centered and closer */
  .apimo_carousel_arrows{
    display: flex;
    justify-content: center;
    gap: 8px;
    margin: 10px 0 0;
  }
  .apimo_carousel_btn{
    border: none;
    cursor: pointer;
    padding: 10px 14px;
    border-radius: 999px;
    background: rgba(0,0,0,0.75);
    color: #fff;
    font-size: 16px;
    line-height: 1;
    width: 50px;
  }
}

  /* === Custom full-screen gallery lightbox with thumbs === */
  .apimo_custom_lightbox{
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.9);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 99999;
  }
  .apimo_custom_lightbox.apimo_cl_open{
    display: flex;
  }
  .apimo_cl_inner{
    max-width: 1200px;
    width: 100%;
    max-height: 90vh;
    padding: 16px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    gap: 12px;
  }
  .apimo_cl_main{
    flex: 1 1 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    overflow: hidden;
    background: #000;
  }
  .apimo_cl_main_img{
    max-width: 100%;
    max-height: 100%;
    display: block;
    object-fit: contain;
  }
  .apimo_cl_close{
    position: absolute;
    top: 16px;
    right: 20px;
    border: none;
    background: rgba(0,0,0,0.7);
    color: #fff;
    font-size: 26px;
    width: 40px;
    height: 40px;
    border-radius: 999px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .apimo_cl_thumbs_row{
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .apimo_cl_thumbs_btn{
    border: none;
    background: rgba(255,255,255,0.08);
    color: #fff;
    width: 36px;
    height: 36px;
    border-radius: 999px;
    cursor: pointer;
    flex: 0 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
  }
  .apimo_cl_thumbs_wrapper{
    flex: 1 1 auto;
    overflow-x: auto;
    display: flex;
    gap: 8px;
    padding-bottom: 4px;
    scroll-behavior: smooth;
  }
  .apimo_cl_thumb{
    flex: 0 0 auto;
    width: 80px;
    height: 60px;
    border-radius: 6px;
    overflow: hidden;
    cursor: pointer;
    opacity: 0.7;
    border: 2px solid transparent;
  }
  .apimo_cl_thumb img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }
  .apimo_cl_thumb.apimo_cl_active{
    opacity: 1;
    border-color: #fff;
  }
  @media (max-width: 767.98px){
    .apimo_cl_inner{
      max-width: 100%;
      padding: 12px;
    }
    .apimo_cl_thumb{
      width: 64px;
      height: 48px;
    }
  }
</style>
<style id="apimo-sidebar-form-ui">
/* ===== Two-column layout (description + sticky contact form) ===== */
.apimo_breakout{
  width:100vw;
  margin-left:calc(50% - 50vw);
  margin-right:calc(50% - 50vw);
}
.apimo_breakout_inner{
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 16px;
}
@media (max-width: 767.98px){
  .apimo_breakout_inner{ padding: 0 12px; }
}

.apimo_content_with_sidebar{
  display:flex;
  gap:24px;
  align-items:flex-start;
}
.apimo_main_content{
  flex:1 1 auto;
  min-width:0;
}
.apimo_contact_sidebar{
  flex:0 0 360px;
  max-width:100%;
  position:sticky;
  top:96px;
  align-self:flex-start;
}

/* ===== Contact form restyle ===== */
.apimo_contact_sidebar .apimo_form_container{
  background:#fff;
  border:1px solid rgba(0,0,0,.08);
  border-radius:16px;
  padding:18px;
  box-shadow:0 10px 30px rgba(0,0,0,.06);
}
.apimo_contact_sidebar .apimo_form_title{
  margin-top:0;
  margin-bottom:10px;
  font-size:20px;
  line-height:1.2;
}
.apimo_contact_sidebar .apimo_form_row{
  display:flex;
  gap:10px;
}
.apimo_contact_sidebar .apimo_form_column{
  flex:1 1 0;
  min-width:0;
}
.apimo_contact_sidebar .apimo_input,
.apimo_contact_sidebar textarea.apimo_input{
  width:100%;
  border-radius:12px;
  border:1px solid rgba(0,0,0,.14);
  padding:12px 12px;
  font-size:15px;
  outline:none;
  transition: box-shadow .15s ease, border-color .15s ease;
}
.apimo_contact_sidebar .apimo_input:focus{
  border-color: rgba(0,0,0,.28);
  box-shadow: 0 0 0 4px rgba(0,0,0,.06);
}
.apimo_contact_sidebar .apimo_submit_button{
  width:100%;
  border-radius:12px;
  padding:12px 14px;
  font-weight:600;
}

/* Labels + textarea consistency */
/* Hide helper validation copy to save vertical space (still keeps fields required) */
.apimo_contact_sidebar .apimo_error_message{
  display:none !important;
}

.apimo_contact_sidebar .apimo_label{
  display:block;
  margin:10px 0 6px;
  font-size:13px;
  font-weight:700;
  letter-spacing:.2px;
  opacity:.85;
}
.apimo_contact_sidebar .apimo_label.apimo_required:after{
  content:" *";
  opacity:.7;
}
.apimo_contact_sidebar textarea.apimo_textarea{
  width:100%;
  border-radius:12px;
  border:1px solid rgba(0,0,0,.14);
  padding:12px 12px;
  font-size:15px;
  outline:none;
  min-height:120px;
  resize:vertical;
  transition: box-shadow .15s ease, border-color .15s ease;
}
.apimo_contact_sidebar textarea.apimo_textarea:focus{
  border-color: rgba(0,0,0,.28);
  box-shadow: 0 0 0 4px rgba(0,0,0,.06);
}

.apimo_contact_sidebar .apimo_phone_row{
  display:flex;
  gap:10px;
}
.apimo_contact_sidebar .apimo_phone_prefix{
  flex:0 0 125px;
  max-width:125px;
}
.apimo_contact_sidebar .apimo_phone_number{
  flex:1 1 auto;
}
@media (max-width: 640px){
  .apimo_contact_sidebar .apimo_phone_row{
    display:block;
  }
  .apimo_contact_sidebar .apimo_phone_prefix{
    margin-bottom:10px;
  }
}

/* Video should match map width */
.apimo_list_video{width:100%;}
.apimo_list_video .apimo_video{
  width:100%;
  aspect-ratio:16/9;
  height:auto;
  border:0;
  border-radius:12px;
  overflow:hidden;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  margin-bottom:20px;
}


/* ===== Agent banner inside sidebar ===== */
.apimo_agent_banner{
  border:1px solid rgba(0,0,0,.08);
  border-radius:16px;
  background:#fff;
  padding:14px;
  margin-bottom:14px;
  box-shadow: 0 10px 30px rgba(0,0,0,.06);
}
.apimo_agent_row{
  display:flex;
  gap:12px;
  align-items:center;
}
.apimo_agent_avatar{
  width:56px;
  height:56px;
  border-radius:14px;
  object-fit:cover;
  flex:0 0 56px;
}
.apimo_agent_meta{
  min-width:0;
}
.apimo_agent_name{
  font-weight:700;
  font-size:15px;
  line-height:1.2;
}
.apimo_agent_role{
  opacity:.72;
  font-size:13px;
  margin-top:2px;
}
.apimo_agent_actions{
  display:flex;
  gap:10px;
  margin-top:12px;
}
.apimo_agent_actions a{
  flex:1 1 0;
  text-align:center;
  padding:10px 12px;
  border-radius:12px;
  border:1px solid rgba(0,0,0,.12);
  font-weight:600;
  font-size:14px;
  text-decoration:none;
}
.apimo_agent_actions a:hover{
  border-color: rgba(0,0,0,.22);
}

/* Make the sidebar behave nicely on small screens */
@media (max-width: 992px){
  .apimo_content_with_sidebar{
    display:block;
  }
  .apimo_contact_sidebar{
    position:static;
    top:auto;
    margin-top:16px;
    flex-basis:auto;
  }
  .apimo_contact_sidebar .apimo_form_row{
    display:block;
  }
}


/* ===== Mobile fixed contact bar (mobile only) ===== */
.mobile-contact-bar{
  position: fixed;
  bottom: 12px;
  left: 12px;
  right: 12px;
  width: auto;
  height: 56px;
  background-color: #0C3C5E;
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 0 16px;
  font-size: 16px;
  font-weight: 600;
  text-decoration: none;
  border-radius: 12px;
  z-index: 99999;
  box-shadow: 0 -2px 12px rgba(0,0,0,.18);
  transition: opacity .3s ease, transform .3s ease;
}
.mobile-contact-bar svg{
  width: 18px;
  height: 18px;
  fill: currentColor;
  flex: 0 0 auto;
}
.mobile-contact-bar:hover{
  background-color: #0a334f;
}

/* Hide bar on desktop */
@media (min-width: 768px){
  .mobile-contact-bar{ display:none; }
}

/* Prevent content behind bar */
@media (max-width: 767px){
  body{ padding-bottom: 88px; }
}

html{ scroll-behavior: smooth; }
</style>



		<section>
			<div class=" apimo_property_gallery">
				<?php
				// Determine the thumbnail image source
				$src = empty($thumbnail) ? plugin_dir_url(dirname(__FILE__)) . 'assets/images/noimage.png' : $thumbnail;

				// Display the thumbnail image as the first image
				echo '<a data-fslightbox="gallery" href="' . esc_url($src) . '">
					<img src="' . esc_url($src) . '" class="apimo_single-apimo-img" alt="">
				</a>';

				// Load and display gallery images
				$apimo_gallery_images = maybe_unserialize($metas['apimo_gallery_images'][0]);


				$displayed_images = 1; // Start with one due to the thumbnail

				if (isset($apimo_gallery_images) && is_array($apimo_gallery_images)) {

					foreach ($apimo_gallery_images as $gallery_image) {
						// Skip displaying the thumbnail again
						if ($gallery_image === $src) {
							continue;
						}

						// Display the gallery image
						echo '<a data-fslightbox="gallery" href="' . esc_url($gallery_image) . '">
							<img src="' . esc_url($gallery_image) . '" class="apimo_single-apimo-img" alt="">
						</a>';
						$displayed_images++;
					}
				}

				// "View all images" link/button, shown only if there are more images
				if ($displayed_images > 3) {
					echo '<a href="#" class="apimo_view_all_images" data-open-lightbox="1">
					<img width="20" src="https://icon-library.com/images/photo-gallery-icon/photo-gallery-icon-13.jpg" alt="">Fotos ansehen
				</a>';
				} else {
					// If no additional images, hide the "View all images" button
					echo '<style>.apimo_view_all_images {display: none;}</style>';
				}
				?>
			</div>
<div id="apimo-custom-lightbox" class="apimo_custom_lightbox" aria-hidden="true">
  <div class="apimo_cl_inner">
    <button type="button" class="apimo_cl_close" aria-label="Galerie schließen">&times;</button>
    <div class="apimo_cl_main">
      <img src="" alt="" class="apimo_cl_main_img" />
    </div>
    <div class="apimo_cl_thumbs_row">
      <button type="button" class="apimo_cl_thumbs_btn apimo_cl_thumbs_prev" aria-label="Miniaturansicht nach links scrollen">‹</button>
      <div class="apimo_cl_thumbs_wrapper"></div>
      <button type="button" class="apimo_cl_thumbs_btn apimo_cl_thumbs_next" aria-label="Miniaturansicht nach rechts scrollen">›</button>
    </div>
  </div>
</div>
<script>
(function(){
const seeBtn = document.querySelector('.apimo_view_all_images[data-open-lightbox]');
const galleryLinks = document.querySelectorAll('.apimo_property_gallery a[data-fslightbox="gallery"]');
const lightbox = document.getElementById('apimo-custom-lightbox');
if (!seeBtn || !galleryLinks.length || !lightbox) return;

const body = document.body;
const mainImg = lightbox.querySelector('.apimo_cl_main_img');
const thumbsWrapper = lightbox.querySelector('.apimo_cl_thumbs_wrapper');
const closeBtn = lightbox.querySelector('.apimo_cl_close');
const prevThumbsBtn = lightbox.querySelector('.apimo_cl_thumbs_prev');
const nextThumbsBtn = lightbox.querySelector('.apimo_cl_thumbs_next');

// Funzione per rimuovere il suffisso -250x220, -768x512, ecc. prima dell'estensione
function normalizeImageUrl(url){
  if (!url) return url;
  return url.replace(/-\d+x\d+(?=\.[a-zA-Z]{3,4}$)/, '');
}

const images = Array.prototype.map.call(galleryLinks, function(a){
  let src = a.getAttribute('href') || (a.querySelector('img') ? a.querySelector('img').src : '');
  src = normalizeImageUrl(src);
  return src;
}).filter(Boolean);


  let currentIndex = 0;
  const thumbs = [];

  function renderThumbs(){
    thumbsWrapper.innerHTML = '';
    images.forEach(function(src, index){
      const thumb = document.createElement('button');
      thumb.type = 'button';
      thumb.className = 'apimo_cl_thumb';
      thumb.dataset.index = index;
      const img = document.createElement('img');
      img.src = src;
      img.alt = '';
      thumb.appendChild(img);
      thumb.addEventListener('click', function(){
        openAt(index);
      });
      thumbsWrapper.appendChild(thumb);
      thumbs.push(thumb);
    });
  }

  function updateActiveThumb(){
    thumbs.forEach(function(t, i){
      if (i === currentIndex) {
        t.classList.add('apimo_cl_active');
        const thumbRect = t.getBoundingClientRect();
        const wrapperRect = thumbsWrapper.getBoundingClientRect();
        if (thumbRect.left < wrapperRect.left || thumbRect.right > wrapperRect.right) {
          const offset = thumbRect.left - wrapperRect.left - (wrapperRect.width / 2) + (thumbRect.width / 2);
          thumbsWrapper.scrollBy({ left: offset, behavior: 'smooth' });
        }
      } else {
        t.classList.remove('apimo_cl_active');
      }
    });
  }

  function showImage(){
    if (!images.length) return;
    if (currentIndex < 0) currentIndex = images.length - 1;
    if (currentIndex >= images.length) currentIndex = 0;
    mainImg.src = images[currentIndex];
    updateActiveThumb();
  }

  function openAt(index){
    currentIndex = index || 0;
    if (!images[currentIndex]) currentIndex = 0;
    lightbox.classList.add('apimo_cl_open');
    lightbox.setAttribute('aria-hidden', 'false');
    if (body) body.style.overflow = 'hidden';
    showImage();
  }

  function closeLightbox(){
    lightbox.classList.remove('apimo_cl_open');
    lightbox.setAttribute('aria-hidden', 'true');
    if (body) body.style.overflow = '';
  }

  function scrollThumbs(dir){
    const amount = thumbsWrapper.clientWidth * 0.8 || 200;
    thumbsWrapper.scrollBy({ left: dir * amount, behavior: 'smooth' });
  }

  seeBtn.addEventListener('click', function(e){
    e.preventDefault();
    if (!thumbs.length) {
      renderThumbs();
    }
    openAt(0);
  });

  closeBtn && closeBtn.addEventListener('click', function(){
    closeLightbox();
  });

  lightbox.addEventListener('click', function(e){
    if (e.target === lightbox) {
      closeLightbox();
    }
  });

  prevThumbsBtn && prevThumbsBtn.addEventListener('click', function(){
    scrollThumbs(-1);
  });
  nextThumbsBtn && nextThumbsBtn.addEventListener('click', function(){
    scrollThumbs(1);
  });

  document.addEventListener('keydown', function(e){
    if (!lightbox.classList.contains('apimo_cl_open')) return;
    if (e.key === 'Escape') {
      closeLightbox();
    } else if (e.key === 'ArrowRight') {
      currentIndex++;
      showImage();
    } else if (e.key === 'ArrowLeft') {
      currentIndex--;
      showImage();
    }
  });
})();
</script>
<div class="apimo_carousel_arrows">
  <button class="apimo_carousel_btn apimo_prev" aria-label="Vorheriges Foto" type="button">‹</button>
  <button class="apimo_carousel_btn apimo_next" aria-label="Nächstes Foto" type="button">›</button>
</div>
<script>
(function(){
  const gallery = document.querySelector('.apimo_property_gallery');
  if(!gallery) return;
  const prev = document.querySelector('.apimo_carousel_arrows .apimo_prev');
  const next = document.querySelector('.apimo_carousel_arrows .apimo_next');
  if(!prev || !next) return;

  const isMobile = () => window.matchMedia('(max-width: 991.98px)').matches;
  function slideWidth(){
    const w = gallery.getBoundingClientRect().width; // since each slide is 100% width
    return w;
  }
  function go(dir){
    gallery.scrollBy({ left: dir * slideWidth(), behavior: 'smooth' });
  }
  prev.addEventListener('click', () => go(-1));
  next.addEventListener('click', () => go(1));

  function updateArrows(){
    const arrows = document.querySelector('.apimo_carousel_arrows');
    if (!arrows) return;
    arrows.style.display = isMobile() ? 'flex' : 'none';
  }
  updateArrows();
  window.addEventListener('resize', updateArrows);
})();
</script>

		</section>

		
		<div class="apimo_breakout">
			<div class="apimo_breakout_inner">
				<div class="apimo_content_with_sidebar">
			<div class="apimo_main_content">
<section class="apimo_section_compagne">
			<div class="apimo_info_compagne">
				<h1 class="apimo_title"><?php echo get_the_title(); ?></h1>
				<?php

				?>
				<p class="apimo_price" style="color:#0B3C5D;">
					<?php
					if ($metas['apimo_price_hide'][0]) {
						echo 'Preis auf Anfrage';
					} else {


						if ($metas['apimo_price'][0]) {

							$currency = $metas['apimo_price_currency'];

							echo esc_html(apimo_currency_format($metas['apimo_price'][0]), $currency);
						} else {
							echo esc_html(apimo_currency_format(0));
						}
					}
					?>

				</p>
			</div>
			<div class="apimo_location_info">
				<div class="Pro-address">
					<svg xmlns="http://www.w3.org/2000/svg" width="12.783" height="15.979" viewBox="0 0 12.783 15.979">
						<g id="noun_Location_94613" transform="translate(356 -253.3)">
							<path id="Path_11" data-name="Path 11" d="M-349.608,253.3A6.388,6.388,0,0,0-356,259.692c0,6.392,6.392,9.588,6.392,9.588s6.392-3.018,6.392-9.588A6.388,6.388,0,0,0-349.608,253.3Zm0,9.588a3.205,3.205,0,0,1-3.2-3.2,3.205,3.205,0,0,1,3.2-3.2,3.205,3.205,0,0,1,3.2,3.2A3.205,3.205,0,0,1-349.608,262.888Z" transform="translate(0 0)" fill="#0B3C5D" />
						</g>
					</svg>
					<?php if ($metas['apimo_publish_address'][0]) : ?>
						<span class="value">
							<?php if ($city) {
								echo esc_html($city);
							} ?>
							<?php if ($metas['apimo_address'][0]) {
								echo ' - ' . esc_html($metas['apimo_address'][0]);
							} ?>
						</span>
					<?php else : ?>
						<span class="value">
							<!-- Show only city -->
							<?php if ($city) {
								echo esc_html($city);
							} ?>
						</span>
					<?php endif; ?>
				</div>
				<p class="apimo_color">
					<?php
					echo "#" . esc_html($metas['apimo_id'][0]);
					?>
				</p>
			</div>

			<ul class="apimo_list_image">
				<li class="apimo_list_item">
					<!-- Floor Plan Icon -->
					<svg id="noun_floor_plan_3338563" data-name="noun_floor plan_3338563" xmlns="http://www.w3.org/2000/svg" width="24.511" height="24.511" viewBox="0 0 24.511 24.511">
						<path id="Path_12" data-name="Path 12" d="M32.06,15.821H34.2a.306.306,0,0,0,.306-.306V10.306A.306.306,0,0,0,34.2,10h-23.9a.306.306,0,0,0-.306.306V34.2a.306.306,0,0,0,.306.306H34.2a.306.306,0,0,0,.306-.306V19.5a.613.613,0,1,0-1.226,0v2.451H29.3a.613.613,0,0,0,0,1.226H32.06v8.579h-6.1V26.295a.613.613,0,1,0-1.226,0v5.459H13.064V23.175h2.145v2.757a.613.613,0,0,0,1.226,0V23.175h9.8a.613.613,0,0,0,0-1.226h-.306V21.03a.613.613,0,0,0-1.226,0v.919H13.064V12.757H24.706v4.9a.613.613,0,0,0,1.226,0v-.306h3.677a.613.613,0,1,0,0-1.226H25.932v-3.37h5.821v2.757A.306.306,0,0,0,32.06,15.821Z" transform="translate(-10 -10)" fill="#0B3C5D" />
					</svg>
					<p style="color:#0B3C5D;">
						<?php echo esc_html($metas['apimo_rooms'][0] ?? 0); ?> <?php echo 'Zimmer'; ?>
					</p>
				</li>
				<li class="apimo_list_item">
					<!-- Bathroom Icon -->
					<svg xmlns="http://www.w3.org/2000/svg" width="21.608" height="24.511" viewBox="0 0 21.608 24.511">
						<g id="noun_Bath_4032349" transform="translate(0)">
							<path id="Path_1" data-name="Path 1" d="M25.026,13.963H4.755V3.213A2.252,2.252,0,0,1,7,.961a1.5,1.5,0,0,1,1.08.44l.475.479A2.535,2.535,0,0,0,8.37,5.155l.2.26a.383.383,0,0,0,.295.146.341.341,0,0,0,.222-.077L12.633,2.8a.383.383,0,0,0,.046-.529l-.2-.257A2.524,2.524,0,0,0,9.328,1.3L8.753.724A2.455,2.455,0,0,0,7,0,3.217,3.217,0,0,0,3.79,3.213V17.46a5.45,5.45,0,0,0,5.059,5.431h0v1.237a.383.383,0,1,0,.766,0V22.906h9.957v1.222a.383.383,0,1,0,.766,0V22.891h0A5.45,5.45,0,0,0,25.4,17.46V14.335A.383.383,0,0,0,25.026,13.963Z" transform="translate(-3.79 0)" fill="#0B3C5D" />
							<path id="Path_2" data-name="Path 2" d="M20.061,17.1a.479.479,0,0,0,.207-.306.463.463,0,0,0-.073-.36l-.421-.632a.483.483,0,0,0-.666-.134.471.471,0,0,0-.2.306.479.479,0,0,0,.069.36l.421.632a.486.486,0,0,0,.4.214A.46.46,0,0,0,20.061,17.1Z" transform="translate(-13.109 -9.62)" fill="#0B3C5D" />
							<path id="Path_3" data-name="Path 3" d="M21.026,23.82a.486.486,0,0,0,.437.272.484.484,0,0,0,.452-.318.49.49,0,0,0-.019-.383l-.326-.686a.483.483,0,0,0-.437-.276.484.484,0,0,0-.452.318.49.49,0,0,0,.019.383Z" transform="translate(-14.194 -13.84)" fill="#0B3C5D" />
							<path id="Path_4" data-name="Path 4" d="M23.484,30.893a.479.479,0,0,0,.448.3.484.484,0,0,0,.44-.291.456.456,0,0,0,0-.383l-.28-.709a.479.479,0,0,0-.448-.3.467.467,0,0,0-.176.034.46.46,0,0,0-.264.257.471.471,0,0,0,0,.383Z" transform="translate(-15.744 -18.208)" fill="#0B3C5D" />
							<path id="Path_5" data-name="Path 5" d="M23.418,14.347a.479.479,0,0,0,.23-.061.493.493,0,0,0,.188-.67l-.383-.666a.475.475,0,0,0-.651-.188.493.493,0,0,0-.188.67L23,14.1a.479.479,0,0,0,.421.249Z" transform="translate(-15.364 -7.836)" fill="#0B3C5D" />
							<path id="Path_6" data-name="Path 6" d="M27,21a.5.5,0,0,0,.234-.057.479.479,0,0,0,.188-.655l-.383-.666a.479.479,0,0,0-.421-.249.505.505,0,0,0-.234.061.479.479,0,0,0-.188.655l.383.666A.475.475,0,0,0,27,21Z" transform="translate(-17.574 -11.952)" fill="#0B3C5D" />
							<path id="Path_7" data-name="Path 7" d="M29.787,26.263a.494.494,0,0,0,.042.383l.383.663a.483.483,0,1,0,.843-.463l-.383-.666a.486.486,0,0,0-.421-.249.494.494,0,0,0-.234.061.479.479,0,0,0-.23.272Z" transform="translate(-19.817 -15.999)" fill="#0B3C5D" />
							<path id="Path_8" data-name="Path 8" d="M26.722,11.051l.383.666a.494.494,0,0,0,.421.245.463.463,0,0,0,.234-.061.483.483,0,0,0,.184-.655L27.56,10.6a.479.479,0,0,0-.421-.249.506.506,0,0,0-.234.061.483.483,0,0,0-.184.64Z" transform="translate(-17.905 -6.386)" fill="#0B3C5D" />
							<path id="Path_9" data-name="Path 9" d="M31.692,17.357a.479.479,0,0,0,.349.149.49.49,0,0,0,.329-.126.471.471,0,0,0,.153-.337.479.479,0,0,0-.13-.345l-.521-.555a.49.49,0,0,0-.352-.153.483.483,0,0,0-.349.812Z" transform="translate(-20.604 -9.866)" fill="#0B3C5D" />
							<path id="Path_10" data-name="Path 10" d="M36.475,23.107a.49.49,0,0,0,.682.023.483.483,0,0,0,.023-.682l-.521-.555a.49.49,0,0,0-.352-.153.481.481,0,0,0-.349.812Z" transform="translate(-23.557 -13.414)" fill="#0B3C5D" />
						</g>
					</svg>
					<span style="color:#0B3C5D;">
						<?php echo esc_html($metas['apimo_bathrooms'][0] ?? 0); ?> <?php echo 'Badezimmer'; ?>
					</span>
				</li>
				<li class="apimo_list_item">
					<!-- Measure Icon -->
					<svg id="noun_measure_4212089" xmlns="http://www.w3.org/2000/svg" width="24.83" height="24.588" viewBox="0 0 24.83 24.588">
						<path id="Path_13" data-name="Path 13" d="M29.579,26.363l-2.125-2.125a.9.9,0,0,0-1.269,1.269l.607.607H8.964V8.536l.607.607a.951.951,0,0,0,.635.276.838.838,0,0,0,.635-.276.883.883,0,0,0,0-1.269L8.716,5.748a.971.971,0,0,0-1.3,0L5.294,7.873A.9.9,0,0,0,6.563,9.143l.607-.607v19.4H26.792l-.607.607a.883.883,0,0,0,0,1.269.951.951,0,0,0,.635.276.838.838,0,0,0,.635-.276l2.125-2.125a1.018,1.018,0,0,0,.276-.662A.856.856,0,0,0,29.579,26.363Z" transform="translate(-5.025 -5.5)" fill="#0B3C5D" />
						<path id="Path_14" data-name="Path 14" d="M30.811,34.253H42.87a.919.919,0,0,0,.911-.911V21.311a.919.919,0,0,0-.911-.911H30.811a.919.919,0,0,0-.911.911V33.37A.914.914,0,0,0,30.811,34.253Z" transform="translate(-23.035 -16.288)" fill="#0B3C5D" />
					</svg>
					<p style="color:#0B3C5D;">
						<?php
						echo esc_html($metas['apimo_area_display_filter'][0] ?? 0);
						if (isset($metas['apimo_area_unit'][0]) && isset($UNIT_AREA[$metas['apimo_area_unit'][0]])) {
							echo ' ' . esc_html($UNIT_AREA[$metas['apimo_area_unit'][0]]);
						}
						?>
					</p>
				</li>
				<?php if (!empty($flor)) : ?>
					<li class="apimo_list_item">
						<!-- Stairs Icon -->
						<svg xmlns="http://www.w3.org/2000/svg" width="24.596" height="19.032" viewBox="0 0 24.596 19.032">
							<g id="noun_Stairs_1137999" transform="translate(-5.8 -15.8)">
								<g id="Group_1" data-name="Group 1" transform="translate(5.8 15.8)">
									<path id="Path_15" data-name="Path 15" d="M29.84,968.162a.557.557,0,0,1,.556.557v17.919a.556.556,0,0,1-.556.556H6.447c-.454,0-.645-.185-.647-.646v-4.365a.556.556,0,0,1,.556-.557h5.32V977.76a.556.556,0,0,1,.557-.556h5.309v-3.8a.557.557,0,0,1,.557-.557h5.309v-4.129a.557.557,0,0,1,.556-.556H29.84Z" transform="translate(-5.8 -968.162)" fill="#6a6a6a" fill-rule="evenodd" />
								</g>
							</g>
						</svg>
						<p><?php echo esc_html(apimo_translate_property_value($flor)); ?></p>
					</li>
				<?php endif; ?>
			</ul>

			<?php
			$currentLanguage = get_bloginfo('language');
			$lang = explode('-', $currentLanguage)[0];
			$is_content = false;

			$unserialized_data = maybe_unserialize($metas['apimo_content'][0]);

			if (is_array($unserialized_data)) {
				foreach ($unserialized_data as $language) {
					if ($language->language == $lang) {
						echo '<p class="apimo_compagne_describe">' . nl2br(($language->comment_full != null || !empty($language->comment_full)) ? $language->comment_full : $language->comment) . '</p>';
					}
				}
			}
			?>

					<!-- Video moved directly under description -->
		<?php if (isset($metas['apimo_medias']) && !empty($metas['apimo_medias'][0])) : ?>
			<?php
			$apimo_medias_data = $metas['apimo_medias'];

			if ($apimo_medias_data && isset($apimo_medias_data) && !empty($apimo_medias_data)) {
				// Unserialize the first element of the array to check if it's an empty array
				$unserializedData = @unserialize($apimo_medias_data[0]);
				if ($unserializedData !== false && is_array($unserializedData) && !empty($unserializedData)) {
			?>
					<div class="apimo_line"></div>

					<section>
						<h2 class="apimo_title_h2">Video</h2>
						<div class="apimo_list_video">
							<?php
							foreach ($metas['apimo_medias'] as $media_serialized) {
								$media_unserialized = maybe_unserialize($media_serialized);
								if (is_array($media_unserialized) && !empty($media_unserialized)) {
									foreach ($media_unserialized as $media) {
										if (isset($media->value) && !empty($media->value)) {
											// Convert YouTube short URLs into embed URLs
											$embedUrl = $media->value;
											if (preg_match('/https:\/\/youtu\.be\/([a-zA-Z0-9_-]+)/', $media->value, $matches)) {
												$videoId = $matches[1];
												$embedUrl = "https://www.youtube.com/embed/$videoId";
											} elseif (preg_match('/https:\/\/www\.youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $media->value, $matches)) {
												$videoId = $matches[1];
												$embedUrl = "https://www.youtube.com/embed/$videoId";
											}
							?>
											<iframe class="apimo_video" src="<?php echo esc_url($embedUrl); ?>" frameborder="0" allowfullscreen></iframe>

							<?php
										} else {
											echo '<p>Fehlende oder leere URL.</p>';
										}
									}
								}
							}
							?>
						</div>
					</section>
			<?php
				}
			}
			?>

		<?php endif; ?>

																															   




			

		</section>

		<div class="apimo_line"></div>
		<section>
			<h2 class="apimo_title_h2"><?php echo 'Informationen'; ?></h2>
			<div class="apimo_property_list apimo_general_information">
				<?php if ($apimo_category) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php echo 'Kategorie'; ?>:</dt>
						<dd class="apimo_property_value"><?php echo esc_html(apimo_translate_property_value($apimo_category)); ?></dd>
					</dl>
				<?php endif; ?>

				<?php if ($subtype && $type) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php echo 'Typ'; ?>:</dt>
						<dd class="apimo_property_value"><?php echo esc_html(apimo_translate_property_value($type)); ?> / <?php echo esc_html(apimo_translate_property_value($subtype)); ?></dd>
					</dl>
				<?php endif; ?>

				<?php if ($construction_years) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php echo 'Baujahr'; ?>:</dt>
						<dd class="apimo_property_value"><?php echo esc_html($construction_years); ?></dd>
					</dl>
				<?php endif; ?>

				<?php if ($condition) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php echo 'Zustand'; ?>:</dt>
						<dd class="apimo_property_value"><?php echo esc_html(apimo_translate_property_value($condition)); ?></dd>
					</dl>
				<?php endif; ?>

				<?php if ($availability) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php echo 'Verfügbarkeit'; ?>:</dt>
						<dd class="apimo_property_value"><?php echo esc_html(apimo_translate_property_value($availability)); ?></dd>
					</dl>
				<?php endif; ?>

				<?php if ($property_standing) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php echo 'Ausstattungsstandard'; ?>:</dt>
						<dd class="apimo_property_value"><?php echo esc_html(apimo_translate_property_value($property_standing)); ?></dd>
					</dl>
				<?php endif; ?>

				<?php if ( function_exists('get_field') ) : ?>

					<?php
					// ACF: servizi (checkbox)
					$servizi = get_field('servizi');
					if ( ! empty($servizi) ) :

						if ( is_array($servizi) ) {
							$servizi_output = apimo_translate_property_list($servizi);
						} else {
							$servizi_output = esc_html(apimo_translate_property_value($servizi));
						}

						if ( ! empty($servizi_output) ) :
					?>
							<dl class="apimo_property">
								<dt class="apimo_property_title">
									<?php echo 'Ausstattung'; ?>:
								</dt>
								<dd class="apimo_property_value">
									<?php echo $servizi_output; ?>
								</dd>
							</dl>
					<?php
						endif;
					endif;

					// ACF: view (checkbox)
					$view = get_field('view');
					if ( ! empty($view) ) :

						if ( is_array($view) ) {
							$view_output = apimo_translate_property_list($view);
						} else {
							$view_output = esc_html(apimo_translate_property_value($view));
						}

						if ( ! empty($view_output) ) :
					?>
							<dl class="apimo_property">
								<dt class="apimo_property_title">
									<?php echo 'Ausblick'; ?>:
								</dt>
								<dd class="apimo_property_value">
									<?php echo $view_output; ?>
								</dd>
							</dl>
					<?php
						endif;
					endif;
					?>
					<?php // ACF: metratura_terreno (numeric)
					$metratura_terreno = get_field('metratura_terreno');
					if ( $metratura_terreno !== '' && $metratura_terreno !== null ) :
						$metratura_terreno_val = floatval($metratura_terreno);
					?>
						<dl class="apimo_property">
							<dt class="apimo_property_title">
								<?php echo 'Grundstück'; ?>:
							</dt>
							<dd class="apimo_property_value">
								<?php echo esc_html($metratura_terreno_val); ?> m²
							</dd>
						</dl>
					<?php endif; ?>


				<?php endif; ?>



				<?php
				if (isset($metas['apimo_area_display_filter'][0]) && $metas['apimo_area_display_filter'][0]) :
					$area = esc_html($metas['apimo_area_display_filter'][0]);
					$unit = isset($metas['apimo_area_unit'][0]) && isset($UNIT_AREA[$metas['apimo_area_unit'][0]]) ? esc_html($UNIT_AREA[$metas['apimo_area_unit'][0]]) : '';
				?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php echo 'Fläche'; ?>:</dt>
						<dd class="apimo_property_value"><?php echo $area . ' ' . $unit; ?></dd>
					</dl>
				<?php endif; ?>

				<?php if ($flor) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php echo 'Etage'; ?>:</dt>
						<dd class="apimo_property_value"><?php echo esc_html(apimo_translate_property_value($flor)); ?></dd>
					</dl>
				<?php endif; ?>

				<!-- Continuing from Price, Rooms, and Bathrooms... -->

				<?php if (isset($metas['apimo_price_hide'][0]) && !$metas['apimo_price_hide'][0]) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php echo 'Preis'; ?>:</dt>
						<dd class="apimo_property_value">
							<?php echo ($metas['apimo_price'][0]) ? esc_html(apimo_currency_format($metas['apimo_price'][0])) : 'Nicht angegeben'; ?>
						</dd>
					</dl>
				<?php endif; ?>

				<?php if (isset($metas['apimo_rooms'][0])) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php echo 'Zimmer'; ?>:</dt>
						<dd class="apimo_property_value"><?php echo esc_html($metas['apimo_rooms'][0]); ?></dd>
					</dl>
				<?php endif; ?>

				<?php if (isset($metas['apimo_bathrooms'][0])) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php echo 'Badezimmer'; ?>:</dt>
						<dd class="apimo_property_value"><?php echo esc_html($metas['apimo_bathrooms'][0]); ?></dd>
					</dl>
				<?php endif; ?>

				<!-- Handling APE and other regulations with unserialized data -->
				<?php
				if (isset($metas['apimo_regulations'][0])) {
					$unserialized_data = maybe_unserialize($metas['apimo_regulations'][0]);
					if (is_array($unserialized_data)) {
						foreach ($unserialized_data as $regulation) {
							if ($regulation->type == 13) : ?>
								<dl class="apimo_property">
									<dt class="apimo_property_title"><?php echo 'APE'; ?>:</dt>
									<dd class="apimo_property_value"><?php echo esc_html($regulation->value); ?></dd>
								</dl>
				<?php endif;
						}
					}
				}
				?>

<!-- Fortsetzung mit Heizungsart, Zugang, Gerät und Warmwassersystem -->
<?php if ($heating_type) : ?>
	<dl class="apimo_property">
		<dt class="apimo_property_title"><?php echo 'Heizungsart'; ?>:</dt>
		<dd class="apimo_property_value"><?php echo esc_html(apimo_translate_property_value($heating_type)); ?></dd>
	</dl>
<?php endif; ?>

<?php if ($heating_access) : ?>
	<dl class="apimo_property">
		<dt class="apimo_property_title"><?php echo 'Heizungszugang'; ?>:</dt>
		<dd class="apimo_property_value"><?php echo esc_html(apimo_translate_property_value($heating_access)); ?></dd>
	</dl>
<?php endif; ?>

<?php if ($heating_device) : ?>
	<dl class="apimo_property">
		<dt class="apimo_property_title"><?php echo 'Heizgerät'; ?>:</dt>
		<dd class="apimo_property_value"><?php echo esc_html(apimo_translate_property_value($heating_device)); ?></dd>
	</dl>
<?php endif; ?>

<?php if ($water_hot_device) : ?>
	<dl class="apimo_property">
		<dt class="apimo_property_title"><?php echo 'Warmwassergerät'; ?>:</dt>
		<dd class="apimo_property_value"><?php echo esc_html(apimo_translate_property_value($water_hot_device)); ?></dd>
	</dl>
<?php endif; ?>

<?php if ($water_hot_access) : ?>
	<dl class="apimo_property">
		<dt class="apimo_property_title"><?php echo 'Warmwasserzugang'; ?>:</dt>
		<dd class="apimo_property_value"><?php echo esc_html(apimo_translate_property_value($water_hot_access)); ?></dd>
	</dl>
<?php endif; ?>

<?php if ($water_waste) : ?>
	<dl class="apimo_property">
		<dt class="apimo_property_title"><?php echo 'Abwassersystem'; ?>:</dt>
		<dd class="apimo_property_value"><?php echo esc_html(apimo_translate_property_value($water_waste)); ?></dd>
	</dl>
<?php endif; ?>

				<!-- Example for custom fees and period descriptions with serialized data -->
				<?php
				$property_period = [
					1 => 'Tag',
					2 => 'Woche',
					3 => '14 Tage',
					4 => 'Monat',
					5 => 'Vierteljährlich',
					6 => 'Zweimonatlich',
					7 => 'Halbjährlich',
					8 => 'Jährlich'
				];
				if (isset($metas['apimo_residence'])) {
					$residence_data = maybe_unserialize($metas['apimo_residence']);
					if (is_array($residence_data)) {
						foreach ($residence_data as $residence) {
							if (!empty($residence->fees) && !empty($residence->period)) {
								$period_description = $property_period[$residence->period] ?? 'Unbekannter Zeitraum';
				?>
								<dl class="apimo_property">
									<dt class="apimo_property_title"><?php echo 'Gebühren'; ?>:</dt>
									<dd class="apimo_property_value"><?php echo esc_html($residence->fees) . " (€ / " . esc_html($period_description) . ")"; ?></dd>
								</dl>
				<?php
							}
						}
					}
				}
				?>

			</div>


			<span class="apimo_more" id="view_more_general_informations" style="color:<?php echo $secondary_color; ?>;!important">
				<p><?php echo 'Mehr anzeigen' ?></p>
				<img class="apimo_vector" src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/images/icone-down.png' ?>" alt="" />
			</span>
		</section>
<?php if (isset($metas['apimo_property_location'])) : ?>
	<div class="apimo_line"></div>

	<section>
		<h2 class="apimo_title_h2"><?php echo 'Standortdetails'; ?></h2>
		<?php
		$latitude = $longitude = '';
		$locationDetails = ''; // Initialize variable to hold location details for display

		// Check if $metas['apimo_property_location'] is an array
		if (is_array($metas['apimo_property_location'])) {
			// Loop through each serialized element
			foreach ($metas['apimo_property_location'] as $serializedLocation) {
				// Unserialize the data
				$location = unserialize($serializedLocation);

				// Construct location details string
				$detailsArray = [];
				if (!empty($location['country'])) {
					$detailsArray[] = esc_html($location['country']);
				}
				if (is_object($location['region']) && $location['region']->name) {
					$detailsArray[] = esc_html($location['region']->name);
				}
				if (is_object($location['city']) && $location['city']->name) {
					$detailsArray[] = esc_html($location['city']->name);
				}
				if (is_object($location['district']) && $location['district']->name) {
					$detailsArray[] = esc_html($location['district']->name);
				}
				$locationDetails = implode(', ', $detailsArray);

				// Get coordinates for OpenStreetMap
				if ($location['latitude'] && $location['longitude']) {
					$latitude = $location['latitude'];
					$longitude = $location['longitude'];
				}
			}
		}

		// Display OpenStreetMap if coordinates are available
		if ($latitude && $longitude) : ?>
			<div id="property-map" style="width: 100%; height: 400px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 20px; z-index:0;"></div>
			<script>
document.addEventListener('DOMContentLoaded', function () {
  if (!window.L) {
    console.warn('Leaflet wurde nicht geladen: L ist nicht definiert');
    return;
  }

  const lat = <?php echo json_encode((float) str_replace(',', '.', $latitude)); ?>;
  const lng = <?php echo json_encode((float) str_replace(',', '.', $longitude)); ?>;

  if (!lat || !lng) {
    console.warn('Fehlende oder ungültige Koordinaten:', lat, lng);
    return;
  }

  const map = L.map('property-map', { scrollWheelZoom: false }).setView([lat, lng], 14);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap'
  }).addTo(map);

  const icon = L.divIcon({
    className: 'custom-property-marker',
    html: '<div class="property-marker-pin"><div class="property-marker-icon">🏠</div></div>',
    iconSize: [40, 40],
    iconAnchor: [20, 40],
    popupAnchor: [0, -40]
  });

  L.marker([lat, lng], { icon }).addTo(map);

  // Se la mappa è in un tab/accordion o area nascosta, questo evita “mappa grigia”
  setTimeout(() => map.invalidateSize(), 200);
});
</script>

						<script>
			document.addEventListener('DOMContentLoaded', function () {
				const contactBar = document.querySelector('.mobile-contact-bar');
				const contactForm = document.querySelector('#contact-form');
				if (!contactBar || !contactForm) return;

				const observer = new IntersectionObserver(function (entries) {
					entries.forEach(entry => {
						if (entry.isIntersecting) {
							contactBar.style.opacity = '0';
							contactBar.style.pointerEvents = 'none';
							contactBar.style.transform = 'translateY(80px)';
						} else {
							contactBar.style.opacity = '1';
							contactBar.style.pointerEvents = 'auto';
							contactBar.style.transform = 'translateY(0)';
						}
					});
				}, { threshold: 0.25 });

				observer.observe(contactForm);
			});
			</script>

			<style>
			/* Stili per il marker personalizzato */
			.custom-property-marker {
				background: transparent;
				border: none;
			}

			.property-marker-pin {
				position: relative;
				width: 40px;
				height: 40px;
				background: #0b3c5d;
				border: 3px solid white;
				border-radius: 50% 50% 50% 0;
				transform: rotate(-45deg);
				box-shadow: 0 2px 8px rgba(11, 60, 93, 0.4);
			}

			.property-marker-icon {
				position: absolute;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%) rotate(45deg);
				font-size: 16px;
			}

			/* Stili per il popup */
			.leaflet-popup-content-wrapper {
				background: rgba(255, 255, 255, 0.95) !important;
				backdrop-filter: blur(10px) !important;
				border-radius: 12px !important;
				box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important;
				padding: 0 !important;
			}

			.leaflet-popup-content {
				margin: 0 !important;
				padding: 15px !important;
			}

			.leaflet-popup-tip {
				background: rgba(255, 255, 255, 0.95) !important;
			}

			.property-popup {
				text-align: center;
			}

			/* Controlli zoom stile moderno */
			.leaflet-control-zoom {
				border: none !important;
				border-radius: 8px !important;
				overflow: hidden !important;
				box-shadow: 0 2px 12px rgba(0,0,0,0.1) !important;
			}

			.leaflet-control-zoom a {
				background: rgba(255, 255, 255, 0.9) !important;
				border: none !important;
				color: #0b3c5d !important;
				font-weight: 600 !important;
				line-height: 26px !important;
				text-decoration: none !important;
			}

			.leaflet-control-zoom a:hover {
				background: #0b3c5d !important;
				color: white !important;
			}

			/* Responsiv */
			@media (max-width: 768px) {
				#property-map {
					height: 300px;
				}
			}
			</style>
		<?php endif; ?>

		<?php if ($locationDetails) : ?>
			<span class="apimo_list_item">
				<svg xmlns="http://www.w3.org/2000/svg" width="12.783" height="15.979" viewBox="0 0 12.783 15.979">
					<g id="noun_Location_94613" transform="translate(356 -253.3)">
						<path id="Path_11" data-name="Path 11" d="M-349.608,253.3A6.388,6.388,0,0,0-356,259.692c0,6.392,6.392,9.588,6.392,9.588s6.392-3.018,6.392-9.588A6.388,6.388,0,0,0-349.608,253.3Zm0,9.588a3.205,3.205,0,0,1-3.2-3.2,3.205,3.205,0,0,1,3.2-3.2,3.205,3.205,0,0,1,3.2,3.2A3.205,3.205,0,0,1-349.608,262.888Z" transform="translate(0 0)" fill="#6a6a6a"></path>
					</g>
				</svg>
				<p><?php echo $locationDetails; ?></p>
			</span>
		<?php endif; ?>
	</section>
<?php endif; ?>



		<?php
		if (isset(($unserialized_data[0]))) {
			if ($unserialized_data[0]->graph && $unserialized_data[0]->type == '1') {
		?>
				<div class="apimo_line"></div>

				<section>
					<h2 class="apimo_title_h2"><?php echo 'Energieeffizienz'; ?></h2>
					<ul class="apimo_performance_images">
						<li>
							<img class="apimo_image" src="<?php echo $unserialized_data[0]->graph ?>" alt="graph">

						</li>

					</ul>
				</section>
		<?php
			}
		}

		?>




















		<?php
		if (isset($metas['apimo_regulations']) && !empty($metas['apimo_regulations'][0])) {
			$unserializedArray = unserialize($metas['apimo_regulations'][0]);



			if (!empty($unserializedArray)) {
		?>
				<div class="apimo_line"></div>

				<section>
					<h2 class="apimo_title_h2"><?php echo 'VORSCHRIFTEN'; ?> :</h2>
					<div class="apimo_property_list apimo_regulations">
						<!--Regulementation -->
						<?php
						if (isset($metas['apimo_regulations']) && is_array($metas['apimo_regulations'])) {
							// Define a function to compare the presence of the 'graph' key
							function sortByGraph($a, $b)
							{
								if (isset($a->graph) && !isset($b->graph)) {
									return -1; // $a has 'graph', so it comes before $b
								} elseif (!isset($a->graph) && isset($b->graph)) {
									return 1; // $b has 'graph', so it comes before $a
								}
								return 0; // Both have or don't have 'graph', maintain order
							}

							foreach ($metas['apimo_regulations'] as $regulations_data) {
								$unserialized_data = maybe_unserialize($regulations_data);
								if (is_array($unserialized_data)) {
									// Sort the array based on the presence of 'graph' key


									usort($unserialized_data, 'sortByGraph');
									foreach ($unserialized_data as $regulation) {
										// Use getPropertyName to only get the property name
										$propertyName = getPropertyName($regulation->type, $property_reglementation);

										// Format the value display logic as before
										$valueDisplay = $regulation->value;
										if ($regulation->value == '0') {
											$valueDisplay = "Nein";
										} elseif ($regulation->value == '1') {
											$valueDisplay = "Inbegriffen";
										}

										// Find the unit for the current item, if available
										$unit = "";
										foreach ($property_reglementation as $item) {
											if ($item["id"] == $regulation->type && isset($item["value"])) {
												$unit = " (" . $item["value"] . ")";
												break;
											}
										}

										// $valueDisplay = _e($valueDisplay , 'apimo'); 
						?>

										<dl class="apimo_property">
											<dt class="apimo_property_title"><?php echo esc_html__($propertyName, 'apimo'); ?></dt>
											<dd class="apimo_property_value"><?php echo stripslashes(__($valueDisplay, 'apimo') . $unit); ?></dd>

										</dl>


						<?php
									}
								}
							}
						}
						?>

					</div>
					<span class="apimo_more" id="view_more_apimo_regulations" style="color:<?php echo $secondary_color; ?>;!important>
						<p><?php echo 'Mehr anzeigen' ?></p>

						<img class=" apimo_vector" src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/images/icone-down.png' ?>" alt="" />
					</span>
				</section>
		<?php
			}
		}
		?>

<div style="margin-top:50px; margin-bottom:50px;"> </div>
		
<!--Documents -->
<?php  
if (isset($metas['apimo_documents']) && is_array($metas['apimo_documents']) && !empty($metas['apimo_documents'])):
    foreach ($metas['apimo_documents'] as $serializedDoc):
        $doc = unserialize($serializedDoc);
        if (isset($doc[0])):
            ?>
            <div class="Pro-info">
                <h5 class="Pro-info-title"><?php echo 'Dokumente'; ?></h5>
 
                <?php 
                    $docs = $metas['apimo_documents'];
                    if (is_array($docs) && !empty($docs)):
                        ?>
                        <div class="apimo-documents-section">
                            <?php 
                                foreach ($docs as $serializedDoc):
                                    $doc = unserialize($serializedDoc); 
                                    if (is_array($doc) && !empty($doc)):
                                        foreach ($doc as $singleDoc):
                                            if (!empty($singleDoc->name) && !empty($singleDoc->filesize) && !empty($singleDoc->download_url)):
                                                $file_extension = strtolower(pathinfo($singleDoc->name, PATHINFO_EXTENSION));
                                                $file_name = pathinfo($singleDoc->name, PATHINFO_FILENAME);
                                                ?>
                                                <div class="document-card" style="border: 1px solid #ddd; border-radius: 8px; margin-bottom: 20px; overflow: hidden;">
                                                    <!-- Dokument-Header -->
                                                    <div class="doc-header" style="background: #f8f9fa; padding: 15px; display: flex; justify-content: space-between; align-items: center;">
                                                        <div>
                                                            <h6 style="margin-bottom: 10px; color: #333; font-weight: 600;"><?= $file_name; ?></h6>
                                                            <small style="color: #666;"><?= strtoupper($file_extension); ?> • <?= $singleDoc->filesize; ?> KB</small>
                                                        </div>
                                                        <div style="display: flex; gap: 10px;">
                                                            <?php if ($file_extension === 'pdf'): ?>
                                                                <button onclick="togglePdfViewer('pdf-viewer-<?= md5($singleDoc->download_url); ?>')" 
                                                                        style="background: #007cba; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">
                                                                    📄 PDF anzeigen
                                                                </button>
                                                            <?php elseif (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                                                                <button onclick="toggleImageViewer('img-viewer-<?= md5($singleDoc->download_url); ?>')" 
                                                                        style="background: #007cba; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">
                                                                    🖼️ Bild anzeigen
                                                                </button>
                                                            <?php endif; ?>
                                                            <a href="<?= $singleDoc->download_url; ?>" 
                                                               download="<?= $singleDoc->name; ?>"
                                                               style="background: #28a745; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; display: inline-block;">
                                                                ⬇️ Herunterladen
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <!-- Contenitore per visualizzazione -->
                                                    <?php if ($file_extension === 'pdf'): ?>
                                                        <div id="pdf-viewer-<?= md5($singleDoc->download_url); ?>" class="pdf-viewer" style="display: none; padding: 0;">
                                                            <div style="position: relative; width: 100%; height: 700px;">
                                                                <iframe src="https://docs.google.com/viewer?url=<?= urlencode($singleDoc->download_url); ?>&embedded=true" 
                                                                        width="100%" 
                                                                        height="100%" 
                                                                        style="border: none;">
                                                                    <!-- Fallback per PDF Embed -->
                                                                    <object data="<?= $singleDoc->download_url; ?>#toolbar=1&navpanes=1&scrollbar=1" 
                                                                            type="application/pdf" 
                                                                            width="100%" 
                                                                            height="100%">
                                                                        <embed src="<?= $singleDoc->download_url; ?>" 
                                                                               type="application/pdf" 
                                                                               width="100%" 
                                                                               height="100%">
                                                                            <p style="padding: 20px; text-align: center;">
                                                                                Ihr Browser unterstützt die PDF-Anzeige nicht.<br>
                                                                                <a href="<?= $singleDoc->download_url; ?>" target="_blank" style="color: #007cba;">
                                                                                    PDF in neuem Fenster öffnen
                                                                                </a>
                                                                            </p>
                                                                        </embed>
                                                                    </object>
                                                                </iframe>
                                                            </div>
                                                        </div>
                                                    <?php elseif (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                                                        <div id="img-viewer-<?= md5($singleDoc->download_url); ?>" class="img-viewer" style="display: none; padding: 20px; text-align: center; background: #f8f9fa;">
                                                            <img src="<?= $singleDoc->download_url; ?>" 
                                                                 alt="<?= $file_name; ?>" 
                                                                 style="max-width: 100%; height: auto; max-height: 600px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"
                                                                 onload="this.style.opacity=1" 
                                                                 style="opacity: 0; transition: opacity 0.3s;">
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <?php 
                                            endif;
                                        endforeach;
                                    endif;
                                endforeach;
                            ?>
                        </div>

                        <script>
                        function togglePdfViewer(viewerId) {
                            const viewer = document.getElementById(viewerId);
                            const isVisible = viewer.style.display !== 'none';
                            
                            // Alle anderen Viewer ausblenden
                            document.querySelectorAll('.pdf-viewer, .img-viewer').forEach(v => {
                                if (v.id !== viewerId) v.style.display = 'none';
                            });
                            
                            // Diesen Viewer umschalten
                            viewer.style.display = isVisible ? 'none' : 'block';
                            
                            // Zum Viewer scrollen, wenn er geöffnet wird
                            if (!isVisible) {
                                setTimeout(() => {
                                    viewer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                                }, 100);
                            }
                        }

                        function toggleImageViewer(viewerId) {
                            const viewer = document.getElementById(viewerId);
                            const isVisible = viewer.style.display !== 'none';
                            
                            // Alle anderen Viewer ausblenden
                            document.querySelectorAll('.pdf-viewer, .img-viewer').forEach(v => {
                                if (v.id !== viewerId) v.style.display = 'none';
                            });
                            
                            // Diesen Viewer umschalten
                            viewer.style.display = isVisible ? 'none' : 'block';
                            
                            // Zum Viewer scrollen, wenn er geöffnet wird
                            if (!isVisible) {
                                setTimeout(() => {
                                    viewer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                                }, 100);
                            }
                        }
                        </script>

                        <style>
                        .apimo-documents-section .document-card {
                            transition: box-shadow 0.3s ease;
                        }
                        
                        .apimo-documents-section .document-card:hover {
                            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                        }
                        
                        .doc-header button:hover {
                            opacity: 0.9;
                            transform: translateY(-1px);
                            transition: all 0.2s ease;
                        }
                        
                        .pdf-viewer, .img-viewer {
                            animation: slideDown 0.3s ease;
                        }
                        
                        @keyframes slideDown {
                            from {
                                opacity: 0;
                                transform: translateY(-10px);
                            }
                            to {
                                opacity: 1;
                                transform: translateY(0);
                            }
                        }
                        
                        /* Responsiv */
                        @media (max-width: 768px) {
                            .doc-header {
                                flex-direction: column !important;
                                gap: 15px;
                                text-align: center;
                            }
                            
                            .doc-header > div:last-child {
                                width: 100%;
                                justify-content: center;
                            }
                            
                            .pdf-viewer iframe,
                            .pdf-viewer object {
                                height: 500px !important;
                            }
                        }
                        </style>
                        <?php
                    endif;                          
                ?>
            </div>
            <?php 
        endif;
    endforeach;
endif;
?>

			</div>
			<aside class="apimo_contact_sidebar" aria-label="Kontaktformular">
				<div class="apimo_form_container" id="contact-form">

				<?php
					// Agent banner (first available agent/user data)
					$apimo_agent_user = null;
					if (!empty($metas['apimo_user_data'])) {
						foreach ($metas['apimo_user_data'] as $serialized_user) {
							$u = maybe_unserialize($serialized_user);
							if (!empty($u) && (isset($u->firstname) || isset($u->lastname) || isset($u->email) || isset($u->phone))) {
								$apimo_agent_user = $u;
								break;
							}
						}
					}
					$apimo_agent_name = '';
					if ($apimo_agent_user) {
						$first = isset($apimo_agent_user->firstname) ? trim((string)$apimo_agent_user->firstname) : '';
						$last  = isset($apimo_agent_user->lastname) ? trim((string)$apimo_agent_user->lastname) : '';
						$apimo_agent_name = trim($first . ' ' . $last);
					}
				?>

			<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors)) { ?>
				<div class="apimo_success_message" id="success">
					<?php echo 'Ihre Nachricht wurde erfolgreich gesendet!'; ?>
				</div>
			<?php } else { ?>
				<h2 class="apimo_form_title"><?php echo 'Kontaktformular'; ?></h2>
				<form class="apimo_form" method="POST" action="<?php echo esc_url($_SERVER['REQUEST_URI']) . '#success'; ?>">
					<input type="hidden" name="browser_lang" id="browser_lang" value="">

					<div class="apimo_form_row">
						<div class="apimo_form_column">
						<label for="lastName" class="apimo_label apimo_required">
							Nachname
							</label>
							<input 
								type="text" 
								id="lastName" 
								name="lastName" 
								class="apimo_input" 
								placeholder="Nachname eingeben" 
							required>
							<div class="apimo_error_message"><?php echo 'Dieses Feld ist erforderlich'; ?></div>
						</div>
						<div class="apimo_form_column">
						<label for="firstName" class="apimo_label apimo_required">
							Vorname
							</label>
							<input 
								type="text" 
								id="firstName" 
								name="firstName" 
								class="apimo_input" 
							placeholder="Vorname eingeben" 
							required>
						</div>
					</div>

					<div class="apimo_form_group">
					<label for="phone" class="apimo_label apimo_required">
						Telefon
						</label>
						<div class="apimo_phone_row">
							<div class="apimo_phone_prefix">
								<?php
								$apimo_phone_country_options = apimo_get_phone_country_options();
								$apimo_posted_phone_prefix = (string) ($_POST['phone_prefix'] ?? '');
								$apimo_guessed_country = apimo_guess_country_code();
								?>
								<select id="phone_prefix" name="phone_prefix" class="apimo_input" autocomplete="tel-country-code" required>
									<option value="">Vorwahl</option>
									<?php foreach ($apimo_phone_country_options as $apimo_phone_country_option) : ?>
										<?php
										$apimo_phone_option_value = $apimo_phone_country_option['dial'] . '|' . $apimo_phone_country_option['code'];
										$apimo_selected = '';
										if ($apimo_posted_phone_prefix !== '') {
											$apimo_selected = selected($apimo_posted_phone_prefix, $apimo_phone_option_value, false);
										} elseif ($apimo_guessed_country === $apimo_phone_country_option['code']) {
											$apimo_selected = 'selected="selected"';
										}
										?>
										<option value="<?php echo esc_attr($apimo_phone_option_value); ?>" title="<?php echo esc_attr($apimo_phone_country_option['name'] . ' (' . $apimo_phone_country_option['dial'] . ')'); ?>" <?php echo $apimo_selected; ?>>
											<?php echo esc_html($apimo_phone_country_option['dial']); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="apimo_phone_number">
								<input 
									type="tel" 
									id="phone" 
									name="phone" 
									class="apimo_input"  
									placeholder="Telefonnummer eingeben" 
									value="<?php echo isset($_POST['phone']) ? esc_attr($_POST['phone']) : ''; ?>"
									required>
							</div>
						</div>
						<div class="apimo_error_message"><?php echo 'Ungültiges Format'; ?></div>
					</div>

					<div class="apimo_form_group">
					<label for="email" class="apimo_label apimo_required">
						Email
						</label>
						<input 
							type="email" 
							id="email" 
							name="email" 
							class="apimo_input" 
						placeholder="E-Mail-Adresse eingeben" 
						required>
						<div class="apimo_error_message"><?php echo 'Ungültiges E-Mail-Format'; ?></div>
					</div>

					<div class="apimo_form_group">
					<label for="message" class="apimo_label apimo_required">
						Nachricht
						</label>
						<textarea 
							id="message" 
							name="message" 
							class="apimo_textarea" 
						placeholder="Stellen Sie Fragen, bitten Sie um einen Besichtigungstermin oder stellen Sie sich kurz vor." 
						required></textarea>
					</div>

					<div class="apimo_form_group">
						<input 
							type="hidden" 
							id="reference" 
							name="reference" 
							class="apimo_input apimo_input_disabled" 
							value="<?php echo esc_attr($metas['apimo_reference'][0]); ?>" 
							readonly 
							required>
					</div>

					<button type="submit" class="apimo_submit_button"><?php echo 'Senden'; ?></button>
				</form>

				<?php if ($apimo_agent_user) : ?>
				  <div class="apimo_agent_banner" style="margin-top:18px;">
					<div class="apimo_agent_row">
					  <img class="apimo_agent_avatar"
						   src="<?php echo isset($apimo_agent_user->picture) && !empty($apimo_agent_user->picture) ? esc_url($apimo_agent_user->picture) : esc_url(plugin_dir_url(dirname(__FILE__)) . 'assets/images/julie.png'); ?>"
						   alt="" />
					  <div class="apimo_agent_meta">
						<div class="apimo_agent_name">
						  <?php echo !empty($apimo_agent_name) ? esc_html($apimo_agent_name) : 'Makler'; ?>
						  <?php if (isset($apimo_agent_user->active) && $apimo_agent_user->active) : ?>
							<img class="apimo_img" style="width:14px;height:14px;vertical-align:middle;margin-left:6px;"
								 src="<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . 'assets/images/verify.png'); ?>" alt="" />
						  <?php endif; ?>
						</div>
						<div class="apimo_agent_role">
						  <?php echo isset($apimo_agent_user->role) && !empty($apimo_agent_user->role) ? esc_html($apimo_agent_user->role) : 'Immobilienmakler'; ?>
						</div>
					  </div>
					</div>

					<?php
						// Static agent profile pages (created manually)
						$apimo_agent_profiles = [
							'fabian gruessner'  => 'https://casainsicilia.de/immobilienmakler/fabian-gruessner/',
							'gaetano varcasia'  => 'https://casainsicilia.de/immobilienmakler/gaetano-varcasia/',
							'romolo gruessner'  => 'https://casainsicilia.de/immobilienmakler/romolo-gruessner/',
							'thomas gruessner'  => 'https://casainsicilia.de/immobilienmakler/thomas-gruessner/',
							'valerio gruessner' => 'https://casainsicilia.de/immobilienmakler/valerio-gruessner/',
						];
						$apimo_agent_profile_url = '';
						if (!empty($apimo_agent_name)) {
							$key = strtolower(trim(preg_replace('/\s+/', ' ', (string) $apimo_agent_name)));
							if (!empty($apimo_agent_profiles[$key])) {
								$apimo_agent_profile_url = $apimo_agent_profiles[$key];
							}
						}
					?>
					<div class="apimo_agent_actions">
					  <?php if (isset($apimo_agent_user->phone) && !empty($apimo_agent_user->phone)) : ?>
						<a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', (string)$apimo_agent_user->phone)); ?>">
						  <?php echo 'Anrufen'; ?>
						</a>
					  <?php endif; ?>

					  <?php if (!empty($apimo_agent_profile_url)) : ?>
						<a href="<?php echo esc_url($apimo_agent_profile_url); ?>" target="_blank" rel="noopener">
						  <?php _e('Profil ansehen', 'apimo'); ?>
						</a>
					  <?php endif; ?>
					</div>
				  </div>
				<?php endif; ?>

				<script>
				(function(){
					var f = document.querySelector('form.apimo_form');
					if(!f) return;
					var i = document.getElementById('browser_lang');
					if(!i){
						i = document.createElement('input');
						i.type = 'hidden';
						i.name = 'browser_lang';
						i.id = 'browser_lang';
						f.appendChild(i);
					}
					function setLang(){
						var lang = '';
						if (navigator.languages && navigator.languages.length) lang = navigator.languages[0];
						else lang = navigator.language || navigator.userLanguage || '';
						lang = (lang || '').toString().trim().toLowerCase();
						// Keep first 2 letters (e.g., it-IT -> it)
						if (lang.length >= 2) lang = lang.substring(0,2);
						i.value = lang;
					}
					setLang();
					f.addEventListener('submit', setLang);
				})();
				</script>

			<?php } ?>
		</div>



		<?php

			function is_using_recaptcha() {
				// Check if reCAPTCHA script is enqueued
				if (wp_script_is('google-recaptcha', 'enqueued')) {
					die('true');
				}

				// Alternatively, check if the reCAPTCHA field is present in the page content
				if (strpos(ob_get_contents(), 'g-recaptcha') !== false) {
					die('true');
				}

				die('false');

			}
			

			$apimo_api_keys = get_option('apimo_key_data');
			
			$company_id = trim($apimo_api_keys[0]['company_id']);
			$key = trim($apimo_api_keys[0]['key']);
			$credentials = base64_encode($company_id . ':' . $key); // Add the colon separator
			
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				/**
				 * ------------------------------------
				 *  HOTFIX: Detect the correct agency
				 * ------------------------------------
				 */
				$dynamic_agency_id = null;

				// CASE 1: Lead sent from a property page (contains property reference)
				if (!empty($_POST['reference'])) {

					$property_ref = sanitize_text_field($_POST['reference']);

					// Fetch the property to get its agency ID
					$ch_property = curl_init("https://api.apimo.pro/properties/{$property_ref}");
					curl_setopt_array($ch_property, [
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_HTTPHEADER => [
							'Authorization: Basic ' . $credentials,
							'Content-Type: application/json'
						]
					]);

					$property_response = curl_exec($ch_property);
					curl_close($ch_property);

					$property_json = json_decode($property_response, true);

					// If the property has an agency → use it
					if (!empty($property_json['agency']['id'])) {
						$dynamic_agency_id = $property_json['agency']['id'];
					}
				}

				// CASE 2: No property reference → use first agency saved
				if (!$dynamic_agency_id) {
					$dynamic_agency_id = $apimo_api_keys[0]['agency_id'];
				}

				// Build correct API config
				$apimoConfig = [
					'apiUrl' => 'https://api.apimo.pro/agencies',
					'agencyId' => $dynamic_agency_id,
					'credentials' => $credentials
				];

				/**
				 * ------------------------------------
				 *  Validate form
				 * ------------------------------------
				 */
				$errors = [];

				// All fields required
				if (empty(trim((string)($_POST['lastName'] ?? '')))) {
					$errors[] = 'Nachname ist erforderlich';
				}
				if (empty(trim((string)($_POST['firstName'] ?? '')))) {
					$errors[] = 'Vorname ist erforderlich';
				}
				if (empty(trim((string)($_POST['email'] ?? '')))) {
					$errors[] = 'E-Mail ist erforderlich';
				} elseif (!filter_var((string)$_POST['email'], FILTER_VALIDATE_EMAIL)) {
					$errors[] = 'Ungültiges E-Mail-Format';
				}
				if (empty(trim((string)($_POST['phone_prefix'] ?? '')))) {
					$errors[] = 'Internationale Vorwahl ist erforderlich';
				}
				if (empty(trim((string)($_POST['phone'] ?? '')))) {
					$errors[] = 'Telefon ist erforderlich';
				} else {
					// Allow international formats; validate by digit count
					$digits = preg_replace('/\D+/', '', (string)($_POST['phone_prefix'] ?? '') . ' ' . ($_POST['phone'] ?? ''));
					if (strlen($digits) < 6) {
						$errors[] = 'Ungültiges Telefonnummernformat';
					}
				}
				if (empty(trim((string)($_POST['message'] ?? '')))) {
					$errors[] = 'Nachricht ist erforderlich';
				}

				/**
				 * ------------------------------------
				 *  Submit to Apimo API
				 * ------------------------------------
				 */
				if (empty($errors)) {

					// Prepare data
				$lead_country  = apimo_guess_country_code();
				$lead_language = apimo_guess_language();

					$phone_prefix = preg_replace('/[^\d\+]/', '', (string)($_POST['phone_prefix'] ?? ''));
					$phone_number = trim((string)($_POST['phone'] ?? ''));
					$full_phone = trim($phone_prefix . ' ' . $phone_number);

					$leadData = [
						'reference' => uniqid('WP-'),
						'date' => date('Y-m-d H:i:s'),
						'step' => '1',
						'type' => '1',
						'language' => $lead_language,
						'country' => $lead_country,
						'currency' => 'EUR',
						'referral' => '1',

						// Form fields
						'lastname' => strip_tags($_POST['lastName']),
						'firstname' => strip_tags($_POST['firstName'] ?? ''),
						'email' => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
						'phone' => strip_tags($full_phone),
						'message' => strip_tags($_POST['message'] ?? ''),
						'property_reference' => strip_tags($_POST['reference'] ?? '')
					];

					// Send lead
					$ch = curl_init(rtrim($apimoConfig['apiUrl'], '/') . '/' . trim($apimoConfig['agencyId']) . '/leads');

					curl_setopt_array($ch, [
						CURLOPT_POST => true,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_HTTPHEADER => [
							'Authorization: Basic ' . $apimoConfig['credentials'],
							'Content-Type: application/json'
						],
						CURLOPT_POSTFIELDS => json_encode($leadData)
					]);

					$response = curl_exec($ch);
					$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

					if (curl_errno($ch)) {
						echo '<div class="apimo_error">API connection error: ' . curl_error($ch) . '</div>';
					} elseif ($httpCode !== 200) {
						echo '<div class="apimo_error">Apimo API error: ' . $response . '</div>';
					}

					curl_close($ch);

				} else {

					echo '<div class="apimo_error">';
					foreach ($errors as $error) {
						echo htmlspecialchars($error) . '<br>';
					}
					echo '</div>';

				}
			}

		?>


	
			</aside>

			<a href="#" class="mobile-contact-bar" data-target="contact-form">
				<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
					<path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/>
				</svg>
				<span style="color:white;">Mehr Infos anfragen</span>
			</a>

			<script>
			document.addEventListener('DOMContentLoaded', function () {
				const contactBar = document.querySelector('.mobile-contact-bar');
				const contactForm = document.querySelector('#contact-form');
				if (!contactBar || !contactForm) return;

				const observer = new IntersectionObserver(function (entries) {
					entries.forEach(entry => {
						if (entry.isIntersecting) {
							contactBar.style.opacity = '0';
							contactBar.style.pointerEvents = 'none';
							contactBar.style.transform = 'translateY(80px)';
						} else {
							contactBar.style.opacity = '1';
							contactBar.style.pointerEvents = 'auto';
							contactBar.style.transform = 'translateY(0)';
						}
					});
				}, { threshold: 0.25 });

				observer.observe(contactForm);
			});
			</script>



		</div>
			</div>
		</div>

		<!-- Form -->
		<?php
			// Display response message if exists
			if (isset($_SESSION['form_message'])) {
				echo '<div class="apimo_message">' . $_SESSION['form_message'] . '</div>';
				unset($_SESSION['form_message']);
			}
		
			$form_configuration = get_option('form_configuration');

			if (!$form_configuration) {
				$form_configuration = array(
					'last_name' => array(
						'label' => 'Nachname',
						'placeholder' => 'Nachname eingeben',
						'required' => 1
					),
					'first_name' => array(
						'label' => 'Vorname',
						'placeholder' => 'Vorname eingeben',
						'required' => 1
					),
					'phone_prefix' => array(
						'label' => 'Internationale Vorwahl',
						'placeholder' => 'Vorwahl wählen',
						'required' => 1
					),
					'phone' => array(
						'label' => 'Telefon',
						'placeholder' => 'Telefonnummer eingeben',
						'required' => 1
					),
					'email' => array(
						'label' => 'E-Mail',
						'placeholder' => 'E-Mail-Adresse eingeben',
						'required' => 1
					),
					'message' => array(
						'label' => 'Nachricht',
						'placeholder' => 'Stellen Sie Fragen, bitten Sie um einen Besichtigungstermin oder stellen Sie sich kurz vor.',
						'required' => 0
					)
				);
			}

		// Force required fields (sidebar form)
		foreach (['last_name','first_name','phone','email','message'] as $rk) {
			if (!isset($form_configuration[$rk])) {
				$form_configuration[$rk] = [];
			}
			$form_configuration[$rk]['required'] = 1;
		}
		

		?>

		

		<!-- Contact form moved to sidebar near description -->

</main>



</div>
<script>
	function toggleVisibility(sectionSelector, itemSelector, buttonId, threshold = 3, initialDisplay = 'flex', startExpanded = false) {
		const items = document.querySelectorAll(`${sectionSelector} ${itemSelector}`);
		const button = document.getElementById(buttonId);

		// If the button doesn't exist (section removed), do nothing
		if (!button) return;

		// Helper to update state + UI without destroying inner HTML (keeps arrow icon)
		function setExpanded(expanded) {
			for (let i = threshold; i < items.length; i++) {
				items[i].style.display = expanded ? initialDisplay : 'none';
			}
			button.dataset.expanded = expanded ? '1' : '0';

			// Update the button label inside <p> if present, otherwise fallback to textContent
			const labelEl = button.querySelector('p');
			const label = expanded ? 'Weniger anzeigen' : 'Mehr anzeigen';
			if (labelEl) {
				labelEl.textContent = label;
			} else {
				button.textContent = label;
			}
		}

		// Check if the number of items exceeds the threshold
		if (items.length > threshold) {
			// Initialize (force either expanded or collapsed on load)
			setExpanded(!!startExpanded);

			button.addEventListener('click', function() {
				const expanded = this.dataset.expanded === '1';
				setExpanded(!expanded);
			});
		} else {
			// Hide the button if there are not enough items
			button.style.display = 'none';
		}
	}

	// Start expanded on page load (so "Details" is already open)
	toggleVisibility('.apimo_services', '.apimo_item_prestations', 'view_more_apimo_services', 3, 'flex', true);
	toggleVisibility('.apimo_general_information', '.apimo_property', 'view_more_general_informations', 3, 'flex', true);
	toggleVisibility('.apimo_regulations', '.apimo_property', 'view_more_apimo_regulations', 3, 'flex', true);
</script>


<?php 

//recaptcha : 
function get_apimo_recaptcha_config() {
    $recaptcha_info = get_option('apimo_recaptcha_info', array());
    
    if (!empty($recaptcha_info['site_key']) && 
        !empty($recaptcha_info['secret_key']) && 
        !empty($recaptcha_info['integration_recaptcha']) && 
        $recaptcha_info['integration_recaptcha'] == 1) {
        return $recaptcha_info;
    }
    return false;
}

function apimo_add_recaptcha_footer() {
    $recaptcha_config = get_apimo_recaptcha_config();
    if ($recaptcha_config && !is_admin()) {
        ?>
        <script src="https://www.google.com/recaptcha/api.js?render=<?php echo esc_attr($recaptcha_config['site_key']); ?>"></script>
        
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('<?php echo esc_attr($recaptcha_config['site_key']); ?>', {action: 'submit'})
                .then(function(token) {
                    if (!document.getElementById('g-recaptcha-response')) {
                        var tokenInput = document.createElement('input');
                        tokenInput.type = 'hidden';
                        tokenInput.id = 'g-recaptcha-response';
                        tokenInput.name = 'g-recaptcha-response';
                        tokenInput.value = token;
                        document.body.appendChild(tokenInput);
                    }
                });
            });
        </script>
        <?php
    }
}
add_action('wp_footer', 'apimo_add_recaptcha_footer');
?>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const contactBar = document.querySelector('.mobile-contact-bar');
    const contactForm = document.querySelector('#contact-form');

    if (!contactBar || !contactForm) return;

    contactBar.addEventListener('click', function (e) {
        e.preventDefault();
        const offset = 220;
        const elementPosition = contactForm.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - offset;
        window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
    });

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                contactBar.style.opacity = '0';
                contactBar.style.pointerEvents = 'none';
            } else {
                contactBar.style.opacity = '1';
                contactBar.style.pointerEvents = 'auto';
            }
        });
    }, { threshold: 0.25 });

    observer.observe(contactForm);
});
</script>

<style>
  h2 {
    font-size: 28px;
    line-height: 1.3em;
    margin-bottom: 15px;
    font-family: 'Poppins', Helvetica, Arial, sans-serif;
    color: #0B3C5D;
}
																														   
 .apimo_title_h2{
    font-size: 28px;
    line-height: 1.3em;
    margin-bottom: 15px;
    font-family: 'Poppins', Helvetica, Arial, sans-serif;
    color: #0B3C5D;
}
																														   
.apimo_title, .apimo_price {
    font-size: 21px;
    font-weight: bold;
    font-family: 'Poppins', Helvetica, Arial, sans-serif;
    color: #0B3C5D;
}
																														   
																														   .apimo_section_compagne {
    margin-top: 48px;
    font-size: 16px;
    font-family: 'Montserrat';
    color: #0B3C5D;
}
  a {
    color: #ff9900;
}
</style>
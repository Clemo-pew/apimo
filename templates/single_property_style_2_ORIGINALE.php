<?php







global $apimo_dir, $apimo_url;

$property_reglementation = [
	[
		"id" => 1,
		"culture" => "en_GB",
		"name" => "Energy - Conventional consumption",
		"value" => "kWh\/m².year"
	],
	[
		"id" => 2,
		"culture" => "en_GB",
		"name" => "Energy - Emissions estimate",
		"value" => "kg CO2\/m².year"
	],
	[
		"id" => 3,
		"culture" => "en_GB",
		"name" => "« Carrez » act",
		"value" => "m²"
	],
	[
		"id" => 4,
		"culture" => "en_GB",
		"name" => "ERP"
	],
	[
		"id" => 5,
		"culture" => "en_GB",
		"name" => "Termites"
	],
	[
		"id" => 6,
		"culture" => "en_GB",
		"name" => "Asbestos"
	],
	[
		"id" => 7,
		"culture" => "en_GB",
		"name" => "Gas"
	],
	[
		"id" => 8,
		"culture" => "en_GB",
		"name" => "Lead"
	],
	[
		"id" => 9,
		"culture" => "en_GB",
		"name" => "Electricity"
	],
	[
		"id" => 10,
		"culture" => "en_GB",
		"name" => "Boutin act",
		"value" => "m²"
	],
	[
		"id" => 11,
		"culture" => "en_GB",
		"name" => "Sanitation"
	],
	[
		"id" => 12,
		"culture" => "en_GB",
		"name" => "EPI (Non renewable)",
		"value" => "kWh\/m².year"
	],
	[
		"id" => 13,
		"culture" => "en_GB",
		"name" => "APE"
	],
	[
		"id" => 14,
		"culture" => "en_GB",
		"name" => "Request for nomination of an ad hoc agent"
	],
	[
		"id" => 15,
		"culture" => "en_GB",
		"name" => "Request for nomination of a temporary administrator"
	],
	[
		"id" => 16,
		"culture" => "en_GB",
		"name" => "Request for expert nomination"
	],
	[
		"id" => 17,
		"culture" => "en_GB",
		"name" => "Fire safety regulations "
	],
	[
		"id" => 18,
		"culture" => "en_GB",
		"name" => "Accessibility standards for people with disabilities "
	],
	[
		"id" => 19,
		"culture" => "en_GB",
		"name" => "Sanitary authorization "
	],
	[
		"id" => 20,
		"culture" => "en_GB",
		"name" => "Energy consumption",
		"value" => "kWh\/m² year"
	],
	[
		"id" => 21,
		"culture" => "en_GB",
		"name" => "Energy consumption"
	],
	[
		"id" => 22,
		"culture" => "en_GB",
		"name" => "Land value tax",
		"value" => "€ \/ year"
	],
	[
		"id" => 23,
		"culture" => "en_GB",
		"name" => "Housing tax",
		"value" => "€ \/ year"
	],
	[
		"id" => 24,
		"culture" => "en_GB",
		"name" => "Land charges",
		"value" => "CHF \/ an"
	],
	[
		"id" => 25,
		"culture" => "en_GB",
		"name" => "Land value tax",
		"value" => "€ \/ year"
	],
	[
		"id" => 26,
		"culture" => "en_GB",
		"name" => "Land value tax",
		"value" => "€ \/ year"
	],
	[
		"id" => 27,
		"culture" => "en_GB",
		"name" => "Residents only"
	],
	[
		"id" => 28,
		"culture" => "en_GB",
		"name" => "Property tax (IPTU)",
		"value" => "R$ \/ year"
	],
	[
		"id" => 29,
		"culture" => "en_GB",
		"name" => "Taxe Locale d’Equipement",
		"value" => "€"
	],
	[
		"id" => 30,
		"culture" => "en_GB",
		"name" => "Minergie"
	],
	[
		"id" => 31,
		"culture" => "en_GB",
		"name" => "Volume",
		"value" => "m³"
	],
	[
		"id" => 32,
		"culture" => "en_GB",
		"name" => "Useful surface",
		"value" => "m²"
	],
	[
		"id" => 33,
		"culture" => "en_GB",
		"name" => "Co-Ownership property"
	],
	[
		"id" => 34,
		"culture" => "en_GB",
		"name" => "Communal tax rate",
		"value" => "%"
	],
	[
		"id" => 35,
		"culture" => "en_GB",
		"name" => "Land register extract number"
	],
	[
		"id" => 36,
		"culture" => "en_GB",
		"name" => "Droit de superficie"
	],
	[
		"id" => 37,
		"culture" => "en_GB",
		"name" => "Millièmes"
	],
	[
		"id" => 38,
		"culture" => "en_GB",
		"name" => "Housing tax",
		"value" => "€ \/ year"
	],
	[
		"id" => 39,
		"culture" => "en_GB",
		"name" => "PPE budget",
		"value" => "CHF"
	],
	[
		"id" => 40,
		"culture" => "en_GB",
		"name" => "Current renovation fund",
		"value" => "CHF"
	],
	[
		"id" => 41,
		"culture" => "en_GB",
		"name" => "Plot ratio"
	],
	[
		"id" => 42,
		"culture" => "en_GB",
		"name" => "Occupancy ratio",
		"value" => "%"
	],
	[
		"id" => 43,
		"culture" => "en_GB",
		"name" => "Ground footprint coefficient"
	],
	[
		"id" => 44,
		"culture" => "en_GB",
		"name" => "Floor space coefficient"
	],
	[
		"id" => 45,
		"culture" => "en_GB",
		"name" => "Priority period CCH L443-11"
	],
	[
		"id" => 47,
		"culture" => "en_GB",
		"name" => "Plot division \/ Demarcation"
	],
	[
		"id" => 48,
		"culture" => "en_GB",
		"name" => "Board of directors \/ supervisory deliberation"
	],
	[
		"id" => 49,
		"culture" => "en_GB",
		"name" => "Certificate of compliance"
	],
	[
		"id" => 50,
		"culture" => "en_GB",
		"name" => "Energy class"
	],
	[
		"id" => 51,
		"culture" => "en_GB",
		"name" => "Thermal insulation class"
	],
	[
		"id" => 52,
		"culture" => "en_GB",
		"name" => "Greenhouse Gas"
	],
	[
		"id" => 53,
		"culture" => "en_GB",
		"name" => "Energy passport"
	],
	[
		"id" => 54,
		"culture" => "en_GB",
		"name" => "Energy certificate"
	],
	[
		"id" => 55,
		"culture" => "en_GB",
		"name" => "Energy consumption \/ Final energy requirement",
		"value" => "kWh\/(m²·a)"
	],
	[
		"id" => 56,
		"culture" => "en_GB",
		"name" => "Energy efficiency class"
	],
	[
		"id" => 57,
		"culture" => "en_GB",
		"name" => "Year of construction according to certificate"
	],
	[
		"id" => 58,
		"culture" => "en_GB",
		"name" => "Energy consumption => Hot water included"
	],
	[
		"id" => 59,
		"culture" => "en_GB",
		"name" => "Specific primary energy consumption",
		"value" => "kWh\/m²·year"
	],
	[
		"id" => 60,
		"culture" => "en_GB",
		"name" => "PEB unique code"
	],
	[
		"id" => 61,
		"culture" => "en_GB",
		"name" => "K level (Thermal Insulation)"
	],
	[
		"id" => 62,
		"culture" => "en_GB",
		"name" => "Ew level (Energy performance)"
	],
	[
		"id" => 63,
		"culture" => "en_GB",
		"name" => "CO2 emission",
		"value" => "kg CO2\/m².year"
	],
	[
		"id" => 64,
		"culture" => "en_GB",
		"name" => "Flood risks"
	],
	[
		"id" => 65,
		"culture" => "en_GB",
		"name" => "Certificate=> Oil tank conformity"
	],
	[
		"id" => 66,
		"culture" => "en_GB",
		"name" => "Certificate => Electric installation conformity"
	],
	[
		"id" => 67,
		"culture" => "en_GB",
		"name" => "« As Built » certificate"
	],
	[
		"id" => 68,
		"culture" => "en_GB",
		"name" => "Total consumption of primary energy",
		"value" => "kWh\/an"
	],
	[
		"id" => 69,
		"culture" => "en_GB",
		"name" => "Registration number"
	],
	[
		"id" => 70,
		"culture" => "en_GB",
		"name" => "Cadastral income",
		"value" => "€"
	],
	[
		"id" => 71,
		"culture" => "en_GB",
		"name" => "Planning permit obtained"
	],
	[
		"id" => 72,
		"culture" => "en_GB",
		"name" => "Subdivision authorization"
	],
	[
		"id" => 73,
		"culture" => "en_GB",
		"name" => "Pre-emptive right possible"
	],
	[
		"id" => 74,
		"culture" => "en_GB",
		"name" => "Citation for urbanistic infraction"
	],
	[
		"id" => 75,
		"culture" => "en_GB",
		"name" => "Last use designation"
	],
	[
		"id" => 76,
		"culture" => "en_GB",
		"name" => "Cadastral annuity",
		"value" => "€"
	],
	[
		"id" => 77,
		"culture" => "en_GB",
		"name" => "Energy certification number"
	],
	[
		"id" => 78,
		"culture" => "en_GB",
		"name" => "VAT applicable"
	],
	[
		"id" => 79,
		"culture" => "en_GB",
		"name" => "Energy certification"
	],
	[
		"id" => 80,
		"culture" => "en_GB",
		"name" => "Emissions estimate",
		"value" => "kg éqCO2\/m².year"
	],
	[
		"id" => 81,
		"culture" => "en_GB",
		"name" => "Emissions estimate"
	],
	[
		"id" => 82,
		"culture" => "en_GB",
		"name" => "Possibility of connecting => Water \/ Gas \/ Electricity"
	],
	[
		"id" => 83,
		"culture" => "en_GB",
		"name" => "Laudêmio",
		"value" => "BRL"
	],
	[
		"id" => 84,
		"culture" => "en_GB",
		"name" => "Real estate program"
	],
	[
		"id" => 85,
		"culture" => "en_GB",
		"name" => "Accessible to foreigners"
	],
	[
		"id" => 86,
		"culture" => "en_GB",
		"name" => "Building type"
	],
	[
		"id" => 87,
		"culture" => "en_GB",
		"name" => "Primärenergiebedarf",
		"value" => "kWh\/(m².a)"
	],
	[
		"id" => 88,
		"culture" => "en_GB",
		"name" => "Flat rate for charges"
	],
	[
		"id" => 89,
		"culture" => "en_GB",
		"name" => "Energy Efficiency Rating (Current)"
	],
	[
		"id" => 90,
		"culture" => "en_GB",
		"name" => "Energy Efficiency Rating (Potential)"
	],
	[
		"id" => 91,
		"culture" => "en_GB",
		"name" => "Environmental Impact Rating (Current)"
	],
	[
		"id" => 92,
		"culture" => "en_GB",
		"name" => "Environmental Impact Rating (Potential)"
	],
	[
		"id" => 93,
		"culture" => "en_GB",
		"name" => "Tenure type"
	],
	[
		"id" => 94,
		"culture" => "en_GB",
		"name" => "Property tenure"
	],
	[
		"id" => 95,
		"culture" => "en_GB",
		"name" => "Rental value",
		"value" => "CHF"
	],
	[
		"id" => 96,
		"culture" => "en_GB",
		"name" => "Tax value",
		"value" => "CHF"
	],
	[
		"id" => 97,
		"culture" => "en_GB",
		"name" => "Insurance value",
		"value" => "CHF"
	],
	[
		"id" => 98,
		"culture" => "en_GB",
		"name" => "Building zone"
	],
	[
		"id" => 99,
		"culture" => "en_GB",
		"name" => "Stratum"
	],
	[
		"id" => 100,
		"culture" => "en_GB",
		"name" => "Rental reference index"
	],
	[
		"id" => 101,
		"culture" => "en_GB",
		"name" => "Last rental price",
		"value" => "€"
	],
	[
		"id" => 102,
		"culture" => "en_GB",
		"name" => "Energy - Conventional consumption",
		"value" => "kWh\/m².year"
	],
	[
		"id" => 103,
		"culture" => "en_GB",
		"name" => "Building envelope efficiency"
	],
	[
		"id" => 104,
		"culture" => "en_GB",
		"name" => "Overall energy efficiency"
	],
	[
		"id" => 105,
		"culture" => "en_GB",
		"name" => "Dry rot diagnosis"
	],
	[
		"id" => 106,
		"culture" => "en_GB",
		"name" => "Additional rent",
		"value" => "€"
	],
	[
		"id" => 107,
		"culture" => "en_GB",
		"name" => "Indexed cadastral income",
		"value" => "€"
	],
	[
		"id" => 108,
		"culture" => "en_GB",
		"name" => "Property tax",
		"value" => "€"
	],
	[
		"id" => 109,
		"culture" => "en_GB",
		"name" => "EPI (Renewable)",
		"value" => "kWh\/m².year"
	],
	[
		"id" => 110,
		"culture" => "en_GB",
		"name" => "Emission class"
	],
	[
		"id" => 111,
		"culture" => "en_GB",
		"name" => "Heating costs",
		"value" => "€"
	],
	[
		"id" => 112,
		"culture" => "en_GB",
		"name" => "Performance level (summer season)"
	],
	[
		"id" => 113,
		"culture" => "en_GB",
		"name" => "Performance level (winter season)"
	],
	[
		"id" => 114,
		"culture" => "en_GB",
		"name" => "Cadastral data - Section"
	],
	[
		"id" => 115,
		"culture" => "en_GB",
		"name" => "Cadastral data - Sheet"
	],
	[
		"id" => 116,
		"culture" => "en_GB",
		"name" => "Cadastral data - Parcel"
	],
	[
		"id" => 117,
		"culture" => "en_GB",
		"name" => "Cadastral data - Subparcel"
	],
	[
		"id" => 118,
		"culture" => "en_GB",
		"name" => "Cadastral data - Sub"
	],
	[
		"id" => 119,
		"culture" => "en_GB",
		"name" => "Cadastral data - Sub 2"
	],
	[
		"id" => 120,
		"culture" => "en_GB",
		"name" => "Energy - Low estimated annual expenditure for standard use",
		"value" => "€ \/ year"
	],
	[
		"id" => 121,
		"culture" => "en_GB",
		"name" => "Energy - High estimated annual expenditure for standard use",
		"value" => "€ \/ year"
	],
	[
		"id" => 122,
		"culture" => "en_GB",
		"name" => "Energy - Energy Price Reference Year"
	],
	[
		"id" => 123,
		"culture" => "en_GB",
		"name" => "Licença de habitação - Número"
	],
	[
		"id" => 124,
		"culture" => "en_GB",
		"name" => "Licença de habitação - Emitida em"
	],
	[
		"id" => 125,
		"culture" => "en_GB",
		"name" => "Taxa de IMI",
		"value" => "€"
	],
	[
		"id" => 127,
		"culture" => "en_GB",
		"name" => "Regime de IVA"
	],
	[
		"id" => 128,
		"culture" => "en_GB",
		"name" => "Escritura - Número"
	],
	[
		"id" => 130,
		"culture" => "en_GB",
		"name" => "Licença de construção - Número"
	],
	[
		"id" => 131,
		"culture" => "en_GB",
		"name" => "Licença de construção - Emitida em"
	],
	[
		"id" => 132,
		"culture" => "en_GB",
		"name" => "Tenant charges conditions"
	],
	[
		"id" => 133,
		"culture" => "en_GB",
		"name" => "Land value tax",
		"value" => "$ \/ year"
	],
	[
		"id" => 134,
		"culture" => "en_GB",
		"name" => "Council Tax Band"
	],
	[
		"id" => 135,
		"culture" => "en_GB",
		"name" => "Maximum reference rent (base rent not to be exceeded)",
		"value" => "€"
	],
	[
		"id" => 136,
		"culture" => "en_GB",
		"name" => "Contratto di affitto"
	],
	[
		"id" => 137,
		"culture" => "en_GB",
		"name" => "Cadastral category"
	],
	[
		"id" => 138,
		"culture" => "en_GB",
		"name" => "Household waste collection tax",
		"value" => "€ \/ year"
	],
	[
		"id" => 139,
		"culture" => "en_GB",
		"name" => "Flood risks P-score"
	],
	[
		"id" => 140,
		"culture" => "en_GB",
		"name" => "Flood risks G-score"
	],
	[
		"id" => 141,
		"culture" => "en_GB",
		"name" => "Connectivity - Building connection"
	],
	[
		"id" => 142,
		"culture" => "en_GB",
		"name" => "Connectivity - Vertical Wiring"
	],
	[
		"id" => 143,
		"culture" => "en_GB",
		"name" => "Asbestos certificate"
	],
	[
		"id" => 144,
		"culture" => "en_GB",
		"name" => "Building with main use other than residential"
	],
	[
		"id" => 145,
		"culture" => "en_GB",
		"name" => "Énergie - Consommation finale",
		"value" => "kWhEF\/m².an"
	],
	[
		"id" => 146,
		"culture" => "en_GB",
		"name" => "Energy-efficient class"
	],
	[
		"id" => 147,
		"culture" => "en_GB",
		"name" => "Energy - Ademe Reference"
	],
	[
		"id" => 148,
		"culture" => "en_GB",
		"name" => "Certificate of conformity (rental)"
	],
	[
		"id" => 149,
		"culture" => "en_GB",
		"name" => "Licença de Alojamento Local",
		"value" => "\/AL"
	],
	[
		"id" => 150,
		"culture" => "en_GB",
		"name" => "Ground rent",
		"value" => "£\/year"
	],
	[
		"id" => 151,
		"culture" => "en_GB",
		"name" => "Energy audit"
	],
	[
		"id" => 152,
		"culture" => "en_GB",
		"name" => "Tax identifier of the property"
	],
	[
		"id" => 153,
		"culture" => "en_GB",
		"name" => "Land price excluding taxes",
		"value" => "€"
	],
	[
		"id" => 154,
		"culture" => "en_GB",
		"name" => "Taxes related to land",
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
					echo '<a data-fslightbox="gallery" href="' . esc_url($src) . '" class="apimo_view_all_images">
					<img width="20" src="https://icon-library.com/images/photo-gallery-icon/photo-gallery-icon-13.jpg" alt="">See the photos
				</a>';
				} else {
					// If no additional images, hide the "View all images" button
					echo '<style>.apimo_view_all_images {display: none;}</style>';
				}
				?>
			</div>
		</section>

		<section class="apimo_section_compagne">
			<div class="apimo_info_compagne">
				<h1 class="apimo_title"><?php echo get_the_title(); ?></h1>
				<?php

				?>
				<p class="apimo_price" style="color:<?php echo $primary_color; ?>">
					<?php
					if ($metas['apimo_price_hide'][0]) {
						_e('Private negotiation', 'apimo');
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
						<?php echo esc_html($metas['apimo_rooms'][0] ?? 0); ?> <?php _e('Rooms', 'apimo'); ?>
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
						<?php echo esc_html($metas['apimo_bathrooms'][0] ?? 0); ?> <?php _e('Bathroom', 'apimo'); ?>
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
						<p><?php echo esc_html($flor); ?></p>
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


			

		</section>
		<div class="apimo_line"></div>
		<section>
			<h2 class="apimo_title_h2"><?php _e('Details', 'apimo'); ?></h2>
			<div class="apimo_property_list apimo_general_information">
				<?php if ($apimo_category) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php _e('Category', 'apimo'); ?>:</dt>
						<dd class="apimo_property_value"><?php _e($apimo_category, 'apimo'); ?></dd>
					</dl>
				<?php endif; ?>

				<?php if ($subtype && $type) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php _e('Type', 'apimo'); ?>:</dt>
						<dd class="apimo_property_value"><?php _e(esc_html($type), 'apimo'); ?> / <?php _e(esc_html($subtype), 'apimo'); ?></dd>
					</dl>
				<?php endif; ?>

				<?php if ($construction_years) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php _e('Construction Year', 'apimo'); ?>:</dt>
						<dd class="apimo_property_value"><?php _e(esc_html($construction_years), 'apimo'); ?></dd>
					</dl>
				<?php endif; ?>

				<?php if ($condition) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php _e('Condition', 'apimo'); ?>:</dt>
						<dd class="apimo_property_value"><?php _e(esc_html($condition), 'apimo'); ?></dd>
					</dl>
				<?php endif; ?>

				<?php if ($availability) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php _e('Availability', 'apimo'); ?>:</dt>
						<dd class="apimo_property_value"><?php _e(esc_html($availability), 'apimo'); ?></dd>
					</dl>
				<?php endif; ?>

				<?php if ($property_standing) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php _e('Property Standing', 'apimo'); ?>:</dt>
						<dd class="apimo_property_value"><?php _e(esc_html($property_standing), 'apimo'); ?></dd>
					</dl>
				<?php endif; ?>

				<?php
				if (isset($metas['apimo_area_display_filter'][0]) && $metas['apimo_area_display_filter'][0]) :
					$area = esc_html($metas['apimo_area_display_filter'][0]);
					$unit = isset($metas['apimo_area_unit'][0]) && isset($UNIT_AREA[$metas['apimo_area_unit'][0]]) ? esc_html($UNIT_AREA[$metas['apimo_area_unit'][0]]) : '';
				?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php _e('Areas', 'apimo'); ?>:</dt>
						<dd class="apimo_property_value"><?php echo $area . ' ' . $unit; ?></dd>
					</dl>
				<?php endif; ?>

				<?php if ($flor) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php _e('Floor', 'apimo'); ?>:</dt>
						<dd class="apimo_property_value"><?php _e(esc_html($flor), 'apimo'); ?></dd>
					</dl>
				<?php endif; ?>

				<!-- Continuing from Price, Rooms, and Bathrooms... -->

				<?php if (isset($metas['apimo_price_hide'][0]) && !$metas['apimo_price_hide'][0]) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php _e('Price', 'apimo'); ?>:</dt>
						<dd class="apimo_property_value">
							<?php echo ($metas['apimo_price'][0]) ? esc_html(apimo_currency_format($metas['apimo_price'][0])) : _e('Not specified', 'apimo'); ?>
						</dd>
					</dl>
				<?php endif; ?>

				<?php if (isset($metas['apimo_rooms'][0])) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php _e('Rooms', 'apimo'); ?>:</dt>
						<dd class="apimo_property_value"><?php echo esc_html($metas['apimo_rooms'][0]); ?></dd>
					</dl>
				<?php endif; ?>

				<?php if (isset($metas['apimo_bathrooms'][0])) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php _e('Bathrooms', 'apimo'); ?>:</dt>
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
									<dt class="apimo_property_title"><?php _e('APE', 'apimo'); ?>:</dt>
									<dd class="apimo_property_value"><?php echo esc_html($regulation->value); ?></dd>
								</dl>
				<?php endif;
						}
					}
				}
				?>

				<!-- Continuing with heating type, device, access, and water system details -->
				<?php if ($heating_type) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php _e('Heating Type', 'apimo'); ?>:</dt>
						<dd class="apimo_property_value"><?php echo esc_html($heating_type); ?></dd>
					</dl>
				<?php endif; ?>

				<?php if ($heating_access) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php _e('Heating Access', 'apimo'); ?>:</dt>
						<dd class="apimo_property_value"><?php echo esc_html($heating_access); ?></dd>
					</dl>
				<?php endif; ?>

				<?php if ($heating_device) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php _e('Heating Device', 'apimo'); ?>:</dt>
						<dd class="apimo_property_value"><?php echo esc_html($heating_device); ?></dd>
					</dl>
				<?php endif; ?>

				<?php if ($water_hot_device) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php _e('Water Heating Device', 'apimo'); ?>:</dt>
						<dd class="apimo_property_value"><?php echo esc_html($water_hot_device); ?></dd>
					</dl>
				<?php endif; ?>

				<?php if ($water_hot_access) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php _e('Water Heating Access', 'apimo'); ?>:</dt>
						<dd class="apimo_property_value"><?php echo esc_html($water_hot_access); ?></dd>
					</dl>
				<?php endif; ?>

				<?php if ($water_waste) : ?>
					<dl class="apimo_property">
						<dt class="apimo_property_title"><?php _e('Water Waste System', 'apimo'); ?>:</dt>
						<dd class="apimo_property_value"><?php echo esc_html($water_waste); ?></dd>
					</dl>
				<?php endif; ?>

				<!-- Example for custom fees and period descriptions with serialized data -->
				<?php
				$property_period = [
					1 => 'Day',
					2 => 'Week',
					3 => 'Fortnight',
					4 => 'Month',
					5 => 'Quarterly',
					6 => 'Bimonthly',
					7 => 'Half-yearly',
					8 => 'Yearly'
				];
				if (isset($metas['apimo_residence'])) {
					$residence_data = maybe_unserialize($metas['apimo_residence']);
					if (is_array($residence_data)) {
						foreach ($residence_data as $residence) {
							if (!empty($residence->fees) && !empty($residence->period)) {
								$period_description = $property_period[$residence->period] ?? 'Unknown period';
				?>
								<dl class="apimo_property">
									<dt class="apimo_property_title"><?php _e('Fees', 'apimo'); ?>:</dt>
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
				<p><?php _e('View more', 'apimo') ?></p>
				<img class="apimo_vector" src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/images/icone-down.png' ?>" alt="" />
			</span>
		</section>
<?php if (isset($metas['apimo_property_location'])) : ?>
	<div class="apimo_line"></div>

	<section>
		<h2 class="apimo_title_h2"><?php _e('Location Details', 'apimo'); ?></h2>
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
			<div id="property-map" style="width: 100%; height: 400px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 20px;"></div>
			
			<script>
			document.addEventListener('DOMContentLoaded', function() {
				// Initialize map
				var propertyMap = L.map('property-map').setView([<?php echo $latitude; ?>, <?php echo $longitude; ?>], 15);
				
				// Add OpenStreetMap tiles with a nice style
				L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
					attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
					subdomains: 'abcd',
					maxZoom: 20
				}).addTo(propertyMap);

				// Custom marker icon (stile Apple Maps)
				var customIcon = L.divIcon({
					className: 'custom-property-marker',
					html: '<div class="property-marker-pin"><div class="property-marker-icon">🏠</div></div>',
					iconSize: [40, 50],
					iconAnchor: [20, 50],
					popupAnchor: [0, -50]
				});

				// Add marker
				var marker = L.marker([<?php echo $latitude; ?>, <?php echo $longitude; ?>], {
					icon: customIcon
				}).addTo(propertyMap);

				// Add popup with property info
				var popupContent = '<div class="property-popup">' +
					'<h4 style="margin: 0 0 10px 0; color: #0b3c5d; font-size: 16px; font-weight: 600;"><?php echo esc_js(get_the_title()); ?></h4>' +
					<?php if ($locationDetails) : ?>
					'<p style="margin: 0; color: #666; font-size: 14px;"><?php echo esc_js($locationDetails); ?></p>' +
					<?php endif; ?>
				'</div>';

				marker.bindPopup(popupContent, {
					maxWidth: 250,
					className: 'custom-popup'
				});

				// Zoom controls styling
				propertyMap.zoomControl.setPosition('bottomright');
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

			/* Responsive */
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
					<h2 class="apimo_title_h2"><?php _e('Energy performance', 'apimo'); ?></h2>
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
					<h2 class="apimo_title_h2"><?php _e('REGLEMENTATION ', 'apimo'); ?> :</h2>
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
											$valueDisplay = "No";
										} elseif ($regulation->value == '1') {
											$valueDisplay = "Included";
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
						<p><?php _e('View more', 'apimo') ?></p>

						<img class=" apimo_vector" src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/images/icone-down.png' ?>" alt="" />
					</span>
				</section>
		<?php
			}
		}
		?>



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
											echo '<p>Missing or empty URL.</p>';
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

																															   <div style="margin-top:50px; margin-bottom:50px;"> </div>
		
<!--Documents -->
<?php  
if (isset($metas['apimo_documents']) && is_array($metas['apimo_documents']) && !empty($metas['apimo_documents'])):
    foreach ($metas['apimo_documents'] as $serializedDoc):
        $doc = unserialize($serializedDoc);
        if (isset($doc[0])):
            ?>
            <div class="Pro-info">
                <h5 class="Pro-info-title"><?php _e('Documents', 'apimo'); ?></h5>
 
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
                                                    <!-- Header del documento -->
                                                    <div class="doc-header" style="background: #f8f9fa; padding: 15px; display: flex; justify-content: space-between; align-items: center;">
                                                        <div>
                                                            <h6 style="margin-bottom: 10px; color: #333; font-weight: 600;"><?= $file_name; ?></h6>
                                                            <small style="color: #666;"><?= strtoupper($file_extension); ?> • <?= $singleDoc->filesize; ?> KB</small>
                                                        </div>
                                                        <div style="display: flex; gap: 10px;">
                                                            <?php if ($file_extension === 'pdf'): ?>
                                                                <button onclick="togglePdfViewer('pdf-viewer-<?= md5($singleDoc->download_url); ?>')" 
                                                                        style="background: #007cba; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">
                                                                    📄 Visualizza PDF
                                                                </button>
                                                            <?php elseif (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                                                                <button onclick="toggleImageViewer('img-viewer-<?= md5($singleDoc->download_url); ?>')" 
                                                                        style="background: #007cba; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">
                                                                    🖼️ Visualizza Immagine
                                                                </button>
                                                            <?php endif; ?>
                                                            <a href="<?= $singleDoc->download_url; ?>" 
                                                               download="<?= $singleDoc->name; ?>"
                                                               style="background: #28a745; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; display: inline-block;">
                                                                ⬇️ Scarica
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
                                                                                Il tuo browser non supporta la visualizzazione PDF.<br>
                                                                                <a href="<?= $singleDoc->download_url; ?>" target="_blank" style="color: #007cba;">
                                                                                    Apri il PDF in una nuova finestra
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
                            
                            // Nascondi tutti gli altri viewer
                            document.querySelectorAll('.pdf-viewer, .img-viewer').forEach(v => {
                                if (v.id !== viewerId) v.style.display = 'none';
                            });
                            
                            // Toggle questo viewer
                            viewer.style.display = isVisible ? 'none' : 'block';
                            
                            // Scorri verso il viewer se lo stiamo aprendo
                            if (!isVisible) {
                                setTimeout(() => {
                                    viewer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                                }, 100);
                            }
                        }

                        function toggleImageViewer(viewerId) {
                            const viewer = document.getElementById(viewerId);
                            const isVisible = viewer.style.display !== 'none';
                            
                            // Nascondi tutti gli altri viewer
                            document.querySelectorAll('.pdf-viewer, .img-viewer').forEach(v => {
                                if (v.id !== viewerId) v.style.display = 'none';
                            });
                            
                            // Toggle questo viewer
                            viewer.style.display = isVisible ? 'none' : 'block';
                            
                            // Scorri verso il viewer se lo stiamo aprendo
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
                        
                        /* Responsive */
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

		<?php
		$data_of_area_service = (wp_get_object_terms(get_the_ID(), array('apimo_service', 'apimo_areas')));
		$final_array = array_map(function ($term) {
			return $term->term_id;
		}, $data_of_area_service);
		$terms_of_area_service = get_terms(array('taxonomy' => array('apimo_service', 'apimo_areas'), 'hide_empty' => false));



		?>
		<div class="apimo_line"></div>
		<section>
			<h2 class="apimo_title_h2"><?php _e('Services', 'apimo'); ?></h2>
			<ul class="apimo_list_prestations apimo_services">
				<?php foreach ($terms_of_area_service as $term_data) : ?>
					<?php if (in_array($term_data->term_id, $final_array)) : ?>
						<li class="apimo_item_prestations">

							<span><?php echo _e(esc_html($term_data->name), 'apimo'); ?></span>


						</li>
					<?php endif; ?>
				<?php endforeach ?>

			</ul>
			<span class="apimo_more" id="view_more_apimo_services" style="color:<?php echo $secondary_color; ?>!important;>
				<p><?php _e('View more', 'apimo') ?></p>

				<img class=" apimo_vector" src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/images/icone-down.png' ?>" alt="" />
			</span>
		</section>
		<!--User Section -->

		<?php
		if (isset($apimo_archive_settings['userinfo']) && $apimo_archive_settings['userinfo'] == 'show' && isset($metas['apimo_user_data']) && !empty($metas['apimo_user_data'])) :
			foreach ($metas['apimo_user_data'] as $serialized_user) :
				$user = maybe_unserialize($serialized_user);
				if (!empty($user) && (isset($user->firstname) || isset($user->lastname) || isset($user->email) || isset($user->phone))) :
		?>
					<section class="apimo_section_immobilier" style="background-color:#0b3c5d;">
						<div class=" apimo_immobilier">
							<img class="apimo_user_image" src="<?php echo isset($user->picture) ? esc_url($user->picture) : plugin_dir_url(dirname(__FILE__)) . 'assets/images/julie.png'; ?>" alt="" />
							<div class="apimo_info_immobilier">
								<p>
									<?php echo isset($user->firstname) && isset($user->lastname) ? esc_html($user->firstname) . ' ' . esc_html($user->lastname) : 'N/A'; ?>
									<?php if (isset($user->active) && $user->active) : ?>
										<img class="apimo_img" src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/images/verify.png'; ?>" alt="" />
									<?php endif; ?>
								</p>
								<p><?php echo isset($user->role) ? esc_html($user->role) : 'Agent immobilier'; ?></p>
							</div>
						</div>
						<div class="apimo_btn_click">
							<?php if (isset($user->email)) : ?>
								<script type="text/javascript">
									var emailSubject = "<?php echo rawurlencode(__('Interested in Property Inquiry', 'apimo')); ?>";
									var emailBody = "<?php echo rawurlencode(__('Hello, I\'m interested in this property:', 'apimo') . ' ' . get_permalink(get_the_ID())); ?>";
									var encodedEmail = "<?php echo base64_encode($user->email); ?>";
									document.write('<a  href="mailto:' + atob(encodedEmail) + '?subject=' + emailSubject + '&body=' + emailBody + '"style="color:<?php echo $primary_color; ?>"   class="apimo_btn apimo_send_email" target="_blank"><img class="apimo_icon" src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/images/send_email.png' ?>" alt=""/><?php _e('Send Email', 'apimo'); ?></a>');
								</script>
								<noscript>
									<span>Email address is protected by JavaScript.</span>
								</noscript>
							<?php endif; ?>
							<?php if (isset($user->phone)) : ?>
								<a href="tel:<?php echo esc_attr($user->phone); ?>" class="apimo_btn call_user" style="background-color:<?php echo $primary_color; ?>">
									<img class="apimo_icon" src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/images/appele.png' ?>" alt="" />
									<?php _e('Call', 'apimo'); ?>
								</a>
							<?php endif; ?>
						</div>
					</section>



		<?php
				endif;
			endforeach;
		endif;
		?>


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
						'label' => 'Last Name',
						'placeholder' => 'Enter your last name',
						'required' => 1
					),
					'first_name' => array(
						'label' => 'First Name',
						'placeholder' => 'Enter your first name',
						'required' => 0
					),
					'phone' => array(
						'label' => 'Phone',
						'placeholder' => 'Enter your phone number',
						'required' => 1
					),
					'email' => array(
						'label' => 'Email',
						'placeholder' => 'Enter your email address',
						'required' => 1
					),
					'message' => array(
						'label' => 'Message',
						'placeholder' => 'Enter your message',
						'required' => 1
					)
				);
			}
		

		?>

		<div class="apimo_form_container">
			<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors)) { ?>
				<div class="apimo_success_message" id="success">
					<?php _e('Your message has been successfully sent!', 'apimo'); ?>
				</div>
			<?php } else { ?>
				<h2 class="apimo_form_title"><?php _e('Contact Form', 'apimo'); ?></h2>
				<form class="apimo_form" method="POST" action="<?php echo esc_url($_SERVER['REQUEST_URI']) . '#success'; ?>">
					<div class="apimo_form_row">
						<div class="apimo_form_column">
							<label for="lastName" class="apimo_label <?php echo $form_configuration['last_name']['required'] ? 'apimo_required' : ''; ?>">
								<?php echo esc_html($form_configuration['last_name']['label']); ?>
							</label>
							<input 
								type="text" 
								id="lastName" 
								name="lastName" 
								class="apimo_input" 
								placeholder="<?php echo esc_attr($form_configuration['last_name']['placeholder']); ?>" 
								<?php echo $form_configuration['last_name']['required'] ? 'required' : ''; ?>>
							<div class="apimo_error_message"><?php _e('This field is required', 'apimo'); ?></div>
						</div>
						<div class="apimo_form_column">
							<label for="firstName" class="apimo_label <?php echo $form_configuration['first_name']['required'] ? 'apimo_required' : ''; ?>">
								<?php echo esc_html($form_configuration['first_name']['label']); ?>
							</label>
							<input 
								type="text" 
								id="firstName" 
								name="firstName" 
								class="apimo_input" 
								placeholder="<?php echo esc_attr($form_configuration['first_name']['placeholder']); ?>" 
								<?php echo $form_configuration['first_name']['required'] ? 'required' : ''; ?>>
						</div>
					</div>

					<div class="apimo_form_group">
						<label for="phone" class="apimo_label <?php echo $form_configuration['phone']['required'] ? 'apimo_required' : ''; ?>">
							<?php echo esc_html($form_configuration['phone']['label']); ?>
						</label>
						<input 
							type="tel" 
							id="phone" 
							name="phone" 
							class="apimo_input"  
							placeholder="<?php echo esc_attr($form_configuration['phone']['placeholder']); ?>" 
							<?php echo $form_configuration['phone']['required'] ? 'required' : ''; ?>>
						<div class="apimo_error_message"><?php _e('Invalid format', 'apimo'); ?></div>
					</div>

					<div class="apimo_form_group">
						<label for="email" class="apimo_label <?php echo $form_configuration['email']['required'] ? 'apimo_required' : ''; ?>">
							<?php echo esc_html($form_configuration['email']['label']); ?>
						</label>
						<input 
							type="email" 
							id="email" 
							name="email" 
							class="apimo_input" 
							placeholder="<?php echo esc_attr($form_configuration['email']['placeholder']); ?>" 
							<?php echo $form_configuration['email']['required'] ? 'required' : ''; ?>>
						<div class="apimo_error_message"><?php _e('Invalid email format', 'apimo'); ?></div>
					</div>

					<div class="apimo_form_group">
						<label for="message" class="apimo_label <?php echo $form_configuration['message']['required'] ? 'apimo_required' : ''; ?>">
							<?php echo esc_html($form_configuration['message']['label']); ?>
						</label>
						<textarea 
							id="message" 
							name="message" 
							class="apimo_textarea" 
							placeholder="<?php echo esc_attr($form_configuration['message']['placeholder']); ?>" 
							<?php echo $form_configuration['message']['required'] ? 'required' : ''; ?>></textarea>
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

					<button type="submit" class="apimo_submit_button"><?php _e('Send', 'apimo'); ?></button>
				</form>
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
			$credentials = base64_encode($company_id . ':' . $key); // Add the colon separator here
			

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				// Configuration Apimo
				$apimoConfig = [
					'apiUrl' => 'https://api.apimo.pro/agencies',
					'agencyId' => '23531		', 
					'credentials' => $credentials
				];

				// Validate form
				$errors = [];
				
				if (empty($_POST['lastName'])) {
					$errors[] = 'Le nom est requis';
				}
				
				if (empty($_POST['email']) && empty($_POST['phone'])) {
					$errors[] = 'Email ou téléphone est requis';
				}

				if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
					$errors[] = 'Format d\'email invalide';
				}

				if (!empty($_POST['phone']) && !preg_match('/^[0-9]{10}$/', $_POST['phone'])) {
					$errors[] = 'Format de téléphone invalide';
				}

				// If no errors, process form
				if (empty($errors)) {
					// Prepare data for API
					$leadData = [
						'reference' => uniqid('WP-'),
						'date' => date('Y-m-d H:i:s'),
						'step' => '1',
						'type' => '1',
						'language' => 'fr',
						'country' => 'FR',
						'currency' => 'EUR',
						'referral' => '1',
						
						// Form data
						'lastname' => strip_tags($_POST['lastName']),
						'firstname' => strip_tags($_POST['firstName'] ?? ''),
						'email' => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
						'phone' => strip_tags($_POST['phone'] ?? ''),
						'message' => strip_tags($_POST['message'] ?? ''),
						'property_reference' => strip_tags($_POST['reference'] ?? '')
					];

					// Initialize cURL
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
						echo '<div class="apimo_error">Erreur de connexion à l\'API: ' . curl_error($ch) . '</div>';
					} elseif ($httpCode !== 200) {
						echo '<div class="apimo_error">Erreur API Apimo: ' . $response . '</div>';
					}
					
					curl_close($ch);
				} else {
					// Display errors
					echo '<div class="apimo_error">';
					foreach ($errors as $error) {
						echo htmlspecialchars($error) . '<br>';
					}
					echo '</div>';
				}
			}
		?>


	</main>



</div>
<script>
	function toggleVisibility(sectionSelector, itemSelector, buttonId, threshold = 3, initialDisplay = 'flex') {
		const items = document.querySelectorAll(`${sectionSelector} ${itemSelector}`);
		const button = document.getElementById(buttonId);

		// Check if the number of items exceeds the threshold
		if (items.length > threshold) {
			// Only attach the event listener if there are enough items
			button.addEventListener('click', function() {
				// Determine the current display state based on the first item beyond the threshold
				const isDisplayed = items[threshold].style.display === initialDisplay;
				// Toggle display state for all items beyond the threshold
				for (let i = threshold; i < items.length; i++) {
					items[i].style.display = isDisplayed ? 'none' : initialDisplay;
				}

				// Update button text accordingly
				this.textContent = isDisplayed ? 'View More' : 'Mask';
			});
		} else {
			// Hide the button if there are not enough items
			if (button != null) {
				button.style.display = 'none';
			};
		}
	}

	// Adjust initialization to include the threshold parameter
	// Assuming the first three items are visible by default, and you want to toggle the rest
	toggleVisibility('.apimo_services', '.apimo_item_prestations', 'view_more_apimo_services', 3);

	toggleVisibility('.apimo_general_information', '.apimo_property', 'view_more_general_informations', 3);
	toggleVisibility('.apimo_regulations', '.apimo_property', 'view_more_apimo_regulations', 3);
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
<?php
global $apimo_dir, $apimo_url;

$property_reglementation = [
	[
		"id"=> 1,
		"culture"=> "en_GB",
		"name"=> "Energy - Conventional consumption",
		"value"=> "kWh\/m².year"
	],
	[
		"id"=> 2,
		"culture"=> "en_GB",
		"name"=> "Energy - Emissions estimate",
		"value"=> "kg CO2\/m².year"
	],
	[
		"id"=> 3,
		"culture"=> "en_GB",
		"name"=> "« Carrez » act",
		"value"=> "m²"
	],
	[
		"id"=> 4,
		"culture"=> "en_GB",
		"name"=> "ERP"
	],
	[
		"id"=> 5,
		"culture"=> "en_GB",
		"name"=> "Termites"
	],
	[
		"id"=> 6,
		"culture"=> "en_GB",
		"name"=> "Asbestos"
	],
	[
		"id"=> 7,
		"culture"=> "en_GB",
		"name"=> "Gas"
	],
	[
		"id"=> 8,
		"culture"=> "en_GB",
		"name"=> "Lead"
	],
	[
		"id"=> 9,
		"culture"=> "en_GB",
		"name"=> "Electricity"
	],
	[
		"id"=> 10,
		"culture"=> "en_GB",
		"name"=> "Boutin act",
		"value"=> "m²"
	],
	[
		"id"=> 11,
		"culture"=> "en_GB",
		"name"=> "Sanitation"
	],
	[
		"id"=> 12,
		"culture"=> "en_GB",
		"name"=> "EPI (Non renewable)",
		"value"=> "kWh\/m².year"
	],
	[
		"id"=> 13,
		"culture"=> "en_GB",
		"name"=> "APE"
	],
	[
		"id"=> 14,
		"culture"=> "en_GB",
		"name"=> "Request for nomination of an ad hoc agent"
	],
	[
		"id"=> 15,
		"culture"=> "en_GB",
		"name"=> "Request for nomination of a temporary administrator"
	],
	[
		"id"=> 16,
		"culture"=> "en_GB",
		"name"=> "Request for expert nomination"
	],
	[
		"id"=> 17,
		"culture"=> "en_GB",
		"name"=> "Fire safety regulations "
	],
	[
		"id"=> 18,
		"culture"=> "en_GB",
		"name"=> "Accessibility standards for people with disabilities "
	],
	[
		"id"=> 19,
		"culture"=> "en_GB",
		"name"=> "Sanitary authorization "
	],
	[
		"id"=> 20,
		"culture"=> "en_GB",
		"name"=> "Energy consumption",
		"value"=> "kWh\/m² year"
	],
	[
		"id"=> 21,
		"culture"=> "en_GB",
		"name"=> "Energy consumption"
	],
	[
		"id"=> 22,
		"culture"=> "en_GB",
		"name"=> "Land value tax",
		"value"=> "€ \/ year"
	],
	[
		"id"=> 23,
		"culture"=> "en_GB",
		"name"=> "Housing tax",
		"value"=> "€ \/ year"
	],
	[
		"id"=> 24,
		"culture"=> "en_GB",
		"name"=> "Land charges",
		"value"=> "CHF \/ an"
	],
	[
		"id"=> 25,
		"culture"=> "en_GB",
		"name"=> "Land value tax",
		"value"=> "€ \/ year"
	],
	[
		"id"=> 26,
		"culture"=> "en_GB",
		"name"=> "Land value tax",
		"value"=> "€ \/ year"
	],
	[
		"id"=> 27,
		"culture"=> "en_GB",
		"name"=> "Residents only"
	],
	[
		"id"=> 28,
		"culture"=> "en_GB",
		"name"=> "Property tax (IPTU)",
		"value"=> "R$ \/ year"
	],
	[
		"id"=> 29,
		"culture"=> "en_GB",
		"name"=> "Taxe Locale d’Equipement",
		"value"=> "€"
	],
	[
		"id"=> 30,
		"culture"=> "en_GB",
		"name"=> "Minergie"
	],
	[
		"id"=> 31,
		"culture"=> "en_GB",
		"name"=> "Volume",
		"value"=> "m³"
	],
	[
		"id"=> 32,
		"culture"=> "en_GB",
		"name"=> "Useful surface",
		"value"=> "m²"
	],
	[
		"id"=> 33,
		"culture"=> "en_GB",
		"name"=> "Co-Ownership property"
	],
	[
		"id"=> 34,
		"culture"=> "en_GB",
		"name"=> "Communal tax rate",
		"value"=> "%"
	],
	[
		"id"=> 35,
		"culture"=> "en_GB",
		"name"=> "Land register extract number"
	],
	[
		"id"=> 36,
		"culture"=> "en_GB",
		"name"=> "Droit de superficie"
	],
	[
		"id"=> 37,
		"culture"=> "en_GB",
		"name"=> "Millièmes"
	],
	[
		"id"=> 38,
		"culture"=> "en_GB",
		"name"=> "Housing tax",
		"value"=> "€ \/ year"
	],
	[
		"id"=> 39,
		"culture"=> "en_GB",
		"name"=> "PPE budget",
		"value"=> "CHF"
	],
	[
		"id"=> 40,
		"culture"=> "en_GB",
		"name"=> "Current renovation fund",
		"value"=> "CHF"
	],
	[
		"id"=> 41,
		"culture"=> "en_GB",
		"name"=> "Plot ratio"
	],
	[
		"id"=> 42,
		"culture"=> "en_GB",
		"name"=> "Occupancy ratio",
		"value"=> "%"
	],
	[
		"id"=> 43,
		"culture"=> "en_GB",
		"name"=> "Ground footprint coefficient"
	],
	[
		"id"=> 44,
		"culture"=> "en_GB",
		"name"=> "Floor space coefficient"
	],
	[
		"id"=> 45,
		"culture"=> "en_GB",
		"name"=> "Priority period CCH L443-11"
	],
	[
		"id"=> 47,
		"culture"=> "en_GB",
		"name"=> "Plot division \/ Demarcation"
	],
	[
		"id"=> 48,
		"culture"=> "en_GB",
		"name"=> "Board of directors \/ supervisory deliberation"
	],
	[
		"id"=> 49,
		"culture"=> "en_GB",
		"name"=> "Certificate of compliance"
	],
	[
		"id"=> 50,
		"culture"=> "en_GB",
		"name"=> "Energy class"
	],
	[
		"id"=> 51,
		"culture"=> "en_GB",
		"name"=> "Thermal insulation class"
	],
	[
		"id"=> 52,
		"culture"=> "en_GB",
		"name"=> "Greenhouse Gas"
	],
	[
		"id"=> 53,
		"culture"=> "en_GB",
		"name"=> "Energy passport"
	],
	[
		"id"=> 54,
		"culture"=> "en_GB",
		"name"=> "Energy certificate"
	],
	[
		"id"=> 55,
		"culture"=> "en_GB",
		"name"=> "Energy consumption \/ Final energy requirement",
		"value"=> "kWh\/(m²·a)"
	],
	[
		"id"=> 56,
		"culture"=> "en_GB",
		"name"=> "Energy efficiency class"
	],
	[
		"id"=> 57,
		"culture"=> "en_GB",
		"name"=> "Year of construction according to certificate"
	],
	[
		"id"=> 58,
		"culture"=> "en_GB",
		"name"=> "Energy consumption => Hot water included"
	],
	[
		"id"=> 59,
		"culture"=> "en_GB",
		"name"=> "Specific primary energy consumption",
		"value"=> "kWh\/m²·year"
	],
	[
		"id"=> 60,
		"culture"=> "en_GB",
		"name"=> "PEB unique code"
	],
	[
		"id"=> 61,
		"culture"=> "en_GB",
		"name"=> "K level (Thermal Insulation)"
	],
	[
		"id"=> 62,
		"culture"=> "en_GB",
		"name"=> "Ew level (Energy performance)"
	],
	[
		"id"=> 63,
		"culture"=> "en_GB",
		"name"=> "CO2 emission",
		"value"=> "kg CO2\/m².year"
	],
	[
		"id"=> 64,
		"culture"=> "en_GB",
		"name"=> "Flood risks"
	],
	[
		"id"=> 65,
		"culture"=> "en_GB",
		"name"=> "Certificate=> Oil tank conformity"
	],
	[
		"id"=> 66,
		"culture"=> "en_GB",
		"name"=> "Certificate => Electric installation conformity"
	],
	[
		"id"=> 67,
		"culture"=> "en_GB",
		"name"=> "« As Built » certificate"
	],
	[
		"id"=> 68,
		"culture"=> "en_GB",
		"name"=> "Total consumption of primary energy",
		"value"=> "kWh\/an"
	],
	[
		"id"=> 69,
		"culture"=> "en_GB",
		"name"=> "Registration number"
	],
	[
		"id"=> 70,
		"culture"=> "en_GB",
		"name"=> "Cadastral income",
		"value"=> "€"
	],
	[
		"id"=> 71,
		"culture"=> "en_GB",
		"name"=> "Planning permit obtained"
	],
	[
		"id"=> 72,
		"culture"=> "en_GB",
		"name"=> "Subdivision authorization"
	],
	[
		"id"=> 73,
		"culture"=> "en_GB",
		"name"=> "Pre-emptive right possible"
	],
	[
		"id"=> 74,
		"culture"=> "en_GB",
		"name"=> "Citation for urbanistic infraction"
	],
	[
		"id"=> 75,
		"culture"=> "en_GB",
		"name"=> "Last use designation"
	],
	[
		"id"=> 76,
		"culture"=> "en_GB",
		"name"=> "Cadastral annuity",
		"value"=> "€"
	],
	[
		"id"=> 77,
		"culture"=> "en_GB",
		"name"=> "Energy certification number"
	],
	[
		"id"=> 78,
		"culture"=> "en_GB",
		"name"=> "VAT applicable"
	],
	[
		"id"=> 79,
		"culture"=> "en_GB",
		"name"=> "Energy certification"
	],
	[
		"id"=> 80,
		"culture"=> "en_GB",
		"name"=> "Emissions estimate",
		"value"=> "kg éqCO2\/m².year"
	],
	[
		"id"=> 81,
		"culture"=> "en_GB",
		"name"=> "Emissions estimate"
	],
	[
		"id"=> 82,
		"culture"=> "en_GB",
		"name"=> "Possibility of connecting => Water \/ Gas \/ Electricity"
	],
	[
		"id"=> 83,
		"culture"=> "en_GB",
		"name"=> "Laudêmio",
		"value"=> "BRL"
	],
	[
		"id"=> 84,
		"culture"=> "en_GB",
		"name"=> "Real estate program"
	],
	[
		"id"=> 85,
		"culture"=> "en_GB",
		"name"=> "Accessible to foreigners"
	],
	[
		"id"=> 86,
		"culture"=> "en_GB",
		"name"=> "Building type"
	],
	[
		"id"=> 87,
		"culture"=> "en_GB",
		"name"=> "Primärenergiebedarf",
		"value"=> "kWh\/(m².a)"
	],
	[
		"id"=> 88,
		"culture"=> "en_GB",
		"name"=> "Flat rate for charges"
	],
	[
		"id"=> 89,
		"culture"=> "en_GB",
		"name"=> "Energy Efficiency Rating (Current)"
	],
	[
		"id"=> 90,
		"culture"=> "en_GB",
		"name"=> "Energy Efficiency Rating (Potential)"
	],
	[
		"id"=> 91,
		"culture"=> "en_GB",
		"name"=> "Environmental Impact Rating (Current)"
	],
	[
		"id"=> 92,
		"culture"=> "en_GB",
		"name"=> "Environmental Impact Rating (Potential)"
	],
	[
		"id"=> 93,
		"culture"=> "en_GB",
		"name"=> "Tenure type"
	],
	[
		"id"=> 94,
		"culture"=> "en_GB",
		"name"=> "Property tenure"
	],
	[
		"id"=> 95,
		"culture"=> "en_GB",
		"name"=> "Rental value",
		"value"=> "CHF"
	],
	[
		"id"=> 96,
		"culture"=> "en_GB",
		"name"=> "Tax value",
		"value"=> "CHF"
	],
	[
		"id"=> 97,
		"culture"=> "en_GB",
		"name"=> "Insurance value",
		"value"=> "CHF"
	],
	[
		"id"=> 98,
		"culture"=> "en_GB",
		"name"=> "Building zone"
	],
	[
		"id"=> 99,
		"culture"=> "en_GB",
		"name"=> "Stratum"
	],
	[
		"id"=> 100,
		"culture"=> "en_GB",
		"name"=> "Rental reference index"
	],
	[
		"id"=> 101,
		"culture"=> "en_GB",
		"name"=> "Last rental price",
		"value"=> "€"
	],
	[
		"id"=> 102,
		"culture"=> "en_GB",
		"name"=> "Energy - Conventional consumption",
		"value"=> "kWh\/m².year"
	],
	[
		"id"=> 103,
		"culture"=> "en_GB",
		"name"=> "Building envelope efficiency"
	],
	[
		"id"=> 104,
		"culture"=> "en_GB",
		"name"=> "Overall energy efficiency"
	],
	[
		"id"=> 105,
		"culture"=> "en_GB",
		"name"=> "Dry rot diagnosis"
	],
	[
		"id"=> 106,
		"culture"=> "en_GB",
		"name"=> "Additional rent",
		"value"=> "€"
	],
	[
		"id"=> 107,
		"culture"=> "en_GB",
		"name"=> "Indexed cadastral income",
		"value"=> "€"
	],
	[
		"id"=> 108,
		"culture"=> "en_GB",
		"name"=> "Property tax",
		"value"=> "€"
	],
	[
		"id"=> 109,
		"culture"=> "en_GB",
		"name"=> "EPI (Renewable)",
		"value"=> "kWh\/m².year"
	],
	[
		"id"=> 110,
		"culture"=> "en_GB",
		"name"=> "Emission class"
	],
	[
		"id"=> 111,
		"culture"=> "en_GB",
		"name"=> "Heating costs",
		"value"=> "€"
	],
	[
		"id"=> 112,
		"culture"=> "en_GB",
		"name"=> "Performance level (summer season)"
	],
	[
		"id"=> 113,
		"culture"=> "en_GB",
		"name"=> "Performance level (winter season)"
	],
	[
		"id"=> 114,
		"culture"=> "en_GB",
		"name"=> "Cadastral data - Section"
	],
	[
		"id"=> 115,
		"culture"=> "en_GB",
		"name"=> "Cadastral data - Sheet"
	],
	[
		"id"=> 116,
		"culture"=> "en_GB",
		"name"=> "Cadastral data - Parcel"
	],
	[
		"id"=> 117,
		"culture"=> "en_GB",
		"name"=> "Cadastral data - Subparcel"
	],
	[
		"id"=> 118,
		"culture"=> "en_GB",
		"name"=> "Cadastral data - Sub"
	],
	[
		"id"=> 119,
		"culture"=> "en_GB",
		"name"=> "Cadastral data - Sub 2"
	],
	[
		"id"=> 120,
		"culture"=> "en_GB",
		"name"=> "Energy - Low estimated annual expenditure for standard use",
		"value"=> "€ \/ year"
	],
	[
		"id"=> 121,
		"culture"=> "en_GB",
		"name"=> "Energy - High estimated annual expenditure for standard use",
		"value"=> "€ \/ year"
	],
	[
		"id"=> 122,
		"culture"=> "en_GB",
		"name"=> "Energy - Energy Price Reference Year"
	],
	[
		"id"=> 123,
		"culture"=> "en_GB",
		"name"=> "Licença de habitação - Número"
	],
	[
		"id"=> 124,
		"culture"=> "en_GB",
		"name"=> "Licença de habitação - Emitida em"
	],
	[
		"id"=> 125,
		"culture"=> "en_GB",
		"name"=> "Taxa de IMI",
		"value"=> "€"
	],
	[
		"id"=> 127,
		"culture"=> "en_GB",
		"name"=> "Regime de IVA"
	],
	[
		"id"=> 128,
		"culture"=> "en_GB",
		"name"=> "Escritura - Número"
	],
	[
		"id"=> 130,
		"culture"=> "en_GB",
		"name"=> "Licença de construção - Número"
	],
	[
		"id"=> 131,
		"culture"=> "en_GB",
		"name"=> "Licença de construção - Emitida em"
	],
	[
		"id"=> 132,
		"culture"=> "en_GB",
		"name"=> "Tenant charges conditions"
	],
	[
		"id"=> 133,
		"culture"=> "en_GB",
		"name"=> "Land value tax",
		"value"=> "$ \/ year"
	],
	[
		"id"=> 134,
		"culture"=> "en_GB",
		"name"=> "Council Tax Band"
	],
	[
		"id"=> 135,
		"culture"=> "en_GB",
		"name"=> "Maximum reference rent (base rent not to be exceeded)",
		"value"=> "€"
	],
	[
		"id"=> 136,
		"culture"=> "en_GB",
		"name"=> "Contratto di affitto"
	],
	[
		"id"=> 137,
		"culture"=> "en_GB",
		"name"=> "Cadastral category"
	],
	[
		"id"=> 138,
		"culture"=> "en_GB",
		"name"=> "Household waste collection tax",
		"value"=> "€ \/ year"
	],
	[
		"id"=> 139,
		"culture"=> "en_GB",
		"name"=> "Flood risks P-score"
	],
	[
		"id"=> 140,
		"culture"=> "en_GB",
		"name"=> "Flood risks G-score"
	],
	[
		"id"=> 141,
		"culture"=> "en_GB",
		"name"=> "Connectivity - Building connection"
	],
	[
		"id"=> 142,
		"culture"=> "en_GB",
		"name"=> "Connectivity - Vertical Wiring"
	],
	[
		"id"=> 143,
		"culture"=> "en_GB",
		"name"=> "Asbestos certificate"
	],
	[
		"id"=> 144,
		"culture"=> "en_GB",
		"name"=> "Building with main use other than residential"
	],
	[
		"id"=> 145,
		"culture"=> "en_GB",
		"name"=> "Énergie - Consommation finale",
		"value"=> "kWhEF\/m².an"
	],
	[
		"id"=> 146,
		"culture"=> "en_GB",
		"name"=> "Energy-efficient class"
	],
	[
		"id"=> 147,
		"culture"=> "en_GB",
		"name"=> "Energy - Ademe Reference"
	],
	[
		"id"=> 148,
		"culture"=> "en_GB",
		"name"=> "Certificate of conformity (rental)"
	],
	[
		"id"=> 149,
		"culture"=> "en_GB",
		"name"=> "Licença de Alojamento Local",
		"value"=> "\/AL"
	],
	[
		"id"=> 150,
		"culture"=> "en_GB",
		"name"=> "Ground rent",
		"value"=> "£\/year"
	],
	[
		"id"=> 151,
		"culture"=> "en_GB",
		"name"=> "Energy audit"
	],
	[
		"id"=> 152,
		"culture"=> "en_GB",
		"name"=> "Tax identifier of the property"
	],
	[
		"id"=> 153,
		"culture"=> "en_GB",
		"name"=> "Land price excluding taxes",
		"value"=> "€"
	],
	[
		"id"=> 154,
		"culture"=> "en_GB",
		"name"=> "Taxes related to land",
		"value"=> "€"
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

function getPropertyName($id, $property_reglementation) {
    foreach ($property_reglementation as $item) {
        if ($item["id"] == $id) {
            return stripslashes($item["name"]);
        }
    }
    return "Property not found";
}



    
             




                        


$metas = get_post_meta(get_the_ID());
$thumbnail = get_the_post_thumbnail_url(get_the_ID());

$city_term = wp_get_post_terms(get_the_ID(), 'city');



// Assuming $apimo_residence_data is an array of serialized data

// die();

// Note: If $apimo_residence_data is not an array of serialized data, adjust the code accordingly.


// echo '<pre>';
// print_r($city_term);
// echo '</pre>';


// $city_term = wp_get_post_terms(get_the_ID(), 'city');
//print_r($city_term);
// if (count($city_term) > 1) {
//     if ($city_term[0]->parent == 0) {
//         $city = $city_term[0]->name . ' - ' . $city_term[1]->name;
//     } else {
//         $city = $city_term[1]->name . ' - ' . $city_term[0]->name;
//     }
// } else {
// $city_term = wp_get_post_terms(get_the_ID(), 'city');
$city = $zip_code = '';
if (!empty($city_term)) {
    $city = $city_term[0]->name;
    $zip_code = get_term_meta($city_term[0]->term_id, 'zip_code', true);
    $city = $city . ' - ' . $zip_code;
}

// die('aminechakker'.get_the_ID());
// $city = $city_term[0]->name;

// $zip_code = get_term_meta($city_term[0]->term_id, 'zip_code', true);

// $city = $city . ' - ' . $zip_code;
// }
##############33
// $type = wp_get_post_terms(get_the_ID(), 'apimo_type')[0]->name;
// $subtype = wp_get_post_terms(get_the_ID(), 'apimo_subtype')[0]->name;
// // $flor = wp_get_post_terms(get_the_ID(), 'apimo_floor')[0]->name;

// $terms = wp_get_post_terms(get_the_ID(), 'apimo_floor');

// if (!empty($terms)) {
//     $flor = $terms[0]->name;
// } 


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


$heating_type = !empty(wp_get_post_terms(get_the_ID(), 'apimo_heating_type'))?wp_get_post_terms(get_the_ID(), 'apimo_heating_type')[0]->name:'';
$heating_access = !empty(wp_get_post_terms(get_the_ID(), 'apimo_heating_access'))?wp_get_post_terms(get_the_ID(), 'apimo_heating_access')[0]->name:'';;
$heating_device = !empty(wp_get_post_terms(get_the_ID(), 'apimo_heating_device'))?wp_get_post_terms(get_the_ID(), 'apimo_heating_device')[0]->name:'';;
$water_hot_device = !empty(wp_get_post_terms(get_the_ID(), 'apimo_water_hot_device'))?wp_get_post_terms(get_the_ID(), 'apimo_water_hot_device')[0]->name:'';;
$water_hot_access = !empty(wp_get_post_terms(get_the_ID(), 'apimo_water_hot_access'))?wp_get_post_terms(get_the_ID(), 'apimo_water_hot_access')[0]->name:'';;
$water_waste = !empty(wp_get_post_terms(get_the_ID(), 'apimo_water_waste'))?wp_get_post_terms(get_the_ID(), 'apimo_water_waste')[0]->name:'';;
$apimo_category = !empty(wp_get_post_terms(get_the_ID(), 'apimo_category'))?wp_get_post_terms(get_the_ID(), 'apimo_category')[0]->name:'';;
$availability = !empty(wp_get_post_terms(get_the_ID(), 'apimo_availability'))?wp_get_post_terms(get_the_ID(), 'apimo_availability')[0]->name:'';;
$property_standing =  !empty(wp_get_post_terms(get_the_ID(), 'apimo_property_standing'))?wp_get_post_terms(get_the_ID(), 'apimo_property_standing')[0]->name:'';

$grid_desktop = 'column-desktop-' . $apimo_archive_settings['view_1']['desktop'];
$grid_tablet = 'column-tablet-' . $apimo_archive_settings['view_1']['teblate'];
$grid_mobile = 'column-mobile-' . $apimo_archive_settings['view_1']['mobile'];

global $UNIT_AREA;
// echo '<pre>';
// print_r($metas['apimo_regulations']);
// echo '<pre>';

?>
<div>
    <?php
    // echo '<pre>';
    // print_r(maybe_unserialize($metas['apimo_regulations'][0]));
    // echo '<pre>';
    ?>
</div>
<div class="apimo-wrapper">
    <div class="apimo-wrapper__inner">
        <section class="Product-detail-page apimo-content-wrapper">
            <div class="Pro-detail-wrapper">
                <div class="Pro-detail-wrapper-row">
                    <div class="Pro-detail-wrapper-col-image">

                        <div class="apimo-property-slider">
                            
                            <?php 
                                // $agreement_types = [
                                //     1 => 'Standard',
                                //     2 => 'Co-exclusive',
                                //     3 => 'Exclusive',
                                //     4 => 'Delegation',
                                //     5 => 'Exclusive agent',
                                //     6 => 'Colleague',
                                //     7 => 'Verbal'
                                // ];
                                if(isset($metas['apimo_agreement'])){
                                    $apimo_agreement_data = $metas['apimo_agreement'];
                                    if ($apimo_agreement_data && isset($apimo_agreement_data[0])) {
                                        // Extract the first element of the array
                                        $serialized_agreement = $apimo_agreement_data[0];
                                        // Unserialize the data
                                        $agreement = unserialize($serialized_agreement);
                                        if($agreement->type == 3){
                                            $src = plugin_dir_url(dirname(__FILE__)) . 'assets/images/badge_exclusive.png';                                    

                                            ?>
                                                
                                                <img class="exclusive_badge"  src="<?php echo $src; ?>" alt="Exclusive">

                                            <?php 
                                        }
                                    }
                                }                                             
                            ?>
                            
                            <div class="apimo-propery-images apimo-display">
                                <div class="apimo-image">
                                    <?php 

                                        if($thumbnail == ""){
                                            $src = plugin_dir_url(dirname(__FILE__)) . 'assets/images/noimage.png';                                    
                                        }else{
                                            $src = $thumbnail;
                                        }

                                    ?>
                                    <a data-fslightbox="gallery" href="<?php echo esc_url($src); ?>">
                                        <img src="<?php echo esc_url($src); ?>" class="single-apimo-img" alt="">
                                    </a>
                                </div>
                                <?php
                                $apimo_gallery_images = maybe_unserialize($metas['apimo_gallery_images'][0]);
                                if(isset($apimo_gallery_images) && is_array($apimo_gallery_images)){
                                    foreach ($apimo_gallery_images as $gallery_image ){
                                        ?>
                                            <div class="apimo-image">
                                                
                                                <a data-fslightbox="gallery" href="<?php echo esc_url($gallery_image); ?>">
                                                    <img src="<?php echo esc_url($gallery_image); ?>" alt="">
                                                </a>
                                                
                                            </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class="apimo-carousel-arrow">
                                <ul>
                                    <li class="apimo-arrow apimo-carousel-prev">
                                        <span class="icon">
                                            <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23.79 45.01">
                                                <path d="M-64.65,10.36a1.27,1.27,0,0,0-.9-.38,1.23,1.23,0,0,0-.9.38L-87.66,31.57a1.26,1.26,0,0,0,0,1.79h0l21.21,21.22a1.28,1.28,0,0,0,1.8.06,1.27,1.27,0,0,0,.06-1.8l-.06-.06L-85,32.47l20.31-20.31a1.28,1.28,0,0,0,0-1.8Z" transform="translate(88.04 -9.98)" />
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="apimo-arrow apimo-carousel-next">
                                        <span class="icon">
                                            <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23.79 45.01">
                                                <path d="M-87.63,54.61a1.27,1.27,0,0,0,.9.38,1.23,1.23,0,0,0,.9-.38L-64.62,33.4a1.26,1.26,0,0,0,0-1.79h0L-85.83,10.38a1.28,1.28,0,0,0-1.8-.06,1.27,1.27,0,0,0-.06,1.8l.06.06L-67.32,32.5-87.63,52.81a1.28,1.28,0,0,0,0,1.8Z" transform="translate(88.04 -9.98)" />
                                            </svg>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="apimo-thumbs-dots">
                            <div class="apimo-propery-images apimo-navbar" style="display:none;">
                                <div class="apimo-image">
                                    <img src="<?php echo esc_url($thumbnail); ?>" class="single-navbar-apimo-img" alt="">
                                </div>
                                <?php
                                $apimo_gallery_images = unserialize($metas['apimo_gallery_images'][0]);
                                if(isset($apimo_gallery_images) and is_array($apimo_gallery_images)){
                                    foreach (unserialize($metas['apimo_gallery_images'][0]) as $gallery_image) {
                                        ?>
                                            <div class="apimo-image">
                                                <a data-fslightbox="gallery" href="<?php echo esc_url($gallery_image); ?>">
                                                    <img src="<?php echo esc_url($gallery_image); ?>" class="single-apimo-img" alt="">
                                                </a>
                                            </div>
                                            
                                        <?php
                                    }
                                }
                                 ?>
                            </div>
                        </div>
                    </div>

                    
                    <!-- Lightbox Markup -->
                    <div id="lightbox" class="lightbox">
                        <span class="close-btn">&times;</span>
                        <div id="lightbox-content" class="lightbox-content">
                            <div id="lightbox-slider" class="lightbox-slider">
                                <!-- Lightbox slider content will be dynamically added here -->
                            </div>
                        </div>
                    </div>


                    
                    <div class="Pro-detail-wrapper-col-info">
                        <div class="Pro-detail-info">
                            <div class="Flex-col space-between">
                                <?php /* <span class="Pro-d-cat"><?php if($subtype){ echo $subtype; } ?></span> */ ?>

                            </div>
                            <div class="Pro-title">
                                <h3><?php echo get_the_title(); ?></h3>


                            </div>
                            <div class="Pro-address">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12.783" height="15.979" viewBox="0 0 12.783 15.979">
                                    <g id="noun_Location_94613" transform="translate(356 -253.3)">
                                        <path id="Path_11" data-name="Path 11" d="M-349.608,253.3A6.388,6.388,0,0,0-356,259.692c0,6.392,6.392,9.588,6.392,9.588s6.392-3.018,6.392-9.588A6.388,6.388,0,0,0-349.608,253.3Zm0,9.588a3.205,3.205,0,0,1-3.2-3.2,3.205,3.205,0,0,1,3.2-3.2,3.205,3.205,0,0,1,3.2,3.2A3.205,3.205,0,0,1-349.608,262.888Z" transform="translate(0 0)" fill="#6a6a6a" />
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




                            <div class="apimo-reference-properties-id">
                                <?php
                                echo esc_html($metas['apimo_id'][0]);
                                ?>

                            </div>
                            <?php if ($metas['apimo_price_hide'][0]) : ?>
                                <span class="Pro-d-price"><?php _e('Private negotiation','apimo'); ?></span>
                            <?php else : ?>
                                <span class="Pro-d-price">
                                    <?php 
                                        if ($metas['apimo_price'][0]) {
                                            echo esc_html(apimo_currency_format($metas['apimo_price'][0]));
                                            // Check if price commission is set and not empty
                                            if (!empty($metas['apimo_price_commission'][0])) {
                                                // Calculate commission percentage
                                                $price_value = $metas['apimo_price'][0];
                                                $price_commission = $metas['apimo_price_commission'][0];
                                                $commission_percentage = ($price_commission / $price_value) * 100;
                                                // Display commission percentage
                                                echo "<span class='Pro-d-commission-badge'>" . sprintf(__('Commission: %.2f%%', 'apimo'), $commission_percentage) . "</span>";
                                            }
                                        } else {
                                            echo esc_html(apimo_currency_format(0));
                                        } 
                                    ?>
                                </span>
                            <?php endif; ?>

                            

                            <div class="Pro-info">
                                <h5 class="Pro-info-title"><?php _e('Property specifications', 'apimo'); ?></h5>
                                <ul class="Pro-points">
                                    <li class="Pro-meta">
                                        <svg id="noun_floor_plan_3338563" data-name="noun_floor plan_3338563" xmlns="http://www.w3.org/2000/svg" width="24.511" height="24.511" viewBox="0 0 24.511 24.511">
                                            <path id="Path_12" data-name="Path 12" d="M32.06,15.821H34.2a.306.306,0,0,0,.306-.306V10.306A.306.306,0,0,0,34.2,10h-23.9a.306.306,0,0,0-.306.306V34.2a.306.306,0,0,0,.306.306H34.2a.306.306,0,0,0,.306-.306V19.5a.613.613,0,1,0-1.226,0v2.451H29.3a.613.613,0,0,0,0,1.226H32.06v8.579h-6.1V26.295a.613.613,0,1,0-1.226,0v5.459H13.064V23.175h2.145v2.757a.613.613,0,0,0,1.226,0V23.175h9.8a.613.613,0,0,0,0-1.226h-.306V21.03a.613.613,0,0,0-1.226,0v.919H13.064V12.757H24.706v4.9a.613.613,0,0,0,1.226,0v-.306h3.677a.613.613,0,1,0,0-1.226H25.932v-3.37h5.821v2.757A.306.306,0,0,0,32.06,15.821Z" transform="translate(-10 -10)" fill="#6a6a6a" />
                                        </svg>
                                        <span class="value"><?php if ($metas['apimo_rooms'][0]) {
                                                                echo esc_html($metas['apimo_rooms'][0]);
                                                            } else {
                                                                echo 0;
                                                            } ?> <?php _e('Rooms', 'apimo'); ?></span>
                                    </li>
                                    <li class="Pro-meta">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="21.608" height="24.511" viewBox="0 0 21.608 24.511">
                                            <g id="noun_Bath_4032349" transform="translate(0)">
                                                <path id="Path_1" data-name="Path 1" d="M25.026,13.963H4.755V3.213A2.252,2.252,0,0,1,7,.961a1.5,1.5,0,0,1,1.08.44l.475.479A2.535,2.535,0,0,0,8.37,5.155l.2.26a.383.383,0,0,0,.295.146.341.341,0,0,0,.222-.077L12.633,2.8a.383.383,0,0,0,.046-.529l-.2-.257A2.524,2.524,0,0,0,9.328,1.3L8.753.724A2.455,2.455,0,0,0,7,0,3.217,3.217,0,0,0,3.79,3.213V17.46a5.45,5.45,0,0,0,5.059,5.431h0v1.237a.383.383,0,1,0,.766,0V22.906h9.957v1.222a.383.383,0,1,0,.766,0V22.891h0A5.45,5.45,0,0,0,25.4,17.46V14.335A.383.383,0,0,0,25.026,13.963Z" transform="translate(-3.79 0)" fill="#6a6a6a" />
                                                <path id="Path_2" data-name="Path 2" d="M20.061,17.1a.479.479,0,0,0,.207-.306.463.463,0,0,0-.073-.36l-.421-.632a.483.483,0,0,0-.666-.134.471.471,0,0,0-.2.306.479.479,0,0,0,.069.36l.421.632a.486.486,0,0,0,.4.214A.46.46,0,0,0,20.061,17.1Z" transform="translate(-13.109 -9.62)" fill="#6a6a6a" />
                                                <path id="Path_3" data-name="Path 3" d="M21.026,23.82a.486.486,0,0,0,.437.272.484.484,0,0,0,.452-.318.49.49,0,0,0-.019-.383l-.326-.686a.483.483,0,0,0-.437-.276.484.484,0,0,0-.452.318.49.49,0,0,0,.019.383Z" transform="translate(-14.194 -13.84)" fill="#6a6a6a" />
                                                <path id="Path_4" data-name="Path 4" d="M23.484,30.893a.479.479,0,0,0,.448.3.484.484,0,0,0,.44-.291.456.456,0,0,0,0-.383l-.28-.709a.479.479,0,0,0-.448-.3.467.467,0,0,0-.176.034.46.46,0,0,0-.264.257.471.471,0,0,0,0,.383Z" transform="translate(-15.744 -18.208)" fill="#6a6a6a" />
                                                <path id="Path_5" data-name="Path 5" d="M23.418,14.347a.479.479,0,0,0,.23-.061.493.493,0,0,0,.188-.67l-.383-.666a.475.475,0,0,0-.651-.188.493.493,0,0,0-.188.67L23,14.1a.479.479,0,0,0,.421.249Z" transform="translate(-15.364 -7.836)" fill="#6a6a6a" />
                                                <path id="Path_6" data-name="Path 6" d="M27,21a.5.5,0,0,0,.234-.057.479.479,0,0,0,.188-.655l-.383-.666a.479.479,0,0,0-.421-.249.505.505,0,0,0-.234.061.479.479,0,0,0-.188.655l.383.666A.475.475,0,0,0,27,21Z" transform="translate(-17.574 -11.952)" fill="#6a6a6a" />
                                                <path id="Path_7" data-name="Path 7" d="M29.787,26.263a.494.494,0,0,0,.042.383l.383.663a.483.483,0,1,0,.843-.463l-.383-.666a.486.486,0,0,0-.421-.249.494.494,0,0,0-.234.061.479.479,0,0,0-.23.272Z" transform="translate(-19.817 -15.999)" fill="#6a6a6a" />
                                                <path id="Path_8" data-name="Path 8" d="M26.722,11.051l.383.666a.494.494,0,0,0,.421.245.463.463,0,0,0,.234-.061.483.483,0,0,0,.184-.655L27.56,10.6a.479.479,0,0,0-.421-.249.506.506,0,0,0-.234.061.483.483,0,0,0-.184.64Z" transform="translate(-17.905 -6.386)" fill="#6a6a6a" />
                                                <path id="Path_9" data-name="Path 9" d="M31.692,17.357a.479.479,0,0,0,.349.149.49.49,0,0,0,.329-.126.471.471,0,0,0,.153-.337.479.479,0,0,0-.13-.345l-.521-.555a.49.49,0,0,0-.352-.153.483.483,0,0,0-.349.812Z" transform="translate(-20.604 -9.866)" fill="#6a6a6a" />
                                                <path id="Path_10" data-name="Path 10" d="M36.475,23.107a.49.49,0,0,0,.682.023.483.483,0,0,0,.023-.682l-.521-.555a.49.49,0,0,0-.352-.153.481.481,0,0,0-.349.812Z" transform="translate(-23.557 -13.414)" fill="#6a6a6a" />
                                            </g>
                                        </svg>
                                        <span><?php if ($metas['apimo_bathrooms'][0]) {
                                                    echo esc_html($metas['apimo_bathrooms'][0]);
                                                } else {
                                                    echo (0);
                                                } ?> <?php _e('Bathroom', 'apimo'); ?></span>
                                    </li>
                                    <li class="Pro-meta">
                                        <svg id="noun_measure_4212089" xmlns="http://www.w3.org/2000/svg" width="24.83" height="24.588" viewBox="0 0 24.83 24.588">
                                            <path id="Path_13" data-name="Path 13" d="M29.579,26.363l-2.125-2.125a.9.9,0,0,0-1.269,1.269l.607.607H8.964V8.536l.607.607a.951.951,0,0,0,.635.276.838.838,0,0,0,.635-.276.883.883,0,0,0,0-1.269L8.716,5.748a.971.971,0,0,0-1.3,0L5.294,7.873A.9.9,0,0,0,6.563,9.143l.607-.607v19.4H26.792l-.607.607a.883.883,0,0,0,0,1.269.951.951,0,0,0,.635.276.838.838,0,0,0,.635-.276l2.125-2.125a1.018,1.018,0,0,0,.276-.662A.856.856,0,0,0,29.579,26.363Z" transform="translate(-5.025 -5.5)" fill="#6a6a6a" />
                                            <path id="Path_14" data-name="Path 14" d="M30.811,34.253H42.87a.919.919,0,0,0,.911-.911V21.311a.919.919,0,0,0-.911-.911H30.811a.919.919,0,0,0-.911.911V33.37A.914.914,0,0,0,30.811,34.253Z" transform="translate(-23.035 -16.288)" fill="#6a6a6a" />
                                        </svg>
                                        <span class="value">
                                            <?php
                                                if (isset($metas['apimo_area_display_filter'][0]) && $metas['apimo_area_display_filter'][0]) {
                                                    echo esc_html($metas['apimo_area_display_filter'][0]);
                                                } else {
                                                    echo 0;
                                                }
                                            ?> 
                                            <?php
                                                if ( 
                                                    isset($metas['apimo_area_unit'][0]) &&
                                                    isset($UNIT_AREA[$metas['apimo_area_unit'][0]])
                                                ) {
                                                    echo esc_html($UNIT_AREA[$metas['apimo_area_unit'][0]]);
                                                }

                                            ?>
                                        </span>
                                    </li>
                                    <?php if ($flor) : ?>
                                        <li class="Pro-meta">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24.596" height="19.032" viewBox="0 0 24.596 19.032">
                                                <g id="noun_Stairs_1137999" transform="translate(-5.8 -15.8)">
                                                    <g id="Group_1" data-name="Group 1" transform="translate(5.8 15.8)">
                                                        <path id="Path_15" data-name="Path 15" d="M29.84,968.162a.557.557,0,0,1,.556.557v17.919a.556.556,0,0,1-.556.556H6.447c-.454,0-.645-.185-.647-.646v-4.365a.556.556,0,0,1,.556-.557h5.32V977.76a.556.556,0,0,1,.557-.556h5.309v-3.8a.557.557,0,0,1,.557-.557h5.309v-4.129a.557.557,0,0,1,.556-.556H29.84Z" transform="translate(-5.8 -968.162)" fill="#6a6a6a" fill-rule="evenodd" />
                                                    </g>
                                                </g>
                                            </svg>
                                            <span class="value"><?php echo esc_html($flor); ?></span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <?php if (!empty($external_areas)) : ?>
                                <div class="Pro-external-area">
                                    <h5 class="Pro-info-title"><?php _e('External areas', 'apimo'); ?></h5>
                                    <ul class="Pro-points">
                                        <?php
                                        foreach ($external_areas as $area) {
                                            $id = get_term_meta($area->term_id, 'apimo_term_id', true);
                                            if ($id == 49) {
                                        ?>
                                                <li class="Pro-meta">
                                                    <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                                        <path d="M31.07,29.66a7.43,7.43,0,0,0,2.56.46,7.5,7.5,0,0,0,6-12A7.5,7.5,0,0,0,34.19,5.46a7.78,7.78,0,0,0-1.73.2,7.49,7.49,0,0,0-14.55.09,7.43,7.43,0,0,0-2.06-.29,7.49,7.49,0,0,0-5.1,13A7.48,7.48,0,0,0,17,30.12a7.65,7.65,0,0,0,2.24-.34A7.47,7.47,0,0,0,24,32.56V49a1,1,0,1,0,2,0V32.58a7.57,7.57,0,0,0,5.06-2.92Zm-10.66-1.6a1,1,0,0,0-.83-.46.92.92,0,0,0-.4.08,5.41,5.41,0,0,1-2.21.46A5.51,5.51,0,0,1,12.86,19a1,1,0,0,0,.24-.77,1,1,0,0,0-.41-.7A5.52,5.52,0,0,1,18.27,8a1,1,0,0,0,1.43-.83A5.51,5.51,0,0,1,30.7,7a1,1,0,0,0,.47.77,1,1,0,0,0,.89.06A5.54,5.54,0,0,1,39.72,13a5.51,5.51,0,0,1-2.08,4.31,1,1,0,0,0-.37.71,1,1,0,0,0,.29.76,5.52,5.52,0,0,1-6.41,8.81,1,1,0,0,0-1.3.38A5.55,5.55,0,0,1,26,30.58V20.45a1,1,0,1,0-2,0v10.1a5.52,5.52,0,0,1-3.62-2.49Z" />
                                                        <path d="M21.85,46H18.11v-7h3.6a1,1,0,1,0,0-2h-3.6V35.44a1,1,0,1,0-2,0V37H10.2V35.44a1,1,0,1,0-2,0V37H2.3V35.44a1,1,0,1,0-2,0v2a.89.89,0,0,0,0,1.1v7.89a.89.89,0,0,0,0,1.1V49a1,1,0,1,0,2,0V47.93H8.23V49a1,1,0,0,0,2,0V47.93h5.92V49a1,1,0,1,0,2,0V47.93h3.74a1,1,0,1,0,0-2ZM2.3,46v-7H8.23v7Zm7.9,0v-7h5.93v7Z" />
                                                        <path d="M49.72,46.25V38.64A1,1,0,0,0,50,38a1,1,0,0,0-.28-.68V35.44a1,1,0,1,0-2,0V37H41.82V35.44a1,1,0,0,0-2,0V37H33.91V35.44a1,1,0,1,0-2,0V37H28.43a1,1,0,0,0,0,2h3.51v7H28.29a1,1,0,1,0,0,2h3.65V49a1,1,0,1,0,2,0V47.93h5.93V49a1,1,0,1,0,2,0V47.93h5.92V49a1,1,0,1,0,2,0V47.62a1,1,0,0,0,.28-.68,1,1,0,0,0-.28-.69ZM33.91,46v-7h5.93v7Zm7.91,0v-7h5.92v7Z" />
                                                    </svg>
                                                    <span class="value"><?php echo _e('Garden', 'apimo'); ?></span>
                                                </li>
                                            <?php
                                            }
                                            if ($id == 50) {
                                            ?>
                                                <li class="Pro-meta">
                                                    <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 45.8 49.67">
                                                        <path d="M7.14,36.24a9.93,9.93,0,0,0,5.11,1.31l4.58-.12,6.39-.2c.12,2.89.33,5.77.62,8.66h0A119.21,119.21,0,0,0,9,47c-.16,0-.29.42-.29.91s.13.9.29.92H9a118.07,118.07,0,0,0,31.31,0c.17,0,.3-.44.3-.94s-.13-.91-.3-.94h0a118.08,118.08,0,0,0-14.06-1q.44-4.4.62-8.81a.34.34,0,0,1,.17,0h.18l8.38.27,2.09,0a10.54,10.54,0,0,0,2.38-.21,9.77,9.77,0,0,0,4.31-2.13,10,10,0,0,0,3.46-8.81,10.19,10.19,0,0,0-4.26-7,10.29,10.29,0,0,0-8.9-12.57,10.4,10.4,0,0,0-19.29,0A10.33,10.33,0,0,0,6.44,19.25a10.2,10.2,0,0,0-4.34,8,10.06,10.06,0,0,0,1.28,5.2,9.94,9.94,0,0,0,3.76,3.8ZM5.4,27.35a6.8,6.8,0,0,1,3.95-5.69,1.8,1.8,0,0,0,.89-.93,1.74,1.74,0,0,0,0-1.29v0a6.61,6.61,0,0,1,6.51-8.88A1.83,1.83,0,0,0,18,10.16a1.87,1.87,0,0,0,.72-1.06v0A6.55,6.55,0,0,1,31.39,9v.05a1.78,1.78,0,0,0,.7,1,1.83,1.83,0,0,0,1.22.35A6.56,6.56,0,0,1,39,13.13a6.63,6.63,0,0,1,.9,6.26v.05a1.76,1.76,0,0,0,0,1.24,1.66,1.66,0,0,0,.86.89,6.92,6.92,0,0,1,4,5.21,7.12,7.12,0,0,1-5.32,7.95,8,8,0,0,1-1.82.24L35.43,35,27,35.29h-.09c.08-2.47.07-4.94,0-7.41h0a18,18,0,0,0,9.11-5.71,2.36,2.36,0,0,0-.37-.88,2.45,2.45,0,0,0-.57-.75,18.08,18.08,0,0,0-8.26,4c-.16-3.81-.44-7.6-.88-11.4,0-.19-.45-.33-.94-.33s-.92.14-.95.33v.05q-.78,6.73-1,13.47h0A17.7,17.7,0,0,0,15,22.7a2.25,2.25,0,0,0-.56.72,2.1,2.1,0,0,0-.38.85,17.65,17.65,0,0,0,9.05,5.78c0,1.71,0,3.41.05,5.11L16.7,35l-4.54-.12h0a7.22,7.22,0,0,1-3.58-1.15A7,7,0,0,1,6.12,31a6.9,6.9,0,0,1-.72-3.6Z" transform="translate(-2.1 -0.17)" />
                                                    </svg>
                                                    <span class="value"><?php echo _e('Park', 'apimo'); ?></span>
                                                </li>
                                            <?php
                                            }
                                            if ($id == 51) {
                                            ?>
                                                <li class="Pro-meta">
                                                    <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 45.8 49.67">
                                                        <path d="M7.14,36.24a9.93,9.93,0,0,0,5.11,1.31l4.58-.12,6.39-.2c.12,2.89.33,5.77.62,8.66h0A119.21,119.21,0,0,0,9,47c-.16,0-.29.42-.29.91s.13.9.29.92H9a118.07,118.07,0,0,0,31.31,0c.17,0,.3-.44.3-.94s-.13-.91-.3-.94h0a118.08,118.08,0,0,0-14.06-1q.44-4.4.62-8.81a.34.34,0,0,1,.17,0h.18l8.38.27,2.09,0a10.54,10.54,0,0,0,2.38-.21,9.77,9.77,0,0,0,4.31-2.13,10,10,0,0,0,3.46-8.81,10.19,10.19,0,0,0-4.26-7,10.29,10.29,0,0,0-8.9-12.57,10.4,10.4,0,0,0-19.29,0A10.33,10.33,0,0,0,6.44,19.25a10.2,10.2,0,0,0-4.34,8,10.06,10.06,0,0,0,1.28,5.2,9.94,9.94,0,0,0,3.76,3.8ZM5.4,27.35a6.8,6.8,0,0,1,3.95-5.69,1.8,1.8,0,0,0,.89-.93,1.74,1.74,0,0,0,0-1.29v0a6.61,6.61,0,0,1,6.51-8.88A1.83,1.83,0,0,0,18,10.16a1.87,1.87,0,0,0,.72-1.06v0A6.55,6.55,0,0,1,31.39,9v.05a1.78,1.78,0,0,0,.7,1,1.83,1.83,0,0,0,1.22.35A6.56,6.56,0,0,1,39,13.13a6.63,6.63,0,0,1,.9,6.26v.05a1.76,1.76,0,0,0,0,1.24,1.66,1.66,0,0,0,.86.89,6.92,6.92,0,0,1,4,5.21,7.12,7.12,0,0,1-5.32,7.95,8,8,0,0,1-1.82.24L35.43,35,27,35.29h-.09c.08-2.47.07-4.94,0-7.41h0a18,18,0,0,0,9.11-5.71,2.36,2.36,0,0,0-.37-.88,2.45,2.45,0,0,0-.57-.75,18.08,18.08,0,0,0-8.26,4c-.16-3.81-.44-7.6-.88-11.4,0-.19-.45-.33-.94-.33s-.92.14-.95.33v.05q-.78,6.73-1,13.47h0A17.7,17.7,0,0,0,15,22.7a2.25,2.25,0,0,0-.56.72,2.1,2.1,0,0,0-.38.85,17.65,17.65,0,0,0,9.05,5.78c0,1.71,0,3.41.05,5.11L16.7,35l-4.54-.12h0a7.22,7.22,0,0,1-3.58-1.15A7,7,0,0,1,6.12,31a6.9,6.9,0,0,1-.72-3.6Z" transform="translate(-2.1 -0.17)" />
                                                    </svg>
                                                    <span class="value"><?php echo _e('Land', 'apimo'); ?></span>
                                                </li>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="apimo-other-info-properties">
            <div class="Pro-info">
                
                <?php
                $currentLanguage = get_bloginfo('language');
                $lang = explode('-',$currentLanguage)[0];
                $is_content = false;

                if(isset($metas['apimo_content'][0]) && !empty($metas['apimo_content'][0]) && (is_array($metas['apimo_content'][0]) || is_object($metas['apimo_content'][0]))){
                    foreach (unserialize($metas['apimo_content'][0]) as $language) {
                        if ($language->language == $lang) {
                            $is_content = true;
                            if($language->subtitle!='' || !empty($language->subtitle)){
                                echo '<h2 class="Pro-info-subtitle">' . nl2br($language->subtitle) . '</h2>';
                            }
                        }
                    }
                }
                 ?>
                <?php


                
                // if (sizeof(maybe_unserialize($metas['apimo_content'][0])) > 0 && $is_content): ?>
                        <!-- <h5 class="Pro-info-title"><?php //_e('Description', 'apimo'); ?></h5> -->
                 <?php 
                // endif;

                ?>
                <?php
                    if(!empty($metas) &&  isset($metas['apimo_content']) && is_array($metas['apimo_content']) && isset($metas['apimo_content'][0])) {
                        $unserialized_data = maybe_unserialize($metas['apimo_content'][0]);
                        if ($unserialized_data !== false && sizeof($unserialized_data) > 0 && $is_content): ?>
                        <h5 class="Pro-info-title"><?php _e('Description', 'apimo'); ?></h5>
                        <?php 
                        endif;
                    }
                ?>
                <?php
                // foreach (unserialize($metas['apimo_content'][0]) as $language) {
                //     if ($language->language == $lang) {
                //         echo '<p>' . nl2br(($language->comment_full!=null || !empty($language->comment_full) )?$language->comment_full:$language->comment) . '</p>';
                //     }
                // } 

                $unserialized_data = maybe_unserialize($metas['apimo_content'][0]);

                if (is_array($unserialized_data)) {
                    foreach ($unserialized_data as $language) {
                        if ($language->language == $lang) {
                            echo '<p>' . nl2br(($language->comment_full!=null || !empty($language->comment_full) )?$language->comment_full:$language->comment) . '</p>';
                        }
                    } 
                } 

                ?>
            </div>
            <!--apimo Details -->
            <div class="Pro-info Pro-general-information">
                <h5 class="Pro-info-title"><?php _e('Details', 'apimo'); ?></h5>
                <div class="details-table">

                    <?php if ($apimo_category) : ?>
                        <dl class="row">
                            <dt class="term"><?php _e('Category','apimo'); ?>:</dt>
                            <dd class="description"><?php _e($apimo_category, 'apimo'); ?></dd>

                        </dl>
                    <?php endif; ?>
                    <?php if ($subtype && $type) : ?>
                        <dl class="row">
                            <dt class="term"><?php _e('Type', 'apimo'); ?>:</dt>
                            <dd class="description"><?php _e(esc_html($type), 'apimo'); ?> / <?php _e(esc_html($subtype), 'apimo'); ?></dd>
                        </dl>
                    <?php endif; ?>

                    <?php if ($construction_years) : ?>
                        <dl class="row">
                            <dt class="term"><?php _e('Construction year', 'apimo'); ?>:</dt>
                            <dd class="description"><?php _e(esc_html($construction_years), 'apimo'); ?></dd>
                        </dl>
                    <?php endif; ?>

                    <?php if ($condition) : ?>
                        <dl class="row">
                            <dt class="term"><?php _e('Conditions', 'apimo'); ?>:</dt>
                            <dd class="description"><?php _e(esc_html($condition), 'apimo'); ?></dd>
                        </dl>
                    <?php endif; ?>

                    <?php if ($availability) : ?>
                        <dl class="row">
                            <dt class="term"><?php _e('Availability', 'apimo'); ?>:</dt>
                            <dd class="description"><?php _e(esc_html($availability), 'apimo'); ?></dd>
                        </dl>
                    <?php endif; ?>

                    <?php if ($property_standing) : ?>
                        <dl class="row">
                            <dt class="term"><?php _e('Property standing', 'apimo'); ?>:</dt>
                            <dd class="description"><?php _e(esc_html($property_standing), 'apimo'); ?></dd>
                        </dl>
                    <?php endif; ?>

                    <dl class="row">
                        <dt class="term"><?php _e('Areas', 'apimo'); ?>:</dt>
                        <dd class="description">
                            <?php
                                if (isset($metas['apimo_area_display_filter'][0]) && $metas['apimo_area_display_filter'][0]) {
                                    echo esc_html($metas['apimo_area_display_filter'][0]);
                                } else {
                                    echo 0;
                                }
                                ?> 
                                <?php
                                if (
                                    isset($metas['apimo_area_unit'][0]) &&
                                    isset($UNIT_AREA[$metas['apimo_area_unit'][0]])
                                ) {
                                    echo esc_html($UNIT_AREA[$metas['apimo_area_unit'][0]]);
                                }

                                ?>
                        </dd>
                    </dl>

                    <?php if ($flor) : ?>
                        <dl class="row">
                            <dt class="term"><?php _e('Floor', 'apimo'); ?>:</dt>
                            <dd class="description"><?php _e(esc_html($flor), 'apimo'); ?></dd>
                        </dl>
                    <?php endif; ?>

                    <dl class="row">
                        <dt class="term"><?php _e('Price', 'apimo'); ?>:</dt>
                        <dd class="description">
                            <?php if ($metas['apimo_price_hide'][0]) : ?>
                                <?php _e('Private negotiation', 'apimo'); ?>
                            <?php else : ?>
                                <?php if ($metas['apimo_price'][0]) {
                                    echo _e(esc_html(apimo_currency_format($metas['apimo_price'][0])), 'apimo');
                                } else {
                                    echo _e(esc_html(apimo_currency_format(0)), 'apimo');
                                } ?>
                            <?php endif; ?>
                        </dd>
                    </dl>

                    

                    <?php if ($metas['apimo_rooms'][0]) : ?>
                        <dl class="row">
                            <dt class="term"><?php _e('Rooms', 'apimo'); ?>:</dt>
                            <dd class="description"><?php _e(esc_html($metas['apimo_rooms'][0]), 'apimo'); ?></dd>
                        </dl>
                    <?php endif; ?>

                    <?php if ($metas['apimo_bathrooms'][0]) : ?>
                        <dl class="row">
                            <dt class="term"><?php _e('Bath', 'apimo'); ?>:</dt>
                            <dd class="description"><?php _e(esc_html($metas['apimo_bathrooms'][0]), 'apimo'); ?></dd>
                        </dl>
                    <?php endif; ?>

                    <?php
                    $unserialized_data = maybe_unserialize($metas['apimo_regulations'][0]);
                    if (is_array($unserialized_data)) {
                        foreach ($unserialized_data as $regulations) {
                            if ($regulations->type == 13) : ?>
                                <dl class="row">
                                    <dt class="term"><?php _e('APE', 'apimo'); ?>:</dt>
                                    <dd class="description"><?php _e(esc_html($regulations->value), 'apimo'); ?></dd>
                                </dl>
                            <?php endif;
                        }
                    }
                    ?>

                    <?php if ($heating_type) : ?>
                        <dl class="row">
                            <dt class="term"><?php _e('Heating type', 'apimo'); ?>:</dt>
                            <dd class="description"><?php _e(esc_html($heating_type), 'apimo'); ?></dd>
                        </dl>
                    <?php endif; ?>

                    <?php if ($heating_access) : ?>
                        <dl class="row">
                            <dt class="term"><?php _e('Heating access', 'apimo'); ?>:</dt>
                            <dd class="description"><?php _e(esc_html($heating_access), 'apimo'); ?></dd>
                        </dl>
                    <?php endif; ?>

                    <?php if ($heating_device) : ?>
                        <dl class="row">
                            <dt class="term"><?php _e('Heating device', 'apimo'); ?>:</dt>
                            <dd class="description"><?php _e(esc_html($heating_device), 'apimo'); ?></dd>
                        </dl>
                    <?php endif; ?>

                    <?php if ($water_hot_device) : ?>
                        <dl class="row">
                            <dt class="term"><?php _e('Water hot device', 'apimo'); ?>:</dt>
                            <dd class="description"><?php _e(esc_html($water_hot_device), 'apimo'); ?></dd>
                        </dl>
                    <?php endif; ?>

                    <?php if ($water_hot_access) : ?>
                        <dl class="row">
                            <dt class="term"><?php _e('Water hot access', 'apimo'); ?>:</dt>
                            <dd class="description"><?php _e(esc_html($water_hot_access), 'apimo'); ?></dd>
                        </dl>
                    <?php endif; ?>

                    <?php if ($water_waste) : ?>
                        <dl class="row">
                            <dt class="term"><?php _e('Water waste', 'apimo'); ?>:</dt>
                            <dd class="description"><?php _e(esc_html($water_waste), 'apimo'); ?></dd>
                        </dl>
                    <?php endif; ?>

                    <?php if ($subtype) : ?>
                        <dl class="row">
                            <dt class="term"><?php _e('Type', 'apimo'); ?>:</dt>
                            <dd class="description"><?php _e(esc_html($subtype), 'apimo'); ?></dd>
                        </dl>
                    <?php endif; ?>

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
                        
                        if(isset($metas['apimo_residence']) ){
                            $apimo_residence_data = $metas['apimo_residence'];
                            if ($apimo_residence_data && isset($apimo_residence_data)) {
                                foreach ($apimo_residence_data as $serialized_residence) {
                                    // Unserialize the data
                                    $residence = unserialize($serialized_residence);

                                    // Check if all properties are empty
                                    if (empty($residence->id) && empty($residence->type) && empty($residence->fees) && empty($residence->period) && empty($residence->lots)) {
                                        continue; // Skip to the next iteration if all properties are empty
                                    }

                                    // Retrieve the period description using the period ID
                                    $period_description = isset($property_period[$residence->period]) ? $property_period[$residence->period] : 'Unknown period';

                                    ?>
                                    <dl class="row">
                                        <dt class="term"><?php _e('Fees', 'apimo'); ?>:</dt>
                                        <dd class="description"><?php echo $residence->fees . " <strong> (€ / " . $period_description . ") </strong>"; ?></dd>
                                    </dl>
                                    <?php 
                                }
                            }
                        }
                        

                        ?>



                    

                </div>

            </div>
            <!--apimo location -->
            <?php 
                #location details
                if(isset($metas['apimo_property_location'])){
                    ?>
                    <div class="Pro-info Pro-general-information">
                        <h5 class="Pro-info-title"><?php _e('Location Details', 'apimo'); ?></h5>
                        <div class="details-table">
                        <?php
                            
                            $locationData = $metas['apimo_property_location'];

                            // Check if $locationData is an array
                            if (is_array($locationData)) {
                                // Loop through each serialized element
                                foreach ($locationData as $serializedLocation) {
                                    // Unserialize the data
                                    $location = unserialize($serializedLocation);
                            ?>
                                    <?php if (!empty($location['country'])): ?>
                                        <dl class="row">
                                            <dt class="term"><?php esc_html_e('Country', 'apimo'); ?>:</dt>
                                            <dd class="description"><?php echo esc_html($location['country']); ?></dd>
                                        </dl>
                                    <?php endif; ?>

                                    <?php if (is_object($location['region']) && $location['region']->name): ?>
                                        <dl class="row">
                                            <dt class="term"><?php esc_html_e('Region', 'apimo'); ?>:</dt>
                                            <dd class="description"><?php echo esc_html($location['region']->name); ?></dd>
                                        </dl>
                                    <?php endif; ?>

                                    <?php if (is_object($location['city']) && $location['city']->name): ?>
                                        <dl class="row">
                                            <dt class="term"><?php esc_html_e('City', 'apimo'); ?>:</dt>
                                            <dd class="description"><?php echo esc_html($location['city']->name); ?></dd>
                                        </dl>
                                    <?php endif; ?>

                                    <?php if (is_object($location['district']) && $location['district']->name): ?>
                                        <dl class="row">
                                            <dt class="term"><?php esc_html_e('District', 'apimo'); ?>:</dt>
                                            <dd class="description"><?php echo esc_html($location['district']->name); ?></dd>
                                        </dl>
                                    <?php endif; ?>


                                    


                                    <?php 
                                        global $iframeSrc;
                                        if ($location['latitude'] && $location['longitude']) {
                                            
                                            $span = 0.09;  
                                            
                                            $iframeSrc = "https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;t=&amp;z=16&amp;ie=UTF8&amp;&amp;spn={$span},{$span}&amp;&amp;ll={$location['latitude']},{$location['longitude']}&amp;&amp;output=embed";

                                        }

                                    ?>


                            <?php
                                }
                            }
                            ?>




                        </div>

                        <?php 
                            if($iframeSrc){
                                ?>
                                <div class="map">
                                    <h5 class="Pro-info-title"><?php _e('Location Map', 'apimo'); ?></h5>
                                    <iframe src="<?php echo $iframeSrc ?>" width="100%" height="400" frameborder="0"></iframe>
                                </div>
                                <?php 
                            }
                        ?>
                    </div>
                    <?php 
                }
            ?>

                  

            <!-- apimo_medias -->
            <?php
                if(isset($metas['apimo_medias'])){
                    $apimo_medias_data = $metas['apimo_medias'];

                    if ($apimo_medias_data && isset($apimo_medias_data) && !empty($apimo_medias_data)) {
                        // Unserialize the first element of the array to check if it's an empty array
                        $unserializedData = @unserialize($apimo_medias_data[0]);
                        if ($unserializedData !== false && is_array($unserializedData) && !empty($unserializedData)) {
                            ?>
                            <div class="Pro-info">
                                <h5 class="Pro-info-title"><?php _e('Media Details', 'apimo'); ?></h5>
                                <?php
                                if (is_array($apimo_medias_data)) {
                                    foreach ($apimo_medias_data as $media_serialized) {
                                        $media_unserialized = unserialize($media_serialized);
                                        // echo "<pre>";
                                        // print_r($media_unserialized);
                                        // echo "</pre>";

                                        if (is_array($media_unserialized)) {
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
                                                    <div class="media-container" style="position: relative; height: 400px; margin-bottom: 20px;">
                                                        <!-- Display the iframe -->
                                                        <iframe class="media-iframe" style="width: 100%; height: 100%;" src="<?php echo $embedUrl; ?>" frameborder="0" allowfullscreen></iframe>
                                                        <!-- Button with absolute positioning -->
                                                        <a href="<?php echo $media->value; ?>" target="_blank" class="media-button" style="position: absolute; top: 10px; right: 10px; z-index: 10;"><?php _e('View Video','apimo'); ?></a>
                                                    </div>
                                                    <?php
                                                } else {
                                                    echo 'Missing or empty URL.';
                                                }
                                            }
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <?php 
                        }
                    }
                }
                
            ?>

            <?php
                // foreach (maybe_unserialize($metas['apimo_regulations'][0]) as $regulations) {
                //     if ($regulations->type == 13) {
                //         $regulation_type = $regulations->value;
                //     }
                // }
                global $unserialized_data;
                $unserialized_data = maybe_unserialize($metas['apimo_regulations'][0]);
                
                // print_r($unserialized_data);die();
                global $regulation_type;
                if (is_array($unserialized_data)) {
                    foreach ($unserialized_data as $regulations) {
                        // global $regulation_type;
                        // echo $regulations->value . "<br>";
                        if ($regulations->type == 13) {
                            $regulation_type = $regulations->value;
                        }
                            
                        // $regulation_type = $regulations->value;
                    } 
                }

            
            ?>
            <!--Energy performance-->
            <?php 

                if(isset(($unserialized_data[0]))){
                    if($unserialized_data[0]->graph && $unserialized_data[0]->type == '1'){
                        ?>
                            <div class="Pro-info">
                                <h5 class="Pro-info-title"><?php _e('Energy performance', 'apimo'); ?></h5>
                                <div class="detail-section__content">
                                    <div class="energy-class">
                                        <div class="apimo-row">
                                            <?php 
                                                if(isset(($unserialized_data[0]))){
                                                    if($unserialized_data[0]->graph && $unserialized_data[0]->type == '1'){
                                                        ?>
                                                        <div class="apimo-col-12 apimo-col-lg-4">
                                                            <div class="regulation">
                                                                <img src="<?php echo $unserialized_data[0]->graph ?>" alt="graph">
                                                            </div>
                                                        </div>
                                                        <?php 
                                                    }
                                                }
                                                
                                            ?>
                                            
                                                                                     
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php 
                    }
                }
                
            ?>

             <!--apimo REGLEMENTATION -->
            <?php 
                
                if (isset($metas['apimo_regulations']) && !empty($metas['apimo_regulations'][0])) {      
                    $unserializedArray = unserialize($metas['apimo_regulations'][0]);
                    
                    
   
                    if (!empty($unserializedArray)) {
                        ?>
                            <div class="Pro-info Pro-general-information">
                                <h5 class="Pro-info-title"><?php _e('REGLEMENTATION ', 'apimo'); ?> : </h5>
                                <div class="details-table">
                                    <!--Regulementation -->
                                    <?php
                                        if (isset($metas['apimo_regulations']) && is_array($metas['apimo_regulations'])) {
                                            // Define a function to compare the presence of the 'graph' key
                                            function sortByGraph($a, $b) {
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
                                                        <dl class="row">
                                                            <dt class="term"><?php echo _e($propertyName, 'apimo'); ?>:</dt>
                                                            <dd class="description"><?php echo stripslashes(__($valueDisplay, 'apimo') . $unit); ?></dd>
                                                        </dl>


                                                        <?php
                                                    }


                                                }
                                            }
                                        }
                                        ?>

                                </div>
                            </div>
                        <?php 
                    } 
                }
            ?> 
            
            <!--Documents -->
            <?php  
                
                if (isset($metas['apimo_documents']) && is_array($metas['apimo_documents']) && !empty($metas['apimo_documents'])):
                    foreach ($metas['apimo_documents'] as $serializedDoc):
                        $doc = unserialize($serializedDoc);

                        // echo "<pre>";
                        // print_r($doc);
                        // echo "</pre>";

                        
                        if (isset($doc[0])):
                            ?>
                            <div class="Pro-info">
                                <h5 class="Pro-info-title"><?php _e('Documents', 'apimo'); ?></h5>
 
                                <?php 
                                    $docs = $metas['apimo_documents'];

                                    if (is_array($docs) && !empty($docs)):
                                        ?>
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th><?= _e('File title', 'apimo'); ?></th>
                                                        <th><?= _e('File size', 'apimo'); ?></th>
                                                        <th><?= _e('Download', 'apimo'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 

                                                        foreach ($docs as $serializedDoc):
                                                            $doc = unserialize($serializedDoc); 

                                                            if (is_array($doc) && !empty($doc)):
                                                                foreach ($doc as $singleDoc):
                                                                    if (!empty($singleDoc->name) && !empty($singleDoc->filesize) && !empty($singleDoc->download_url)):
                                                                        ?>
                                                                        <tr>
                                                                           
                                                                            <td><?= pathinfo($singleDoc->name, PATHINFO_FILENAME); ?></td>

                                                                            <td><?= $singleDoc->filesize . ' Kb'; ?></td>
                                                                            <td style="text-align: center;">
                                                                                <a href="<?= $singleDoc->download_url; ?>" target="_blank">
                                                                                    <img width="50" src="<?= plugin_dir_url(dirname(__FILE__)) . 'assets/download_icon.png'; ?>" alt="<?= __('Download', 'apimo'); ?>">
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                        <?php 
                                                                    endif;
                                                                endforeach;
                                                            endif;
                                                        endforeach;

                                                         
                                                    ?>
                                                </tbody>
                                            </table>
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
            ?>
            <?php
            $terms_of_area_service = get_terms(array('taxonomy' => array('apimo_service', 'apimo_areas'), 'hide_empty' => false));
            ?>

            <div class="Pro-info">
                <h5 class="Pro-info-title"><?php _e('Services', 'apimo'); ?></h5>
                <ul class="Pro-ex-points">
                    <?php foreach ($terms_of_area_service as $term_data) :
                    ?>

                        <?php if (in_array($term_data->term_id, $final_array)) : ?>
                            <li class="Pro-meta">
                                <svg class="include" xmlns="http://www.w3.org/2000/svg" width="12.069" height="8.799" viewBox="0 0 12.069 8.799">
                                    <g id="noun_Check_1862488" transform="translate(-14.079 -69.483)">
                                        <g id="Group_7" data-name="Group 7" transform="translate(14.079 69.483)">
                                            <path id="Path_30" data-name="Path 30" d="M43.607,69.823c1.042-1.042,2.672.544,1.585,1.585L38.67,77.977a1.18,1.18,0,0,1-1.585,0L33.823,74.67a1.121,1.121,0,0,1,1.585-1.585L37.9,75.576Z" transform="translate(-33.483 -69.483)" fill="#6a6a6a" />
                                        </g>
                                    </g>
                                </svg>
                                <span><?php echo _e(esc_html($term_data->name) , 'apimo'); ?></span>

                                
                            </li>
                        <?php else : ?>
                            <?php if (get_option('apimo_show_unavailable_service') == 1) : ?><li>
                                    <svg class="not-include" id="noun_X_2147847" xmlns="http://www.w3.org/2000/svg" width="10.478" height="10.478" viewBox="0 0 10.478 10.478">
                                        <path id="Path_31" data-name="Path 31" d="M10.139,11.551,6.605,8.019,3.072,11.551a1,1,0,0,1-1.412,0h0a1,1,0,0,1,0-1.412L5.192,6.605,1.66,3.072a1,1,0,0,1,0-1.412h0a1,1,0,0,1,1.412,0L6.605,5.192,10.139,1.66a1,1,0,0,1,1.412,0h0a1,1,0,0,1,0,1.412L8.019,6.605l3.532,3.533a1,1,0,0,1,0,1.412h0a1,1,0,0,1-1.412,0Z" transform="translate(-1.366 -1.366)" fill="#6a6a6a"></path>
                                    </svg>
                                    <span><?php echo _e(esc_html($term_data->name) , 'apimo'); ?></span>

                                </li>
                            <?php endif; ?>
                        <?php endif; ?>

                    <?php
                    endforeach;
                    ?>

                </ul>
            </div>
            <!--user details -->
            <?php 
                if(isset($apimo_archive_settings['userinfo'])){
                    if($apimo_archive_settings['userinfo'] == 'show'){
                        ?>
                        <div class="Pro-info Pro-general-information">
                            <h5 class="Pro-info-title"><?php _e('User Detail', 'apimo'); ?></h5>
                            
                            <?php
                                $property_user_data = $metas['apimo_user_data'];

                                foreach ($property_user_data as $serialized_user) {
                                    // Unserialize the data
                                    $user = unserialize($serialized_user);

                                    // Output HTML with dynamically populated user data
                                    ?>
                                    <div class="apimo_profile_picture">
                                        <div class="profile_img">
                                            <img src="<?php echo isset($user->picture) ? $user->picture : plugin_dir_url(dirname(__FILE__)) . 'assets/user_image.png' ?>" alt="Profile Picture">
                                        </div>
                                        <div class="profile_info">
                                            <div class="username">
                                                <?php echo isset($user->firstname) && isset($user->lastname) ? $user->firstname . ' ' . $user->lastname : 'N/A'; ?>
                                                <?php if (isset($user->active) && $user->active) : ?>
                                                    <img src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/verify.png' ?>" alt="Verified Icon">
                                                <?php endif; ?>
                                            </div>

                                            <div class="info">

                                                <a href="tel:<?php echo isset($user->phone) ? $user->phone : ''; ?>">
                                                    <span><?php _e('Phone', 'apimo') ?> : <?php echo isset($user->phone) ? $user->phone : 'N/A'; ?></span>
                                                </a>

                                                <a href="tel:<?php echo isset($user->mobile) ? $user->mobile : ''; ?>">
                                                    <span><?php _e('Mobile', 'apimo') ?> : <?php echo isset($user->mobile) ? $user->mobile : 'N/A'; ?></span>
                                                </a>

                                                <span><?php _e('Email','apimo') ?> : <?php echo isset($user->email) ? $user->email : 'N/A'; ?></span>

                                                
                                                <?php if(isset($user->fax)): ?>
                                                    <span><?php _e('Fax','apimo') ?> <?php echo $user->fax ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="contact-button">
                                                <?php
                                                $emailSubject = __('Interested in Property Inquiry', 'apimo');
                                                $emailBody = __('Hello, I\'m interested in this property:', 'apimo') . ' ' . get_permalink(get_the_ID());
                                                $encodedEmailBody = rawurlencode($emailBody);
                                                $encodedEmail = base64_encode(isset($user->email) ? $user->email : 'N/A');
                                                ?>
                                                <script type="text/javascript">
                                                    document.write('<a href="mailto:' + atob("<?php echo $encodedEmail; ?>") + '?subject=<?php echo rawurlencode($emailSubject); ?>&body=<?php echo $encodedEmailBody; ?>" class="button" target="_blank"><?php _e('Contact', 'apimo'); ?></a>');
                                                </script>
                                                <noscript>
                                                    <span>Email address is protected by JavaScript.</span>
                                                </noscript>
                                            </div>
                                        </div>
                                    </div>  
                                    <?php
                                }
                            ?>



                        </div>
                        <?php 
                    }
                }
            ?>

           



        </div>
        <?php
                if($city_term[0]->parent==0){
                    $city = $city_term[0]->name ;
                } else {
                    $city = $city_term[1]->name;
                }
                $args = array(
                    'post_type' => 'property',
                    'post__not_in' => array(get_the_ID()),
                    'posts_per_page' => ($apimo_archive_settings['view_1']['desktop'])*2,
                     'tax_query' => array(
                          'relation' => 'AND',
                        array(
                            'taxonomy' => 'apimo_category',
                            'field'    => 'name',
                            'terms'    => $apimo_category,
                        ),
                        array(
                            'taxonomy' => 'apimo_subtype',
                            'field'    => 'name',
                            'terms'    => $subtype,
                        ),
                        array(
                            'taxonomy' => 'city',
                            'field'    => 'name',
                            'terms'    => $city ,
                        ),
                    ),
                    'meta_query'      => array(
                   		array(
                 			'key'	   => 'apimo_price',
                 			'value'    =>  array(($metas['apimo_price'][0] - ($metas['apimo_price'][0] *0.2)) , ($metas['apimo_price'][0] + ($metas['apimo_price'][0] *0.2))),
                 			'type'     => 'numeric',
                 			'compare'  => 'between'
                              )
            		)
                );

                  $loop = new WP_Query($args);
                // echo '<pre>';
                // print_r($loop);
          if ($loop->have_posts()) {
        ?>
        <section class="Product-wrapper Grid-wrapper <?php if ($apimo_archive_settings['template'] == 'landscape') {
                                            echo 'landscape-type ';
                                        } ?> Related-pro-wrapper">
            <h2><?php _e('Other properties you might like', 'apimo'); ?></h2>
            <div class="apimo-row">

            <?php



                    while ($loop->have_posts()) {
                        $loop->the_post();
                        global $post; ?>
                        <div class="<?php
                                    echo esc_attr($grid_desktop) . ' ' . esc_attr($grid_tablet) . ' ' . esc_attr($grid_mobile);
                                    ?>">
                            <?php
                            include 'template_archive_block.php';
                            ?>
                        </div>
                <?php
                    }
                    wp_reset_query();

                ?>
            </div>
        </section>
        <?php }
        ?>
    </div>
</div>

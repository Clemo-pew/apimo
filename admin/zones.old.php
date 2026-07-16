<?php



global $apimo_dir, $apimo_url;







global $wpdb;




if (isset($_POST['run_zones_import'])) {
	
	apimo_run_zones_import();


}


$tablename = $wpdb->prefix . 'apimo_zones';



$rows =  $wpdb->get_results('SELECT * FROM ' . $tablename);// . ' WHERE hook="apimo_import_property_recurring" OR hook="apimo_fetch_property_manual" ');

//$r = $wpdb->get_results("SELECT DISTINCT meta_value FROM wp_postmeta pm, wp_posts p WHERE pm.post_id = p.ID AND p.post_type = 'property' AND pm.meta_key = 'apimo_property_location'");


$r = get_all_meta_values("apimo_property_location");


 echo '<pre>';

;

 var_dump( $r );



 echo '</pre>';

function get_all_meta_values($key) {
global $wpdb;
	$result = $wpdb->get_col( 
		$wpdb->prepare( "
			SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
			LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
			WHERE pm.meta_key = '%s' 
			AND p.post_status = 'publish'
			ORDER BY pm.meta_value", 
			$key
		) 
	);

	return $result;
}

function object_to_array($object) {
 if (is_object($object)) {
  return array_map(__FUNCTION__, get_object_vars($object));
 } else if (is_array($object)) {
  return array_map(__FUNCTION__, $object);
 } else {
  return $object;
 }
}

function apimo_run_zones_import()
{
	echo 'Run import successfully ...';


}



?>







<style>

  .dropdown {



    float: left;



    overflow: hidden;



  }







  .dropdown .dropbtn {



    cursor: pointer;



    font-size: 16px;



    border: none;



    outline: none;



    color: #2271b1;



    background-color: inherit;



    margin: 0;



    font-size: 13px;



    line-height: 1.4em;



    text-decoration: underline;



  }







  .dropdown-content {



    display: none;



    position: absolute;



    background-color: #f9f9f9;



    min-width: 160px;



    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);



    z-index: 1;



  }







  .dropdown-content a {



    float: none;



    color: black;



    padding: 12px 16px;



    text-decoration: none;



    display: block;



    text-align: left;



  }







  .dropdown-content a:hover {



    background-color: #ddd;



  }







  .show {



    display: block;



  }

</style>







<div class="apimo-dashboard">



  <div class="apimo-header">



    <div class="apimo-logo">



      <img src="<?php echo esc_url($apimo_url . '/assets/images/small-logo.svg'); ?>">





    </div>



    <div class="apimo-nav">



      <nav>



        <ul>



          <li>



            <a href="/wp-admin/admin.php?page=apimo"><?php echo _e('Settings', 'Apimo'); ?></a>



          </li>



          <li>



            <a href="/wp-admin/admin.php?page=apimo_logs"><?php echo _e('Logs', 'Apimo'); ?></a>



          </li>



          <li>



            <div class="dropdown">



              <button class="dropbtn" onclick="openDropMenu()"><?php echo _e('Documentation', 'Apimo'); ?>



                <i class="fa fa-caret-down"></i>



              </button>



              <div class="dropdown-content" id="myDropdown">



                <a href="<?php echo esc_url($apimo_url . '/doc/guida_installazione.pdf'); ?>" target="_blank">Italiano</a>



                <a href="<?php echo esc_url($apimo_url . '/doc/guide_installation.pdf'); ?>" target="_blank">Français</a>



                <a href="<?php echo esc_url($apimo_url . '/doc/installation_guide.pdf'); ?>" target="_blank">English</a>





              </div>



            </div>



          </li>



        </ul>



      </nav>



    </div>



  </div>



  <form method="post" name="run_zones_import">



    <div class="apimo-row">



      <div class="apimo-col-8">



        <div class="apimo-block">



          <div class="apimo-block-header">



            <h3>Apimo Zones</h3>



          </div>



          <div class="apimo-block-body">



            <div class="apimo-block-info">






            </div>



            <table class="wp-list-table widefat fixed striped feeds">



              <thead>



                <tr>



                  <th scope="col"><?php echo _e('ID', 'Apimo'); ?></th>


		  <th scope="col"><?php echo _e('City', 'Apimo'); ?></th>


                  <th scope="col"><?php echo _e('Zone', 'Apimo'); ?></th>



                </tr>



              </thead>



              <tbody>



                <?php



                foreach ($rows as $row) {





                ?>



                  <tr>



                    <td><?php echo esc_html($row->id); ?></td>

		    <td><?php echo esc_html($row->id); ?></td>


			<td><select name="apimo_zone" data-id="apimo_zone" data-unique-id="<?php echo esc_attr($row->zone); ?>" class="apimo_input apimo_filter_input apimo_input_select" style="width:100%">
						<option value="1">Etna Areas</option>
						<option value="2">Messina & Nebrodi Park</option>
						<option value="3">North Coast & Madonie Park</option>
						<option value="4">South Sicily</option>
						<option value="5">West Sicily</option>
			</select></td>


                  </tr>



                <?php



                  //  }



                }



                ?>



              </tbody>



              <tfoot>



                <tr>



                  <th scope="col"><?php echo _e('ID', 'Apimo'); ?></th>

		  <th scope="col"><?php echo _e('City', 'Apimo'); ?></th>

                  <th scope="col"><?php echo _e('Zone', 'Apimo'); ?></th>



                </tr>



              </tfoot>



            </table>



          </div>



        </div>



      </div>



      <div class="apimo-col-4">



        <div class="apimo-block">



          <div class="apimo-block-header">



            <h3>Manually Import</h3>



          </div>



          <div class="apimo-block-body">



            <div class="apimo-block-info apimo-api-result">



              <p>You can manually import cities from APIMO data. This will erase all your caty->zone settings. Be careful!</p>



            </div>



          </div>



          <div class="apimo-footer align-right">



            <input type="submit" class="button button-primary wt_iew_export_action_btn run_zones_import" name="run_zones_import" value="Import zones">



          </div>



        </div>



      </div>



    </div>



  </form>



</div>



<script>

  function openDropMenu() {



    document.getElementById("myDropdown").classList.toggle("show");



  }



  window.onclick = function(e) {



    if (!e.target.matches('.dropbtn')) {



      var myDropdown = document.getElementById("myDropdown");



      if (myDropdown.classList.contains('show')) {



        myDropdown.classList.remove('show');



      }



    }



  }

</script>
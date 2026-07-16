<?php

global $apimo_dir, $apimo_url;



global $wpdb;

$tablename = $wpdb->prefix . 'actionscheduler_actions';

$rows =  $wpdb->get_results('SELECT * FROM ' . $tablename . ' WHERE hook="apimo_import_property_recurring" OR hook="apimo_fetch_property_manual" ');



// echo '<pre>';

// print_r($rows);

// echo '</pre>';



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

  <form method="post">

    <div class="apimo-row">

      <div class="apimo-col-8">

        <div class="apimo-block">

          <div class="apimo-block-header">

            <h3>Scheduled Logs</h3>

          </div>

          <div class="apimo-block-body">

            <div class="apimo-block-info">

              <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p> -->

            </div>

            <table class="wp-list-table widefat fixed striped feeds">

              <thead>

                <tr>

                  <th scope="col"><?php echo _e('Action ID', 'Apimo'); ?></th>

                  <th scope="col"><?php echo _e('Hook', 'Apimo'); ?></th>

                  <th scope="col"><?php echo _e('Status', 'Apimo'); ?></th>

                  <th scope="col"><?php echo _e('Args', 'Apimo'); ?></th>

                  <th scope="col"><?php echo _e('Time', 'Apimo'); ?></th>

                </tr>

              </thead>

              <tbody>

                <?php

                foreach ($rows as $row) {

                  // if($row->hook == 'apimo_fetch_property_recurring' || $row->hook == 'apimo_fetch_property_manual'){

                ?>

                  <tr>

                    <td><?php echo esc_html($row->action_id); ?></td>

                    <td><?php echo esc_html($row->hook); ?></td>

                    <td><?php echo esc_html($row->status); ?></td>

                    <td><?php echo esc_html($row->args); ?></td>

                    <td><?php echo esc_html($row->scheduled_date_local); ?></td>

                  </tr>

                <?php

                  //  }

                }

                ?>

              </tbody>

              <tfoot>

                <tr>

                  <th scope="col"><?php echo _e('Action ID', 'Apimo'); ?></th>

                  <th scope="col"><?php echo _e('Hook', 'Apimo'); ?></th>

                  <th scope="col"><?php echo _e('Status', 'Apimo'); ?></th>

                  <th scope="col"><?php echo _e('Args', 'Apimo'); ?></th>

                  <th scope="col"><?php echo _e('Time', 'Apimo'); ?></th>

                </tr>

              </tfoot>

            </table>

          </div>

        </div>

      </div>

      <div class="apimo-col-4">

        <div class="apimo-block">

          <div class="apimo-block-header">

            <h3>Manually Run</h3>

          </div>

          <div class="apimo-block-body">

            <div class="apimo-block-info apimo-api-result">

              <p>You can manually run the properties import from APIMO webservices.</p>

            </div>

          </div>

          <div class="apimo-footer align-right">

            <input type="button" class="button button-primary wt_iew_export_action_btn run_menual_scheduler" name="run_scheduler" value="Run Scheduler">

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
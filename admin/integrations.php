<?php
global $apimo_dir, $apimo_url;
$recaptcha_info = get_option('apimo_recaptcha_info', array());
function is_recaptcha_enabled() {
    // Check if reCAPTCHA script is enqueued
    if (wp_script_is('google-recaptcha', 'enqueued') || wp_script_is('recaptcha-api', 'enqueued')) {
        return true;
    }

    // Check if reCAPTCHA keys are present in the options table
    $site_key = get_option('recaptcha_site_key');
    $secret_key = get_option('recaptcha_secret_key');

    if (!empty($site_key) && !empty($secret_key)) {
        return true;
    }

    // Check if reCAPTCHA script is present in the footer
    ob_start();
    wp_footer();
    $footer_output = ob_get_clean();

    if (strpos($footer_output, 'recaptcha/api.js') !== false) {
        return true;
    }

    // Check if reCAPTCHA script is present in the header
    ob_start();
    wp_head();
    $header_output = ob_get_clean();

    if (strpos($header_output, 'recaptcha/api.js') !== false) {
        return true;
    }

    

    return false;
}


// Handle form submissions
if (isset($_POST['activate_recaptcha'])) {
    $recaptcha_info = get_option('apimo_recaptcha_info', array());
    $recaptcha_info['integration_recaptcha'] = true;
    update_option('apimo_recaptcha_info', $recaptcha_info);
    echo '<div class="notice notice-success"><p>reCAPTCHA integration activated successfully!</p></div>';
}
if (isset($_POST['desactivate_recaptcha'])) {
    $recaptcha_info = get_option('apimo_recaptcha_info', array());
    $recaptcha_info['integration_recaptcha'] = false;
    update_option('apimo_recaptcha_info', $recaptcha_info);
    echo '<div class="notice notice-warning"><p>reCAPTCHA integration Desactivated successfully!</p></div>';
}

if (isset($_POST['save_recaptcha'])) {
    if (isset($_POST['site_key']) && isset($_POST['secret_key'])) {
        $recaptcha_info = get_option('apimo_recaptcha_info', array());
        $recaptcha_info['site_key'] = sanitize_text_field($_POST['site_key']);
        $recaptcha_info['secret_key'] = sanitize_text_field($_POST['secret_key']);
        $recaptcha_info['integration_recaptcha'] = true;
        update_option('apimo_recaptcha_info', $recaptcha_info);
        echo '<div class="notice notice-success"><p>reCAPTCHA settings saved successfully!</p></div>';
    }
}

// Get existing values
$recaptcha_info = get_option('apimo_recaptcha_info', array());
$is_activated = isset($recaptcha_info['integration_recaptcha']) ? $recaptcha_info['integration_recaptcha'] : false;
$site_key = isset($recaptcha_info['site_key']) ? $recaptcha_info['site_key'] : '';
$secret_key = isset($recaptcha_info['secret_key']) ? $recaptcha_info['secret_key'] : '';
?>

<!-- Your existing style code here -->
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

  <style>
/* Add these styles to your existing CSS */
.integration-card {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  border: 1px solid #ddd;
  padding: 20px;
  margin-bottom: 20px;
  border-radius: 4px;
  background: #fff;
}

.integration-content {
  flex: 1;
}

.status-badge {
  display: inline-flex;
  align-items: center;
  padding: 6px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 500;
  margin-bottom: 15px;
}

.status-badge.active {
  background-color: #ebf7ed;
  color: #0a5921;
  border: 1px solid #b6dfbd;
}

.status-badge.inactive {
  background-color: #fff4f4;
  color: #c53030;
  border: 1px solid #feb2b2;
}

.status-badge::before {
  content: "";
  display: inline-block;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  margin-right: 8px;
}

.status-badge.active::before {
  background-color: #38a169;
}

.status-badge.inactive::before {
  background-color: #e53e3e;
}

.button-danger {
  background: #dc3545 !important;
  border-color: #dc3545 !important;
  color: #fff !important;
}

.button-danger:hover {
  background: #c82333 !important;
  border-color: #bd2130 !important;
}
</style>

<div class="apimo-dashboard">
  <!-- Your existing header code here -->
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
    
  <!-- Integration Cards -->
  <div class="apimo-row">
      <div class="apimo-col-12">
          <div class="apimo-block">
              <div class="apimo-block-header">
                  <h3><?php _e('Available Integrations', 'apimo'); ?></h3>
              </div>
              <div class="apimo-block-body">
                  <div class="apimo-block-info">
                      <div class="integration-card">
                          <div class="integration-content">
                              <div style="margin-bottom: 10px;">

                                  <?php 
                              
                                  if (empty($recaptcha_info['site_key']) && empty($recaptcha_info['secret_key'])): ?>
                                    <?php if (is_recaptcha_enabled()): ?>
                                        <span class="status-badge active">
                                            <?php _e('reCAPTCHA Detected', 'apimo'); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="status-badge inactive">
                                            <?php _e('reCAPTCHA Not Detected', 'apimo'); ?>
                                        </span>
                                    <?php endif; ?>
                                  <?php endif; ?>
                              </div>
                              <div class="notice notice-warning">
                                  <p><?php _e('Please use reCAPTCHA version 3', 'apimo'); ?></p>
                              </div>

                              <h4><?php _e('Google reCAPTCHA Integration', 'apimo'); ?></h4>
                              <p style="margin: 10px 0 15px;">
                                  <?php _e('Protect your forms from spam and abuse with Google reCAPTCHA integration.', 'apimo'); ?>
                              </p>
                              
                              
                              <?php if (!$is_activated): ?>
                                  <form method="post">
                                      <input type="submit" 
                                          name="activate_recaptcha" 
                                          class="button button-primary" 
                                          value="<?php _e('Activate Integration', 'apimo'); ?>">
                                  </form>
                              <?php else: ?>
                                  <form method="post">
                                      <input type="submit" 
                                          name="desactivate_recaptcha" 
                                          class="button button-danger" 
                                          value="<?php _e('Deactivate Integration', 'apimo'); ?>">
                                  </form>
                              <?php endif; ?>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <!-- reCAPTCHA Configuration Section (shown only when activated) -->
  <?php if ($is_activated): ?>
  <form method="post">
      <div class="apimo-row">
          <div class="apimo-col-12">
              <div class="apimo-block">
                  <div class="apimo-block-header">
                      <h3><?php _e('reCAPTCHA Configuration', 'apimo'); ?> (v3)</h3>
                  </div>
                  <div class="apimo-block-body">
                      <div class="apimo-block-info">
                          <?php if (empty($recaptcha_info['site_key']) && empty($recaptcha_info['secret_key'])) : ?>
                              <div class="notice notice-warning">
                                  <p><?php _e('Please configure your reCAPTCHA keys below to complete the setup.', 'apimo'); ?></p>
                              </div>
                              <p><?php _e('To complete the reCAPTCHA setup:', 'apimo'); ?></p>
                              <ol>
                                  <li><?php _e('Go to the', 'apimo'); ?> <a href="https://www.google.com/recaptcha/admin" target="_blank"><?php _e('Google reCAPTCHA Admin Console', 'apimo'); ?></a></li>
                                  <li><?php _e('Register your site and get your Site Key and Secret Key', 'apimo'); ?></li>
                                  <li><?php _e('Enter the keys below to activate reCAPTCHA', 'apimo'); ?></li>
                              </ol>
                          <?php else: ?>
                              <div class="notice notice-success">
                                  <p><?php _e('reCAPTCHA is configured properly.', 'apimo'); ?></p>
                              </div>
                          <?php endif; ?>
                          
                          <table class="form-table">
                              <tr>
                                  <th scope="row">
                                      <label for="site_key"><?php _e('Site Key', 'apimo'); ?></label>
                                  </th>
                                  <td>
                                      <input type="text" 
                                            name="site_key" 
                                            id="site_key" 
                                            class="regular-text" 
                                            value="<?php echo esc_attr($site_key); ?>"
                                            required>
                                  </td>
                              </tr>
                              <tr>
                                  <th scope="row">
                                      <label for="secret_key"><?php _e('Secret Key', 'apimo'); ?></label>
                                  </th>
                                  <td>
                                      <input type="text" 
                                            name="secret_key" 
                                            id="secret_key" 
                                            class="regular-text" 
                                            value="<?php echo esc_attr($secret_key); ?>"
                                            required>
                                  </td>
                              </tr>
                          </table>
                          <p class="submit">
                              <input type="submit" 
                                    name="save_recaptcha" 
                                    class="button button-primary" 
                                    value="<?php _e('Save Configuration', 'apimo'); ?>">
                          </p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </form>
  <?php endif; ?>


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
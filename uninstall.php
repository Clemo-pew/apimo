<?php 

class ApimoUninstall {
    public function __construct() {
        // Ensure this script is only executed during plugin uninstallation.
        if (!defined('WP_UNINSTALL_PLUGIN')) {
            exit;
        }

        // Remove plugin options.
        $this->removeOptions();

        // Remove custom taxonomy terms.
        $this->removeTerms();

       

        // Remove custom post types and related data.
        $this->removeProperties();

         //Remove media : 
        $this->removeMedia();

        

        //Remove Custom tables
        $this->removeCustomTables();


        // Display uninstallation notice.
        $this->displayUninstallNotice();

    }

    private function removeOptions() {
    
        global $wpdb;

        // Use the $wpdb->prefix to ensure compatibility with different WordPress installations
        $table_name = $wpdb->prefix . 'options';

        // SQL query to delete options based on patterns
        $sql = "DELETE FROM $table_name WHERE option_name LIKE '%apimo%' OR option_name LIKE '%ActionScheduler%' OR option_name LIKE 'action_scheduler%' OR option_name LIKE '%agencyIDCounts%' OR option_name LIKE '%providerIDCounts%';";

        // Execute the query
        $wpdb->query($sql);

    }

    private function removeTerms() {
        $taxonomies_to_remove = array(
            'apimo_areas',
            'apimo_property_standing',
            'apimo_property_condition',
            'apimo_water_hot_device',
            'apimo_water_hot_access',
            'apimo_water_waste',
            'apimo_heating_type',
            'apimo_heating_access',
            'apimo_heating_device',
            'apimo_floor',
            'apimo_property_building',
            'apimo_construction',
            'apimo_subtype',
            'apimo_type',
            'apimo_availability',
            'apimo_orientation',
            'apimo_service',
            'apimo_category',
            'apimo_sub_category',
            'country',
            'region',
            'city',
            'district',
            'repository_tags',
            'customised_tags',
        );

        foreach ($taxonomies_to_remove as $taxonomy) {
            $terms = get_terms(array('taxonomy' => $taxonomy, 'hide_empty' => false));
            
            foreach ($terms as $term) {
                wp_delete_term($term->term_id, $taxonomy);
            }
        }
    }

    private function removeProperties() {

        global $wpdb;

        // Define the post type and any additional conditions if needed
        $post_type = 'property';

        // Construct the SQL query to delete posts and their post metadata
        $sql = $wpdb->prepare(
            "DELETE posts, postmeta
            FROM {$wpdb->posts} AS posts
            LEFT JOIN {$wpdb->postmeta} AS postmeta ON posts.ID = postmeta.post_id
            WHERE posts.post_type = %s",
            $post_type
        );

        // Execute the SQL query
        $wpdb->query($sql);

    }

    private function removeCustomTables() {
        // Drop custom database tables.
        global $wpdb;

        $tables_to_remove = array(
            'actionscheduler_actions',
            'actionscheduler_claims',
            'actionscheduler_groups',
            'actionscheduler_logs'
        );

        foreach ($tables_to_remove as $table_name) {
            $table_name = $wpdb->prefix . $table_name;
            $wpdb->query("DROP TABLE IF EXISTS $table_name");
        }
    }

    private function removeMedia() {
        global $wpdb;

        // Query to find all attachment IDs with the 'apimo_image_id' meta key
        $sql = "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'apimo_image_id'";
        $images = $wpdb->get_col($sql);

        // Delete each image found
        foreach ($images as $image_id) {
            wp_delete_attachment($image_id, true);
        }
    }
   
    


    private function displayUninstallNotice() {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-success is-dismissible">
                <p>Your plugin has been uninstalled completely.</p>
            </div>';
        });
    }
}

new ApimoUninstall();

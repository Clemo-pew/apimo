<?php
// Load WordPress environment
//require_once( dirname( __FILE__ ) . '/wp-load.php' );

// Make sure the user is logged in
if ( ! is_user_logged_in() ) {
    wp_die( 'You must be logged in to view this page.' );
}

// Check if the user has submitted the form
if ( isset( $_POST['save_changes'] ) && isset( $_POST['term_group'] ) ) {
    // Check nonce for security
    if ( ! isset( $_POST['edit_terms_nonce'] ) || ! wp_verify_nonce( $_POST['edit_terms_nonce'], 'edit_terms' ) ) {
        wp_die( 'Nonce verification failed.' );
    }

    // Access the global $wpdb object to interact with the WordPress database
    global $wpdb;

    // Loop through all terms and update term_group values
    foreach ( $_POST['term_group'] as $term_id => $term_group ) {
        // Ensure the term_group value is a number between 0 and 5
        $term_group = intval( $term_group );
        if ( $term_group < 0 ) {
            $term_group = 0;
        }
        if ( $term_group > 5 ) {
            $term_group = 5;
        }

        // Update the term_group value in wp_terms table
        $wpdb->update(
            $wpdb->terms, // Table name
            array( 'term_group' => $term_group ), // Data to update
            array( 'term_id' => $term_id ), // Where condition
            array( '%d' ), // Format for term_group
            array( '%d' )  // Format for term_id
        );
    }

    echo '<p>Changes saved successfully!</p>';
}

// Fetch all terms from the wp_terms table
global $wpdb;
$terms = $wpdb->get_results( "SELECT term_id, name, term_group FROM {$wpdb->terms}" );
?>

<h2>Edit city zones</h2>
<form method="POST">
    <?php wp_nonce_field( 'edit_terms', 'edit_terms_nonce' ); // Add nonce for security ?>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>City</th>
                <th>Zone (0-5)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop through all terms and display them in the form
            foreach ( $terms as $term ) {
                ?>
                <tr>
                    <td><?php echo esc_html( $term->term_id ); ?></td>
                    <td><?php echo esc_html( $term->name ); ?></td>
                    <td>
                        <select name="term_group[<?php echo esc_attr( $term->term_id ); ?>]">
			    <option value="0" <?php selected( $term->term_group, 0 ); ?>>No Group (0)</option>
                            <option value="1" <?php selected( $term->term_group, 1 ); ?>>Etna Areas</option>
                            <option value="2" <?php selected( $term->term_group, 2 ); ?>>Messina & Nebrodi Park</option>
                            <option value="3" <?php selected( $term->term_group, 3 ); ?>>North Coast & Madonie Park</option>
                            <option value="4" <?php selected( $term->term_group, 4 ); ?>>South Sicily</option>
                            <option value="5" <?php selected( $term->term_group, 5 ); ?>>West Sicily</option>
                        </select>
                    </td>                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <br>
    <input type="submit" name="save_changes" value="Save Changes" class="button button-primary" />
</form>





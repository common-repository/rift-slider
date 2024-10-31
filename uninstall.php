<?php

if (!current_user_can('activate_plugins'))
    return;
check_admin_referer('bulk-plugins');

if (!defined('WP_UNINSTALL_PLUGIN'))
    exit();

global $wpdb;

//Delete the custom post types
$pst_sql = "DELETE p, tr, pm
            FROM $wpdb->posts p
            LEFT JOIN $wpdb->term_relationships tr ON (p.ID = tr.object_id)
            LEFT JOIN $wpdb->postmeta pm ON (p.ID = pm.post_id)
            WHERE p.post_type = 'rift_slide';";

$wpdb->query($pst_sql);

//Delete the custom taxonomy
$tax_sql = "DELETE tt, tr, t
            FROM $wpdb->term_taxonomy tt
            LEFT JOIN $wpdb->term_relationships tr ON (tt.term_taxonomy_id = tr.term_taxonomy_id)
            LEFT JOIN $wpdb->terms t ON (tt.term_id = t.term_id)
            WHERE tt.taxonomy = 'carousel';";

$wpdb->query($tax_sql);

// Delete the options
$sql = "DELETE FROM $wpdb->options WHERE option_name LIKE '_synth%';";

$wpdb->query($sql);
?>

<?php
/**
 * Alter author archive page to include co-created posts 
 *
 * @package Bonne-Ambiance
 */

add_action( 'pre_get_posts', function($query) {
    if ( !is_admin() && $query->is_main_query() && $query->is_author() ) {
        $author = get_queried_object();
        $author_id = $author->ID;
        // Use custom filter to catch author post and coauthor post 
        add_filter('posts_where', function($where) use ($author_id) {
            global $wpdb;
            
            $where = preg_replace(
                "/AND \({$wpdb->posts}\.post_author = {$author_id}\)/",
                "AND ({$wpdb->posts}.post_author = {$author_id} 
                OR {$wpdb->posts}.ID IN (
                    SELECT post_id 
                    FROM {$wpdb->postmeta} 
                    WHERE meta_key = 'co_author' 
                    AND meta_value LIKE '%s:" . strlen($author_id) . ":\"" . $author_id . "\";%'
                ))",
                $where
            );
            
            return $where;
        });
        
    }
});

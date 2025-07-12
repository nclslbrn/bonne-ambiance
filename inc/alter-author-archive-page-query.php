<?php
/**
 * Alter author archive page to include co-created posts 
 *
 * @package Bonne-Ambiance
 */
/*
add_action( 'pre_get_posts', function($query) {
    if ( !is_admin() && $query->is_main_query() ) {
        if ( $query->is_author() ) {
            $author = get_queried_object();

            $query->set( 'meta_query', array(
                'relation' => 'OR',
                array(
                    'key'     => 'co_author',
                    'value'   => $author->ID,
                    //'type'    => 'numeric',
                    'compare' => 'LIKE' 
                ) 
            ) );
            echo '<pre>';
            print_r($query);
            echo '</pre>';
            // die();
        }
    }
});
*/


// Version optimisée recommandée
add_action( 'pre_get_posts', function($query) {
    if ( !is_admin() && $query->is_main_query() && $query->is_author() ) {
        $author = get_queried_object();
        $author_id = $author->ID;
        
        // Utiliser posts_where directement pour plus de contrôle
        add_filter('posts_where', function($where) use ($author_id) {
            global $wpdb;
            
            // Remplacer la condition d'auteur par défaut par une condition étendue
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

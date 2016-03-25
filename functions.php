<?php
// Two versions.
// 1. Auto Assign Before Publishing (only working for one CPT so far)
// 2. Auto Assign After Publishing (implemented)
?>


<?php
// 1. Auto Assign Before Publishing

// Add categories and tags automatically to every post Snippet URL: http://www.wpcustoms.net/snippets/add-categories-tags-automatically-every-post
function wpc_update_post_terms( $post_id ) 
{  
 if ( $parent = wp_is_post_revision( $post_id ) )  
        $post_id = $parent;  
    $post = get_post( $post_id );  
    if ( $post->post_type != 'cpt-00-01' )  
        return;   
// add a category  
    $categories = wp_get_post_categories( $post_id );  
// make sure these category names already exists. They are not created automatically.  
    $newcat1    = get_term_by( 'slug', 'cat-00-01', 'category' );  
    array_push( $categories, $newcat1->term_id );  
    wp_set_post_categories( $post_id, $categories );  
}  

add_action( 'wp_insert_post', 'wpc_update_post_terms' );  
?>


<?php
// 2. Auto Assign After Publishing

function add_wikipedia_category_automatically($post_ID) {
    global $wpdb;
    if(!has_term('','category',$post_ID)){
        $category = get_term_by( 'slug', 'cat-00-02', 'category' );
        $cat = array($category->term_id);
        wp_set_object_terms($post_ID, $cat, 'category');
    }
}
add_action('publish_cpt-00-002', 'add_wikipedia_category_automatically');
?>
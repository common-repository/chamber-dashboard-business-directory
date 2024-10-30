<?php
function cdash_block_category( $categories, $post ) {
    return array_merge(
      $categories,
      array(
        array(
          'slug' => 'cd-blocks',
          'title' => __( 'Chamber Dashboard Blocks', 'cdash' ),
        ),
      )
    );
  }
  add_filter( 'block_categories_all', 'cdash_block_category', 10, 2);

  //add custom css in the in the editor
  function cdash_block_editor_css(){
    cdash_enqueue_styles();
    wp_enqueue_style(
        'cdash_bd_editor_styles',
        plugins_url( './css/cdash_block_editor.css', dirname(__FILE__) ),
        array()
     );
  }
  add_action( 'enqueue_block_editor_assets', 'cdash_block_editor_css' );

  //add search block css in the in the editor
  function cdash_search_block_editor_css(){
    //cdash_enqueue_styles();
    wp_enqueue_style(
        'cdash_search_block_editor_styles',
        plugins_url( './css/search_block.css', dirname(__FILE__) ),
        array()
     );
  }
?>
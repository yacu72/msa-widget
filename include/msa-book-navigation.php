<?php

function msa_book_show_children($post) {
    if ($post->post_parent) {
      $post_parent = get_post($post->post_parent);
      ?>
      <ul>
      <li><a href="<?php echo get_permalink($post->post_parent); ?>"><?php echo $post_parent->post_title; ?></a>
      <ul>
      <?php 
        wp_list_pages(array(
           'post_type' => 'book',
           'sort_column' => 'menu_order',
           'child_of' => $post->post_parent,
           'title_li' => null
        ));
       ?>
      </ul></li></ul><?php
    } else {
      ?><ul>
      <ul>
      <li><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a>
      <ul>
      <?php 
        wp_list_pages(array(
           'post_type' => 'book',
           'sort_column' => 'menu_order',
           'child_of' => $post->ID,
           'title_li' => null 
        ));
       ?>
      </ul></li></ul><?php
    }
}
<?php
namespace VendorName\PluginName;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Helpers extends Plugin {

  /**
    * Display a notice/message in WP Admin
    *
    * @param string $msg The message to display.
    * @param string $type The type of notice. Valid values:
    *    error, warning, success, info
    * @param bool $is_dismissible Specify whether or not the user may dismiss
    *    the notice.
    * @since 2.0.0
    */
  public static function show_notice( $msg, $type = 'error', $is_dismissible = false ) {

    add_action( 'admin_notices', function() use (&$msg, &$type, &$is_dismissible) {

      $class = 'notice notice-' . $type . ( $is_dismissible ? ' is-dismissible' : '' );
      printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $msg );

    });

  }

  /**
    * Merges two arrays, eliminating duplicates
    *
    * array_merge_recursive_distinct does not change the datatypes of the values in the arrays.
    * Matching keys' values in the second array overwrite those in the first array, as is the
    * case with array_merge().
    *
    * @param array $array1
    * @param array $array2
    * @return array
    * @author Daniel <daniel (at) danielsmedegaardbuus (dot) dk>
    * @author Gabriel Sobrinho <gabriel (dot) sobrinho (at) gmail (dot) com>
    * @see http://php.net/manual/en/function.array-merge-recursive.php#92195 Source
    */
  private function array_merge_recursive_distinct( array &$array1, array &$array2 ) {

    $merged = $array1;

    foreach ( $array2 as $key => &$value )
    {
      if ( is_array ( $value ) && isset ( $merged [$key] ) && is_array ( $merged [$key] ) ) {
        $merged [$key] = self::array_merge_recursive_distinct ( $merged [$key], $value );
      } else {
        $merged [$key] = $value;
      }
    }

    return $merged;

  }

  /**
    * Get the slug of the current page/post
    *
    * Return the slug of the current page/post.
    *   Example: http://mysite.com/sample-page/test-page would return: test-page
    *
    * @param int $post_id (optional) Specify the post ID to retrieve parent slug for,
    *   else $post global is used instead
    * @return string The slug of the specified/current post
    */
  public static function get_page_slug($post_id = null) {
      global $post;

      $_slug = $post_id ? get_post($post_id)->post_name : $post->post_name;

      if(is_front_page()) {
          $_slug = 'front';
      } else if(is_search()) {
          $_slug = 'search';
      } else if(is_archive()) {
          $_slug = 'archive';
      } else if(is_single()) {
          $_slug = 'single';
      }

      return $_slug;
  }

  /**
    * Get the slug of the parent post (if any)
    *
    * Return the slug of the parent page/post.
    *   Example: http://mysite.com/sample-page/test-page would return: sample-page
    *
    * @param bool $include_self_as_parent_if_root (optional) Should we return the parent
    *   slug if the post *is* the parent? This can be useful if you want to apply
    *   style/logic to child pages as well as the parent
    * @param int $post_id (optional) Specify the post ID to retrieve parent slug for,
    *   else $post global is used instead
    * @return string The parent slug of the specified post, if availaable
    */
  public static function get_parent_slug($include_self_as_parent_if_root = false, $post_id = null) {
      global $post;
      $post_id = $post_id ? $post_id : $post->ID;

      if (is_page()) {
          if(get_post($post_id)->post_parent) {
              @$parent = end(get_post_ancestors($post_id));
          } else {
              $parent = $post->ID;
          }
          $post_data = get_post($parent, ARRAY_A);
          if($include_self_as_parent_if_root || $post_data['post_name'] != self::get_page_slug($post_id)) return $post_data['post_name'];
      }
      return array();
  }

  /**
    * Returns the categories of the current post
    *
    * Returns the categories of the current post, either as labels or as slugs.
    *
    * @param bool $as_slugs (optional) Returns array of category slugs rather than
    *   category labels
    * @param int $post_id (optional) Specify the post ID to retrieve categories for,
    *   else $post global is used instead
    * @return array
    */
  public static function get_post_categories($as_slugs = false, $post_id = null) {
      global $post;
      $return = array();

      @$post_id = $post_id ? $post_id : $post->ID;
      if(!$post_id) return $return;

      $categories = get_the_category($post_id);
      if(!$categories) return $return;

      foreach($categories as $cat) {
        $return[] = $as_slugs ? $cat->slug : $cat->name;
      }

      return $return;
  }

}
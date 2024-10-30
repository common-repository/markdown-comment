<?php
/**
 * Plugin Name: Markdown Comment
 * Plugin URI: https://wordpress.org/plugins/markdown-comment
 * Description: Adds the ability to use Markdown formatting in comment.
 * Author: Wow-Company
 * Version: 1.0
 * Author URI: https://wow-estore.com/
 * Domain Path: /languages
 * Requires PHP: 7.4
 * Text Domain: markdown-comment
 * License: GPLv2 or later
 *
 * @author Wow-Company
 */

defined( 'ABSPATH' ) || exit;

function markdown_comment_converter( $comment_text, $comment = null ) {
	if(!class_exists( 'Parsedown')) {
		include_once plugin_dir_path( __FILE__ ) . 'inc/parsedown.php';
	}

	$parse_markdown = new Parsedown();
	$parse_markdown->setSafeMode( true );

	$comment_text = $parse_markdown->text( $comment_text );

	return $comment_text;
}

add_filter( 'comment_text', 'markdown_comment_converter', 5, 2 );


function markdown_comment_text( $field ) {
	$notice = '<p><small class="markdown-comment-notice">' . esc_html__( 'You can use the Markdown in the comment form.',
			'markdown-comment' ) . '</small></p>';

	return $field . $notice;
}

add_filter( 'comment_form_field_comment', 'markdown_comment_text' );


add_action( 'init', 'markdown_comment_init' );
function markdown_comment_init() {
	load_plugin_textdomain( 'markdown-comment', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}


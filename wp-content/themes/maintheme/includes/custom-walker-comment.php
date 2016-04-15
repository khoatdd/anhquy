<?php
class mechanic_custom_walker_comment extends Walker_Comment {
    var $tree_type = 'comment';
    var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

    // constructor – wrapper for the comments list
    function __construct() { ?>

        <div id="comments-list">

    <?php }

    // start_lvl – wrapper for child comments list
function start_lvl( &$output, $depth = 0, $args = array() ) {
    $GLOBALS['comment_depth'] = $depth + 1; ?>

    <div class="child-comment">

<?php }

    // end_lvl – closing wrapper for child comments list
function end_lvl( &$output, $depth = 0, $args = array() ) {
    $GLOBALS['comment_depth'] = $depth + 1; ?>

    </div>

<?php }

    // start_el – HTML for comment template
function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
    $depth++;
    $GLOBALS['comment_depth'] = $depth;
    $GLOBALS['comment'] = $comment;
    $parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' );

    if ( 'article' == $args['style'] ) {
        $tag = 'article';
        $add_below = 'comment';
    } else {
        $tag = 'article';
        $add_below = 'comment';
    } ?>

    <div id="comment-<?php comment_ID() ?>" class="media">
        <div class="pull-left">
            <?php echo ( $args['avatar_size'] != 0 ? get_avatar( $comment, $args['avatar_size'] ) :'' ); ?>
            <strong></strong>
        </div> <!--.pull-left-->
        <div class="media-body">
            <div class="well">
                <div class="media-heading">
                    <strong><?php comment_author(); ?></strong>&nbsp; <small><?php comment_date('d-m-Y') ?> at <?php comment_time('g:i:s A') ?></small>
                    <?php echo get_comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                </div> <!--.media-heading-->
                <?php if ($comment->comment_approved == '0') : ?>
                    <p class="comment-meta-item">Your comment is awaiting moderation.</p>
                <?php endif; ?>
                <p><?php comment_text() ?></p>
            </div> <!--.well-->
<?php }

    // end_el – closing HTML for comment template
function end_el(&$output, $comment, $depth = 0, $args = array() ) { ?>
    </div> <!--.media-body-->
    </div>

<?php }

    // destructor – closing wrapper for the comments list
    function __destruct() { ?>

        </div> <!--#comments-list-->

    <?php }

}
?>
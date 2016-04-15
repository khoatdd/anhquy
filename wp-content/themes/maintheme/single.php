<?php get_header(); ?>
<section id="title" class="emerald">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1><?php the_title(); ?></h1>
                <!--<p>Pellentesque habitant morbi tristique senectus et netus et malesuada</p>-->
            </div>
            <div class="col-sm-6">
                <ul class="breadcrumb pull-right">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="#">Pages</a></li>
                    <li class="active">Blog Item</li>
                </ul>
            </div>
        </div>
    </div>
</section><!--/#title-->
<section id="blog" class="container">
    <div class="row">
        <aside class="col-sm-4 col-sm-push-8">
            <div class="widget search">
                <form role="form">
                    <div class="input-group">
                        <input type="text" class="form-control" autocomplete="off" placeholder="Search">
                            <span class="input-group-btn">
                                <button class="btn btn-danger" type="button"><i class="icon-search"></i></button>
                            </span>
                    </div>
                </form>
            </div><!--/.search-->

            <div class="widget ads">
                <div class="row">
                    <div class="col-xs-6">
                        <a href="#"><img class="img-responsive img-rounded" src="images/ads/ad1.png" alt=""></a>
                    </div>

                    <div class="col-xs-6">
                        <a href="#"><img class="img-responsive img-rounded" src="images/ads/ad2.png" alt=""></a>
                    </div>
                </div>
                <p></p>
                <div class="row">
                    <div class="col-xs-6">
                        <a href="#"><img class="img-responsive img-rounded" src="images/ads/ad3.png" alt=""></a>
                    </div>

                    <div class="col-xs-6">
                        <a href="#"><img class="img-responsive img-rounded" src="images/ads/ad4.png" alt=""></a>
                    </div>
                </div>
            </div><!--/.ads-->

            <div class="widget categories">
                <h3>Blog Categories</h3>
                <div class="row">
                    <div class="col-sm-6">
                        <ul class="arrow">
                            <li><a href="#">Development</a></li>
                            <li><a href="#">Design</a></li>
                            <li><a href="#">Updates</a></li>
                            <li><a href="#">Tutorial</a></li>
                            <li><a href="#">News</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="arrow">
                            <li><a href="#">Joomla</a></li>
                            <li><a href="#">Wordpress</a></li>
                            <li><a href="#">Drupal</a></li>
                            <li><a href="#">Magento</a></li>
                            <li><a href="#">Bootstrap</a></li>
                        </ul>
                    </div>
                </div>
            </div><!--/.categories-->
            <div class="widget tags">
                <h3>Tag Cloud</h3>
                <ul class="tag-cloud">
                    <li><a class="btn btn-xs btn-primary" href="#">CSS3</a></li>
                    <li><a class="btn btn-xs btn-primary" href="#">HTML5</a></li>
                    <li><a class="btn btn-xs btn-primary" href="#">WordPress</a></li>
                    <li><a class="btn btn-xs btn-primary" href="#">Joomla</a></li>
                    <li><a class="btn btn-xs btn-primary" href="#">Drupal</a></li>
                    <li><a class="btn btn-xs btn-primary" href="#">Bootstrap</a></li>
                    <li><a class="btn btn-xs btn-primary" href="#">jQuery</a></li>
                    <li><a class="btn btn-xs btn-primary" href="#">Tutorial</a></li>
                    <li><a class="btn btn-xs btn-primary" href="#">Update</a></li>
                </ul>
            </div><!--/.tags-->

            <div class="widget facebook-fanpage">
                <h3>Facebook Fanpage</h3>
                <div class="widget-content">
                    <div class="fb-like-box" data-href="https://www.facebook.com/shapebootstrap" data-width="292"
                         data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
                </div>
            </div>
        </aside>
        <div class="col-sm-8 col-sm-pull-4">
            <div class="blog">
                <div class="blog-item">
                    <?php
                    // Start the loop.
                    while (have_posts()) :
                    the_post();
                    ?>
                    <img class="img-responsive img-blog" src="<?php the_post_thumbnail_url('full'); ?>" width="100%"
                         alt=""/>
                    <div class="blog-content">
                        <?php

                        /*
                         * Include the post format-specific template for the content. If you want to
                         * use this in a child theme, then include a file called called content-___.php
                         * (where ___ is the post format) and that will be used instead.
                         */ ?>
                        <p class="lead">
                            <?php echo $post->post_content; ?>
                        </p>
                        <?php
                        // If comments are open or we have at least one comment, load up the comment template.
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;

                        // Previous/next post navigation.
                        ?>
                    </div>
                </div><!--/.blog-item-->
                <?php
                the_post_navigation();
                $previous = get_adjacent_post(false, '', true);

                $next = get_adjacent_post(false, '', false);

                if (!$next && !$previous) {
                    return;
                }
                if ( $previous || $next ) { ?>
                <ul class="pagination pagination-lg">
                    <li><?php echo get_previous_post_link($format = '%link', $link = '<i class="icon-angle-left"></i> Previous', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category'); ?></li>
                    <li><?php echo get_previous_post_link($format = '%link', $link = 'Next <i class="icon-angle-right"></i>', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category'); ?></li>
                </ul>
                <?php } // End the loop.
                endwhile;
                ?>

            </div>
        </div><!--/.col-md-8-->
    </div><!--/.row-->
</section><!--/#blog-->
<?php get_footer(); ?>

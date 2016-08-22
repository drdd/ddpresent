<?php get_header(); ?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
            <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
            <?php the_content(); ?>
        </div>
    <?php endwhile; else: ?>
    <?php _e('Sorry, no posts matched your criteria.'); ?>
<?php endif; ?>
<?php get_footer(); ?>

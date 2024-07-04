<?php
get_header();
?>

<div class="content-area">
    <main class="site-main">
        <?php
        // Set up query arguments
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_type' => 'projects',
            'posts_per_page' => 6,
            'paged' => get_query_var('paged')
        );

        // Custom query
        $projects_query = new WP_Query($args);

        // Check if there are posts
        if ($projects_query->have_posts()) :
            // Start the loop
            while ($projects_query->have_posts()) : $projects_query->the_post();
        ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </header>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
        <?php
            endwhile;

            // Pagination
            echo '<div class="pagination">';
            echo paginate_links(array(
                'total' => $projects_query->max_num_pages,
                'prev_text' => __('« Previous', 'text_domain'),
                'next_text' => __('Next »', 'text_domain'),
            ));
            echo '</div>';

        else :
            echo '<p>' . __('No projects found', 'text_domain') . '</p>';
        endif;

        // Reset post data
        wp_reset_postdata();
        ?>
    </main>
</div>

<?php
get_sidebar();
get_footer();
?>

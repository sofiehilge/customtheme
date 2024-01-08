<?php

//Menu

register_nav_menus(
    array(
        "primary_menu" => "Primary Menu",
        "footer_menu"  => "Footer Menu"
    )
);
//Styles and scripts

/**
 * Proper way to enqueue scripts and styles.
 */

 function wpdocs_theme_name_scripts() {
    wp_enqueue_style( 'style', get_template_directory_uri()."/style.css" );
    wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/script.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );



//add_action("wp_enqueue_scripts", "load_scripts_and_styles");

function return_excerpt_length ($length){
    return 10;
}

add_filter("excerpt_length", "return_excerpt_length", 999);

//THEME SUPPORT
add_theme_support("post-thumbnails");

//widgets

function custom_widgets(){
    register_sidebar(
        array(
            "name"          => "Footer Widgets", 
            "id"            => "footer-widget", 
            "before_widget" => "<div class='widget'>",
            "after_widget"  => "</div>"
        )
        );
        register_sidebar(
            array(
                "name"          => "Header Widgets", 
                "id"            => "header-widget", 
                "before_widget" => "<div class='widget'>",
                "after_widget"  => "</div>"
            )
            );
}

add_action("widgets_init", "custom_widgets");



//short codes

function newsletter(){
    return "Sign up for newsletter";
}

add_shortcode("greeting", "newsletter");

function print_events (){

        ob_start();//bryder ud af sidens loop og går ind i custome loopet
        $query = new WP_query(
            [
                "post_status"    => "publish",
                "order"          => "DSC",
                "orderby"        => "name",
                "posts_per_page"  => "100",
                "post_type"         => "event"
            ]
            );
            while ($query->have_posts()){
                $query->the_post();

                $price = get_post_meta(get_the_id(), "Pris", true);
                $stock = get_post_meta(get_the_id(), "Lager", true);

                ?>
                <a href="<?php echo get_the_permalink() ?>">
                    <h2><?php the_title() ?></h2>
                    <?php the_post_thumbnail('thumbnail');
                    if ($price == "" || $stock == ""){
                        echo "<p>Ring for pris og lagerstatus</p>";
                    } 
                    else{
                        ?>
                        <p class="meta-price">Pris: <?php echo $price ?></p>
                        <p class="meta-price">Lagerstatus: <?php echo $stock ?></p>
                        <?php
                    }
                 
            }
            return ob_get_clean();
    }

add_shortcode("events", "print_events");

//Custom posttypes
//events

function event_post () {
    register_post_type(
        "event",
        [
            "show_in_rest"          => true, 
            "labels"                =>[
                "name"              => "Events", 
                "singular_name"     => "Event",
                "add_new"            => "Tilføj nyt event"
            ],
            "public" => true,
            "exclude_from_search"   => true,
            "has_archive"           => true,
            "rewrite"               => false,
            "supports"              => [
                "title",
                "editor",
                "thumbnail",
                "custom-fields"
            ]
        ]
           
            );
        
        
    }

add_action("init", "event_post");



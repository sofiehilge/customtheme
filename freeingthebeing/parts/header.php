<?php
wp_head();
    if(is_user_logged_in()){
        ?>
        <style>
            body{
                padding-top:50px;
            }
        </style>
        <?php
    }
?>
<header class="header">
    logo her <br>

    <?php
    echo get_search_form("header-widget");
    ?>

    <?php
    dynamic_sidebar("");
    wp_nav_menu(
        array(
            "menu"            => "Primary Menu",
            "container"       => "nav",
            "container_class" =>"main-nav"
        )
    );
    ?>
</header>
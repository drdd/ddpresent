<?php
    $curentUser = wp_get_current_user();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
    <!--[if lt IE 9]>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
    <![endif]-->
    <?php
    wp_enqueue_script("jquery");
    wp_enqueue_script("jquery-ui-core");
    wp_enqueue_script("jquery-effects-highlight");
    wp_head();
    ?>
    <script type="text/javascript" src="<?php echo bloginfo('template_directory').'/js/nonamed.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo bloginfo('template_directory').'/js/jquery.tmpl.min.js'; ?>"></script>
</head>
<body <?php body_class(); ?>>
<div class="sidebar-top" align="center">
    <div align="center">
        <img id="nonamelogo1" height="168" src="<?php echo bloginfo('template_directory').'/screenshotlood.png'; ?>">
    </div>

    <div class="slidebtntop"></div>
<?php
    if ($curentUser->roles[0]==="roamer"){
        echo '<div class="user-login"><input id="userEmail" type="email" placeholder="E-mail" size="25"><input class="send-email-btn" type="button" value="Получить приглашение" onclick="Controll.userSendInv()"></div>';
    }
?>
     <div class="user-info">Ахой, <span><?php echo get_user_meta($curentUser->ID,'aaname')[0];?> </span> у тебя <money>5345 </money><img width="14" style="vertical-align: middle" src="<?php echo bloginfo('template_directory').'/coin.png';?>"></div>

    <?php
    get_sidebar('top');
    ?>
</div>
<div align="center">
    <img id="nonamelogo" src="<?php echo bloginfo('template_directory').'/screenshot.png'; ?>">
</div>
<div class="sidebar-left sidebar-main"><div class="slidebtnleft"></div>
    <?php
    wp_nav_menu( array(
        'theme_location'  =>'left_menu',
        'container'       => '',
        'container_class' => '',
        'menu_class'      => 'slide-menu right-direction',
        'walker'          => new PiratesMenu_Walker
    ) );
    dynamic_sidebar('left');
    ?>
</div>
<div class="sidebar-right sidebar-main"><div class="slidebtnright"></div>
    <?php
    wp_nav_menu( array(
        'theme_location'  =>'right_menu',
        'container'       => '',
        'container_class' => '',
        'menu_class'      => 'slide-menu left-direction',
        'walker'          => new PiratesMenu_Walker
    ) );
    dynamic_sidebar('sidebar_right');
    ?>
</div>

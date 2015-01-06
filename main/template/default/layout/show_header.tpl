<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="{{ document_language }}" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html lang="{{ document_language }}" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html lang="{{ document_language }}" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="{{ document_language }}" class="no-js"> <!--<![endif]-->
<head>
    {% include "default/layout/head.tpl" %}
</head>
<body>
{% include "default/layout/main_header.tpl" %}
{#
    show_header and show_footer templates are only called when using the Display::display_header and Display::display_footer
    for backward compatibility we suppose that the default layout is one column which means using a div with class span12
#}

<div class="span3">

    {# if user is not login show the login form #}
    {% if _u.logged  == 0 %}
    {% include "default/layout/login_form.tpl" %}
    {% endif %}
    <div class="bloque-user">
    <div class="header-logo">
    <img src="{{ _p.web_css }}nuevo_vlearning/img/logo-vlearning.png">
    </div>
        <div class="profile">
        <div class="home"><a href="{{ _p.web_modules }}"><img src="{{ _p.web_css }}nuevo_vlearning/img/userlogin/home.png"></a></div>
        <div class="user-datos">
            <div class="image-user">
                <div class="img-user-width">
                    <img src="{{ _u.avatar}}" class="img-circle">
                </div>
            </div>
            <div class="name">{{_u.firstname}}</div>
                <div class="lastname">{{_u.lastname}}</div>
                <div class="cuenta"><a href="{{ _p.web_main }}social/home.php" class="item-cuenta">Mi cuenta</a></div>
            {{ social_left_content }}
            <div class="options">
                <div class="row-fluid">
                    <div class="span6 help"><a herf="#" data-toggle="modal" data-target="#FAQ"><img src="{{ _p.web_css }}nuevo_vlearning/img/userlogin/icon_help.png">{{"Help"|get_lang}}</a></div>
                            <div class="span6 closed"><a href="{{ logout_link }}">{{ "Logout" |get_lang }}<img src="{{ _p.web_css }}nuevo_vlearning/img/userlogin/icon_closed.png"/> </a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="span9">
    <div class="page-content">
        <div class="logo-icpna"><img src="{{ _p.web_css }}nuevo_vlearning/img/logo-icpna.png"> </div>
    </div>
</div>
{% if show_header == true %}
        {% if plugin_content_top is not null %}
            <div id="plugin_content_top" class="span9">
                {{ plugin_content_top }}
            </div>
        {% endif %}
        <div class="span9">
            {% include "default/layout/page_body.tpl" %}
            <section id="main_content">
{% endif %}
</body>
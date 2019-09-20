<?php

defined('BASEPATH') || exit('No direct script access allowed');

$config['module_config'] = array(
    'description' => 'Production planning tools',
    'name' => 'Planning',
    /*
     * Replace the 'name' entry above with this entry and create the entry in
     * the application_lang file for localization/translation support in the
     * menu
      'name'          => 'lang:bf_menu_planning',
     */
    'menus' => array(
        'content' => 'planning/content/menu',
    ),
    'version' => '0.0.1',
    'author' => 'admin',
);

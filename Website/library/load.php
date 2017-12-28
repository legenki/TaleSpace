<?php

require_once 'layout.php';

// bootstrap navigation walker for menus
require_once JVFRM_HOME_FUC_DIR.'/wp_bootstrap_navwalker.php';
require_once JVFRM_HOME_FUC_DIR."/class-tgm-plugin-activation.php"; // intergrated plugins TGM
require_once JVFRM_HOME_FUC_DIR."/activate-plugins.php"; // get plugins

/** Classes **/
require_once JVFRM_HOME_CLS_DIR.'/class-array.php';
require_once JVFRM_HOME_CLS_DIR.'/javo-get-option.php';
require_once JVFRM_HOME_CLS_DIR.'/class-basic-shortcode.php';

/** Feature Listings / Processing part / Ajax **/
require_once JVFRM_HOME_FUC_DIR.'/process.php';
require_once JVFRM_HOME_FUC_DIR.'/functions-box-map.php';
require_once JVFRM_HOME_FUC_DIR.'/javo-wpml.php';
require_once JVFRM_HOME_FUC_DIR.'/custom-ninjaforms.php';
require_once JVFRM_HOME_FUC_DIR.'/javo-vc-templates.php';

/** Admin Panel **/
require_once JVFRM_HOME_ADM_DIR.'/class-admin.php';
require_once JVFRM_HOME_ADM_DIR.'/class-admin-metabox.php';
require_once JVFRM_HOME_ADM_DIR.'/class-admin-helper.php';
require_once JVFRM_HOME_ADM_DIR.'/class-portfolio.php';

/** Header */
require_once JVFRM_HOME_HDR_DIR.'/class-header.php';

/** Widgets **/
require_once JVFRM_HOME_WG_DIR. '/wg-javo-menu-button-item-submit.php';
require_once JVFRM_HOME_WG_DIR. '/wg-javo-menu-button-login.php';
require_once JVFRM_HOME_WG_DIR. '/wg-javo-menu-button-right-menu.php';
require_once JVFRM_HOME_WG_DIR. '/wg-javo-full-cover-layer.php';
require_once JVFRM_HOME_WG_DIR. '/wg-javo-canvas-box-menu.php';
require_once JVFRM_HOME_WG_DIR. '/wg-javo-recent-photos.php';
require_once JVFRM_HOME_WG_DIR. '/wg-javo-recent-post.php';
require_once JVFRM_HOME_WG_DIR. '/wg-javo-contact-us.php';
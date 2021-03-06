<?php

require_once($CFG->dirroot.'/theme/moodle2_tsc/lib.php');
$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
$hasnotices = $PAGE->blocks->region_has_content('notices', $OUTPUT);
$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

moodle2_tsc_initialise_awesomebar($PAGE);

$bodyclasses = array();
if ($hassidepre && !$hassidepost) {
    $bodyclasses[] = 'side-pre-only';
} else if ($hassidepost && !$hassidepre) {
    $bodyclasses[] = 'side-post-only';
} else if (!$hassidepost && !$hassidepre) {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}
if ($hasnotices) {
	$bodyclasses[] = 'has_notices';
}

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>


<div id="awesomebar" class="moodle2_tsc-awesome-bar">
    <?php
        if( $this->page->pagelayout != 'maintenance' // Don't show awesomebar if site is being upgraded
            && !(get_user_preferences('auth_forcepasswordchange') && !session_is_loggedinas()) // Don't show it when forcibly changing password either
          ) {
            $topsettings = $this->page->get_renderer('theme_moodle2_tsc','topsettings');
            echo $topsettings->navigation_tree($this->page->navigation);
            if ($hascustommenu && !empty($PAGE->theme->settings->custommenuinawesomebar) && empty($PAGE->theme->settings->custommenuafterawesomebar)) {
                echo $custommenu;
            }
            echo $topsettings->settings_tree($this->page->settingsnav);
            if ($hascustommenu && !empty($PAGE->theme->settings->custommenuinawesomebar) && !empty($PAGE->theme->settings->custommenuafterawesomebar)) {
                echo $custommenu;
            }
            //echo $topsettings->onlineusers();
            //echo $topsettings->course_search();
            echo $topsettings->settings_search_box();
        }
    ?>
</div>


<div id="page">

<!-- START OF HEADER -->

    <?php if ($hasheading || $hasnavbar) { ?>
    <div id="wrapper" class="clearfix">

        <div id="page-header">
            <div id="page-header-wrapper" class="clearfix">
                   <?php if ($hasheading) { ?>
                   <h2><img id="site_logo" src="<?php echo $OUTPUT->pix_url('sheffmood_logo', 'theme'); ?>" alt="Moodle and the Sheffield College" /></h2>
                
                
                <?php } ?>
            </div>
        </div>
	<?php if ($hascustommenu) { ?>
 	<div id="custommenu"><?php echo $custommenu; ?><?php echo $OUTPUT->login_info(); ?></div>
	<?php } ?>
        <?php if ($hasnavbar) { ?>
            <div class="navbar clearfix">
                <div class="breadcrumb"><?php echo $OUTPUT->navbar(); ?></div>
                <div class="navbutton"> <?php echo $PAGE->button; ?></div>
            </div>
        <?php } ?>

<?php } ?>

<!-- END OF HEADER -->

<!-- START OF CONTENT -->

        <div id="page-content-wrapper" class="clearfix">
            <div id="page-content">
            
            
                <div id="region-main-box">
                    <div id="region-post-box">

                        <div id="region-main-wrap">
                        
                            <div id="region-main">
                            
                                <div class="region-content">
                                	<?php if ($hasnotices) { ?>
                                		<div class="notices">
                                			<?php echo $OUTPUT->blocks_for_region('notices') ?>
                                		</div>
                                	<?php } ?>
                                	<img id="myMoodleBanner" src="<?php echo $OUTPUT->pix_url('myMoodle_banner', 'theme'); ?>" alt="" />
                                	<?php echo $OUTPUT->main_content() ?>
                                </div>
                            </div>
                        </div>

                        <?php if ($hassidepre) { ?>
                        <div id="region-pre">
                            <div class="region-content">
                                <?php echo $OUTPUT->blocks_for_region('side-pre') ?>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if ($hassidepost) { ?>
                        <div id="region-post">
                            <div class="region-content">
                                <?php echo $OUTPUT->blocks_for_region('side-post') ?>
                            </div>
                        </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>

<!-- END OF CONTENT -->

<!-- START OF FOOTER -->

        <?php if ($hasfooter) { ?>
        <div id="page-footer" class="clearfix">
            <p class="helplink"><?php echo page_doc_link(get_string('moodledocslink')) ?></p>
            <div class="collegeAddress"><h4>The Sheffield College</h4><p>Granville Road<br />Sheffield. S2 2RL</p><p>Tel: 0114 2602600</p></div>
            <?php
                echo $OUTPUT->standard_footer_html();
            ?>
        </div>
        <?php } ?>

    <?php if ($hasheading || $hasnavbar) { ?>
        </div> <!-- END #wrapper -->
    <?php } ?>

</div> <!-- END #page -->

<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>
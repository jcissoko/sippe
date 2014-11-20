<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/garland.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to main-menu administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 */
?>
   

<div id="header_wrapper">
  <div id="inner_header_wrapper">

    <header id="header" role="banner">

      <?php print render($page['top_nav']); ?>

      <?php if (theme_get_setting('social_links', 'rubix_responsive_theme')): ?>
      <div class="social-icons">
       <ul>
        <li><a href="https://www.facebook.com/pages/Master-Sippe-Strat%C3%A9gies-internet-et-pilotage-de-projets-en-entreprise/121165991280054?fref=ts" target="_blank" rel="me"><img src="<?php print base_path() . drupal_get_path('theme', 'rubix_responsive_theme') . '/images/icone-facebook.svg'; ?>" alt="Facebook" width="30" height="30"/></a></li>        <li><a href="https://twitter.com/Master_Sippe" target="_blank" rel="me"><img src="<?php print base_path() . drupal_get_path('theme', 'rubix_responsive_theme') . '/images/icone-twitter.svg'; ?>" alt="Twitter" width="30" height="30"/></a></li>        <li><a href="https://plus.google.com/111834527292287833393" rel="publisher" target="_blank"><img src="<?php print base_path() . drupal_get_path('theme', 'rubix_responsive_theme') . '/images/icone-google-plus.svg'; ?>" alt="googlePlus"  width="30" height="30"/></a></li>		<li><a href="http://www.linkedin.com/in/mastersippe" target="_blank" rel="me"><img src="<?php print base_path() . drupal_get_path('theme', 'rubix_responsive_theme') . '/images/icone-linkedin.svg'; ?>" alt="linkedin" width="30" height="30"/></a></li>        <li><a href="http://viadeo.com/fr/profile/master.sippe" target="_blank" rel="me"><img src="<?php print base_path() . drupal_get_path('theme', 'rubix_responsive_theme') . '/images/icone-viadeo.svg'; ?>" alt="viadeo"  width="30" height="30"/></a></li>        <li><a href="http://www.youtube.com/user/MasterSIPPE" target="_blank" rel="me"><img src="<?php print base_path() . drupal_get_path('theme', 'rubix_responsive_theme') . '/images/icone-youtube.svg'; ?>" alt="Youtube" width="30" height="30"/></a></li>
       </ul>
      </div>
    <?php endif; ?>	<a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">	
      <?php if ($logo): ?>
      <div id="logo"><img src="<?php print base_path() . drupal_get_path('theme', 'rubix_responsive_theme') . '/images/logo_master_sippe.png';?>" alt="Master Sippe" width="142" height="120"/></div>
      <?php endif; ?>
      <h1 id="site-title">
        <div id="site-description"><?php print 'Master Stratégies Internet <br/>et Pilotage de Projets en Entreprise';?></div>
      </h1>	  	</a>
      
    <div class="clear"></div>
    </header>

    <div class="menu_wrapper">

      <nav id="main-menu" role="navigation">

        <!-- <div id="img_home"><a href="<?php print base_path();?>"></a></div> -->
        <div class="menu-navigation-container">
         
          <?php 
              $main_menu_tree = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
              //die(print_r($main_menu_tree, true));
              print drupal_render($main_menu_tree);
            ?>
        </div>
        <div class="clear"></div>
      </nav><!-- end main-menu -->
    </div>
  </div>
</div>
  
  <div id="container">

    <?php if ($is_front): ?>
    <?php print render($page['slideshow']); ?>
     <!-- Banner -->

     <?php if ($page['top_first'] || $page['top_second'] || $page['top_third']): ?> 
      <div id="top-area" class="clearfix">
        <?php if ($page['top_first']): ?>
        <div class="column"><?php print render($page['top_first']); ?></div>
        <?php endif; ?>
        <?php if ($page['top_second']): ?>
        <div class="column"><?php print render($page['top_second']); ?></div>
        <?php endif; ?>
        <?php if ($page['top_third']): ?>
        <div class="column"><?php print render($page['top_third']); ?></div>
        <?php endif; ?>
      </div>
    <?php endif; ?>


    <?php endif; ?>

    <div class="content-sidebar-wrap">

    <div id="content">
      <?php if (theme_get_setting('breadcrumbs', 'rubix_responsive_theme')): ?><div id="breadcrumbs"><?php if ($breadcrumb): print $breadcrumb; endif;?></div><?php endif; ?>
      <section id="post-content" role="main">
        <?php print $messages; ?>
        <?php if ($page['content_top']): ?><div id="content_top"><?php print render($page['content_top']); ?></div><?php endif; ?>
        <?php print render($title_prefix); ?>
        <?php print render($title_suffix); ?>
        <?php if (!empty($tabs['#primary'])): ?><div class="tabs-wrapper"><?php print render($tabs); ?></div><?php endif; ?>
        <?php print render($page['help']); ?>
        <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
        <?php print render($page['content']); ?>
      </section> <!-- /#main -->
    </div>
  
    <?php if ($page['sidebar_first']): ?>
      <aside id="sidebar-first" role="complementary">
        <?php print render($page['sidebar_first']); ?>
      </aside>  <!-- /#sidebar-first -->
    <?php endif; ?>
  
    </div>

    <?php if ($page['sidebar_second']): ?>
      <aside id="sidebar-second" role="complementary">
        <?php print render($page['sidebar_second']); ?>
      </aside>  <!-- /#sidebar-first -->
    <?php endif; ?>


    <?php if ($is_front): ?>
      <?php if ($page['image_first'] || $page['image_second'] || $page['image_third']): ?> 
        <div id="top-area" class="clearfix">
          <?php if ($page['image_first']): ?>
          <div class="column"><?php print render($page['image_first']); ?></div>
          <?php endif; ?>
          <?php if ($page['image_second']): ?>
          <div class="column"><?php print render($page['image_second']); ?></div>
          <?php endif; ?>
          <?php if ($page['image_third']): ?>
          <div class="column"><?php print render($page['image_third']); ?></div>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <?php if ($page['image_forth'] || $page['image_fifth'] || $page['image_sixth']): ?> 
        <div id="top-area" class="clearfix">
          <?php if ($page['image_forth']): ?>
          <div class="column"><?php print render($page['image_forth']); ?></div>
          <?php endif; ?>
          <?php if ($page['image_fifth']): ?>
          <div class="column"><?php print render($page['image_fifth']); ?></div>
          <?php endif; ?>
          <?php if ($page['image_sixth']): ?>
          <div class="column"><?php print render($page['image_sixth']); ?></div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  
</div>

<div id="footer">
  <div id="footer_wrapper">
    <?php if ($page['footer_first'] || $page['footer_second'] || $page['footer_third']): ?> 
      <div id="footer-area" class="clearfix">
        <?php if ($page['footer_first']): ?>
        <div class="column"><?php print render($page['footer_first']); ?><?php endif; ?>
        
        
        <?php if ($page['footer_second']): ?>
        <div class="column"><?php print render($page['footer_second']); ?></div>
        <?php endif; ?>
        <?php if ($page['footer_third']): ?>
        <div class="column"><?php print render($page['footer_third']); ?></div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
  <div class="footer_credit">
	<div class="Navigation">
		<p class="titre-footer">Navigation</p>
		<div class="navigation"> 
			<a href="http://www.master-sippe.fr">Actualités<a/></br>
			<a href="http://master-sippe.fr/Formation/Presentation">Formation</a></br>
			<a href="http://master-sippe.fr/Metiers/LesMetiers">Métiers</a></br>
			<a href="http://master-sippe.fr/Etudiants/AssociationAEAD">Etudiants</a></br>
			<a href="http://master-sippe.fr/Entreprises/Partenaires">Partenaires</a>
		</div>
		<div class="navigation">
			<a href="http://master-sippe.fr/Admission/ModalitesAdmission">Admissions</a></br>
			<a href="http://master-sippe.fr/Contact">Contact</a></br>
			<a href="http://www.master-sippe.fr/PlanDuSite">Plan du site</a></br>
			<a href="http://www.master-sippe.fr/MentionsLegales">Mentions légales</a>
		</div>
	</div>
	<div class="Autres_site">
		<p class="titre-footer">Autres Sites</p>
		<div class="navigation_sous">
			<a class="lien_img" href="http://www.vichy-universite.com"><img src="<?php print base_path() . drupal_get_path('theme', 'rubix_responsive_theme') . '/images/logo-pole-lardy-footer.jpg'; ?>" alt="PoleLardy" width="37" class="img_footer"/> Pôle Lardy</a>
			<a href="http://www.univ-bpclermont.fr/"><img src="<?php print base_path() . drupal_get_path('theme', 'rubix_responsive_theme') . '/images/logo-ubp-footer.jpg'; ?>" alt="UBP" width="37" class="img_footer"/> Université Blaise Pascal</a>			
		</div>	
	</div>

	<div class="Suivez_nous">
		<p class="titre-footer">Suivez-nous</p>
			<div class="social-icons">
				<ul>
					<li><a href="https://www.facebook.com/pages/Master-Sippe-Strat%C3%A9gies-internet-et-pilotage-de-projets-en-entreprise/121165991280054?fref=ts" target="_blank" rel="me"><img src="<?php print base_path() . drupal_get_path('theme', 'rubix_responsive_theme') . '/images/icone-facebook.svg'; ?>" alt="Facebook" width="30" height="30"/></a></li>
					<li><a href="https://twitter.com/Master_Sippe" target="_blank" rel="me"><img src="<?php print base_path() . drupal_get_path('theme', 'rubix_responsive_theme') . '/images/icone-twitter.svg'; ?>" alt="Twitter" width="30" height="30"/></a></li>
					<li><a href="https://plus.google.com/111834527292287833393/posts" target="_blank" rel="me"><img src="<?php print base_path() . drupal_get_path('theme', 'rubix_responsive_theme') . '/images/icone-google-plus.svg'; ?>" alt="googlePlus"  width="30" height="30"/></a></li>
					<li><a href="http://www.linkedin.com/in/mastersippe" target="_blank" rel="me"><img src="<?php print base_path() . drupal_get_path('theme', 'rubix_responsive_theme') . '/images/icone-linkedin.svg'; ?>" alt="linkedin" width="30" height="30"/></a></li>
					<li><a href="http://www.viadeo.com/fr/profile/master.sippe" target="_blank" rel="me"><img src="<?php print base_path() . drupal_get_path('theme', 'rubix_responsive_theme') . '/images/icone-viadeo.svg'; ?>" alt="viadeo"  width="30" height="30"/></a></li>
					<li><a href="http://www.youtube.com/user/MasterSIPPE" target="_blank" rel="me"><img src="<?php print base_path() . drupal_get_path('theme', 'rubix_responsive_theme') . '/images/icone-youtube.svg'; ?>" alt="Youtube" width="30" height="30"/></a></li>
				</ul>
			</div>	</div>
</div>
<div class="footerSEO">	<div id="texteSEO">Le master SIPPE est une formation bac+5 évoluant dans les domaines de l’informatique et de l’internet. Ce cursus de deux ans forme des étudiants aux métiers du web tels que chef de projet, webmarketeur, développeur, community manager.</div></div>		<script>	var options = {		"url": Drupal.settings.basePath + "sites/all/themes/rubix-responsive-theme/style_twitter.css"	};	CustomizeTwitterWidget(options);</script>
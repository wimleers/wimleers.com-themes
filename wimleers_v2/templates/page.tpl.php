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
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
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
 * - $page['highlighted']: Items for the highlighted content region.
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

<header id="header" class="siteHead">
  <nav class="c16">
    <div class="g7 logo">
      <h1 id="site-name">
        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
      </h1>
      <h2 id="site-slogan"><?php print $site_slogan; ?></h2>
    </div>
    <div class="g9">
      <?php print $main_menu; ?>
      <?php print $meta_menu; ?>
    </div>
  </nav>
</header>


<?php /* First layout. */ ?>
<?php if ($is_front || ($is_view_page && $is_writings_view)): ?>
  <section class="main writings c16 cf">
    <?php if ($is_front) : ?>
      <div class="cf">
        <?php if ($page['intro']): ?>
          <?php print render($page['intro']) ?>
        <?php endif; ?>
      </div>
    <?php endif; ?>
      <div class="body">
        <section class="g10">
          <?php print render($page['content']); ?>
        </section>
        <aside class="g6 topics">
          <div class="g4 pre2">
            <h2>I write about:</h2>
            <?php print $hot_topics_menu; ?>
            <p> ↪&nbsp;<a href="<?php print $tags_url?>">All tags</a></p>
          </div>
        </aside>
      </div>
  </section>


<?php /* Second layout. */ ?>
<?php elseif($is_demo_page || ($is_view_page && !$is_writings_view)): ?>


  <section class="main c16 cf">
    <aside class="g3">
      <?php print $messages; ?>
      <?php print $breadcrumb; ?>
    </aside>
    <article class="g12">
      <header>
      <?php print render($title_prefix); ?>
      <?php if ($title): ?><h1><?php print $title; ?></h1><?php endif; ?>
      <?php print render($title_suffix); ?>
      </header>
      <?php if ($tabs): ?><div class="tabs"><?php print render($tabs); ?></div><?php endif; ?>
      <?php print render($page['help']); ?>
      <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
      <?php print render($page['content']); ?>
    </article>
    </div>
  </section>


<?php /* Third layout. */ ?>
<?php else: ?>


  <section class="main c16 cf">
    <aside class="g7">
      <?php print $messages; ?>
      <?php print $breadcrumb; ?>
      <?php if ($tags): ?>
        <h1>This <?php print $node_type; ?> is about</h1>
        <?php print render($tags); ?>
      <?php endif; ?>
      <?php if ($downloads): ?>
        <h1>Downloads</h1>
        <?php print render($downloads); ?>
      <?php endif; ?>
      <h1>Hot topics</h1>
      <?php print $hot_topics_menu; ?>
      <?php if ($page['sidebar']): ?>
        <?php print render($page['sidebar']) ?>
      <?php endif; ?>
    </aside>

    <?php if ($node): ?>
      <?php if ($tabs): ?><div class="tabs g9"><?php print render($tabs); ?></div><?php endif; ?>
      <?php print render($page['help']); ?>
      <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
      <?php print render($page['content']); ?>
    <?php else: ?>
      <article class="g9">
        <header>
          <?php print render($title_prefix); ?>
          <?php if ($title): ?><h1><?php print $title; ?></h1><?php endif; ?>
          <?php print render($title_suffix); ?>
        </header>
        <?php if ($tabs): ?><div class="tabs g9"><?php print render($tabs); ?></div><?php endif; ?>
        <?php print render($page['help']); ?>
        <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
        <?php print render($page['content']); ?>
      </article>
    <?php endif; ?>
  </section>
<?php endif; ?>

<footer class="siteFoot">
  <div class="c16 cf">
    <div class="g10">
      <?php print render($builtin_search); ?>
      <p>
        Logo: <a href="http://inespee.com">Ine Spee</a>.
        Design: <a href="http://xavierbertels.com">Xavier Bertels</a>.
        Made in <a href="http://en.wikipedia.org/wiki/Hasselt">Hasselt</a>.<br />
        Copyright 2007&ndash;2012 <a href="http://wimleers.com">Wim Leers</a>. All rights reserved.
      </p>
    </div>
    <nav class="g6">
      <ul>
        <li><a href="https://twitter.com/wimleers" rel="me">Twitter</a></li>
        <li><a href="https://linkedin.com/in/wimleers" rel="me">LinkedIn</a></li>
        <li><a href="https://github.com/wimleers" rel="me">Github</a></li>
        <li><a href="https://drupal.org/user/99777" rel="me">Drupal.org</a></li>
        <li><a href="https://pinboard.in/u:wimleers/" rel="me">Pinboard</a></li>
      </ul>
    </nav>
  </div>
</footer>
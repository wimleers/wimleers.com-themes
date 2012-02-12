<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page while offline.
 *
 * All the available variables are mirrored in html.tpl.php and page.tpl.php.
 * Some may be blank but they are provided for consistency.
 *
 * @see template_preprocess()
 * @see template_preprocess_maintenance_page()
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">

<head>
  <title><?php print $head_title; ?></title>
  <?php print $head; ?>
  <?php print $styles; ?>
  <?php print $scripts; ?>
</head>
<body class="<?php print $classes; ?>">
  <header id="header" class="ofPage">
    <nav class="c16">
      <div class="g7 logo">
        <h1 id="site-name">
          <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
        </h1>
        <h2 id="site-slogan"><?php print $title; ?></h2>
      </div>
    </nav>
  </header>
  <section class="main c16 cf">
    <div class="body cf">
      <article class="g7 pre2 intro">
        <h2><?php print $title ?></h2>
        <?php print $content ?>
      </article>
    </div>
  </section>
  <footer class="ofPage">
    <div class="c16 cf">
      <div class="g10">
        <p>
          Logo: <a href="http://inespee.com">Ine Spee</a>.
          Design: <a href="http://xavierbertels.com">Xavier Bertels</a>.
          Made in <a href="http://en.wikipedia.org/wiki/Hasselt">Hasselt</a>.<br />
          Copyright 2007&ndash;2012 <a href="http://wimleers.com">Wim Leers</a>. All rights reserved.
        </p>
      </div>
      <nav class="g6">
        <ul>
          <li><a href="https://twitter.com/wimleers">Twitter</a></li>
          <li><a href="http://linkedin.com/in/wimleers">LinkedIn</a></li>
          <li><a href="https://github.com/wimleers">Github</a></li>
          <li><a href="http://drupal.org/user/99777">Drupal.org</a></li>
          <li><a href="http://pinboard.in/u:wimleers/">Pinboard</a></li>
        </ul>
      </nav>
    </div>
  </footer>
</body>
</html>

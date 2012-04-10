<?php


define('MENU_META', 'menu-meta');
define('MENU_HOT_TOPICS', 'menu-hot-topics');
define('PATH_WORK_PAGE', 'node/132');

/**
 * Purge needless XHTML stuff.
 *
 * Based on http://sonspring.com/journal/html5-in-drupal-7#_pruning.
 */
function wimleers_v2_process_html_tag(&$vars) {
  $el = &$vars['element'];
  
  // Remove type="..." and CDATA prefix/suffix.
  unset($el['#attributes']['type'], $el['#value_prefix'], $el['#value_suffix']);
  
  // Remove media="all" but leave others unaffected.
  if (isset($el['#attributes']['media']) && $el['#attributes']['media'] === 'all') {
    unset($el['#attributes']['media']);
  }
}

/**
 * Remove all CSS that we don't need.
 * Note that a part of system.base.css, all of system.messages.css (modified)
 * and all of typogrify.css are included in drupalstuff.scss.
 */
function wimleers_v2_css_alter(&$css) {
  if (arg(0) == 'demo') {
    return;
  }
  
  unset($css[drupal_get_path('module', 'system') . '/system.theme.css']);
  unset($css[drupal_get_path('module', 'system') . '/system.menus.css']);
  unset($css[drupal_get_path('module', 'system') . '/system.base.css']);
  unset($css[drupal_get_path('module', 'system') . '/system.messages.css']);

  unset($css[drupal_get_path('module', 'comment') . '/comment.css']);
  unset($css[drupal_get_path('module', 'field') . '/theme/field.css']);
  unset($css[drupal_get_path('module', 'node') . '/node.css']);
  unset($css[drupal_get_path('module', 'search') . '/search.css']);
  unset($css[drupal_get_path('module', 'user') . '/user.css']);

  unset($css[drupal_get_path('module', 'comment_notify') . '/comment_notify.css']);
  unset($css[drupal_get_path('module', 'ctools') . '/css/ctools.css']);
  unset($css[drupal_get_path('module', 'date_api') . '/date.css']);
  unset($css[drupal_get_path('module', 'mollom') . '/mollom.css']);
  unset($css[drupal_get_path('module', 'typogrify') . '/typogrify.css']);
  unset($css[drupal_get_path('module', 'views') . '/css/views.css']);
}

function wimleers_v2_preprocess_node(&$variables) {
  $node = $variables['node'];

  if (in_array($node->type, array('blog', 'article', 'talk', 'project'))) {
    $variables['meta'] = t('published <span>on</span> !date', array('!content-type' => $node_type->name, '!date' => format_date($node->created, 'custom', 'F j, Y')));
  }
}

function wimleers_v2_preprocess_comment(&$variables) {
  $comment = $variables['elements']['#comment'];
  $node = $variables['elements']['#node'];

  // Whether to show the manually entered subject or not. Before node 112,
  // manual subjects were enabled, afterwards: not anymore.
  $variables['manual_subject'] = ($node->nid > 112) ? FALSE : TRUE;

  $uri = entity_uri('comment', $comment);
  $uri['options'] += array('attributes' => array('class' => 'permalink', 'rel' => 'bookmark'));
  $variables['permalink'] = l($variables['created'], $uri['path'], $uri['options']);
}

function wimleers_v2_preprocess_page(&$variables) {
  // Detect view pages.
  $router_item = menu_get_item();
  $is_view_page = $router_item['page_callback'] == 'views_page';
  $variables['is_view_page'] = $is_view_page;
  $variables['is_tags_page'] = strstr(drupal_get_path_alias($_GET["q"]), 'tags/');
  $variables['is_demo_page'] = arg(0) == 'demo';
  if ($is_view_page) {
    $view = views_get_view($router_item['page_arguments'][0]);
    $variables["is_{$view->tag}_view"] = TRUE;
  }


  $node = $variables['node'];

  if (isset($node->type)) {
    $node_type = node_type_get_type($node);
    $variables['node_type'] = drupal_strtolower($node_type->name);
  }
  if (isset($node->taxonomy_vocabulary_1)) {
    $variables['tags'] = field_view_field('node', $node, 'taxonomy_vocabulary_1');
  }
  if (isset($node->upload)) {
    $variables['downloads'] = field_view_field('node', $node, 'upload');
  }

  if (isset($variables['node']) && $node->type != 'page') {
    // Hack to automatically mark "blog" as active when reading a blog post,
    // "articles" when reading an article and "talks" when reading a talk. It
    // also marks "work" as active when looking at work-related content types.
    $old_get_q = $_GET['q'];
    $_GET['q'] = $node->type;
    if (in_array($node->type, array('client', 'project', 'demo'))) {
      $_GET['q'] = PATH_WORK_PAGE;
    }
    $variables['main_menu'] = theme('links__system_main_menu', array('links' => $variables['main_menu']));
    $_GET['q'] = $old_get_q;
  }
  else if (strpos($_GET['q'], 'demo/hierarchical-select') === 0 || in_array($_GET['q'], array('work/project', 'work/client'))) {
    // Hack to auomtatically mark "work" as active when looking at the
    // Hierarchical Select demo, which does not consist of nodes, but is a
    // custom module.
    $old_get_q = $_GET['q'];
    $_GET['q'] = PATH_WORK_PAGE;
    $variables['main_menu'] = theme('links__system_main_menu', array('links' => $variables['main_menu']));
    $_GET['q'] = $old_get_q;
  }
  else {
    $variables['main_menu'] = theme('links__system_main_menu', array('links' => $variables['main_menu']));
  }

  
  $variables['meta_menu']       = theme('links__meta_menu',        array('links' => menu_navigation_links(MENU_META)));  
  $variables['hot_topics_menu'] = theme('links__hot_topics_menu',  array('links' => menu_navigation_links(MENU_HOT_TOPICS), 'attributes' => array('class' => 'topics')));
  $variables['tags_url']        = url('tags');
  $variables['builtin_search'] = drupal_get_form('search_block_form');
}

function wimleers_v2_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  if (!empty($breadcrumb)) {

    // Adding the title of the current page to the breadcrumb.
    $breadcrumb[] = drupal_get_title();
    
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';

    $output .= '<div class="breadcrumb">' . implode(' / ', $breadcrumb) . '</div>';
    return $output;
  }
}

function wimleers_v2_links__meta_menu($variables) {
  $links = $variables['links'];
  $attributes = $variables['attributes'];
  $heading = $variables['heading'];
  global $language_url;
  $output = '';

  if (count($links) > 0) {
    $output = '';

    // Treat the heading first if it is present to prepend it to the
    // list of links.
    if (!empty($heading)) {
      if (is_string($heading)) {
        // Prepare the array that will be used when the passed heading
        // is a string.
        $heading = array(
          'text' => $heading,
          // Set the default level of the heading.
          'level' => 'h2',
        );
      }
      $output .= '<' . $heading['level'];
      if (!empty($heading['class'])) {
        $output .= drupal_attributes(array('class' => $heading['class']));
      }
      $output .= '>' . check_plain($heading['text']) . '</' . $heading['level'] . '>';
    }

    $output .= '<ul' . drupal_attributes($attributes) . '>';
    
    // ADDED
    $output .= '<div class="alignRight meta">';

    $num_links = count($links);
    $i = 1;

    foreach ($links as $key => $link) {
      $class = array($key);

      // Add first, last and active classes to the list of links to help out themers.
      if ($i == 1) {
        $class[] = 'first';
      }
      if ($i == $num_links) {
        $class[] = 'last';
      }
      if (isset($link['href']) && ($link['href'] == $_GET['q'] || ($link['href'] == '<front>' && drupal_is_front_page()))
          && (empty($link['language']) || $link['language']->language == $language_url->language)) {
        $class[] = 'active';
      }
      $output .= '<li' . drupal_attributes(array('class' => $class)) . '>';

      if (isset($link['href'])) {
        // Pass in $link as $options, they share the same keys.
        $output .= l($link['title'], $link['href'], $link);
      }
      elseif (!empty($link['title'])) {
        // Some links are actually not links, but we wrap these in <span> for adding title and class attributes.
        if (empty($link['html'])) {
          $link['title'] = check_plain($link['title']);
        }
        $span_attributes = '';
        if (isset($link['attributes'])) {
          $span_attributes = drupal_attributes($link['attributes']);
        }
        $output .= '<span' . $span_attributes . '>' . $link['title'] . '</span>';
      }

      $i++;
      $output .= "</li>\n";
    }

    // ADDED
    $output .= '</div>';

    $output .= '</ul>';
  }

  return $output;
}

<?php

/**------------------------------------------------------------------------
com_mediamallfactory - Media Mall Factory 3.3.5 
------------------------------------------------------------------------
 * @author TheFactory
 * @copyright Copyright (C) 2011 SKEPSIS Consult SRL. All Rights Reserved.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * Websites: http://www.thefactory.ro
 * Technical Support: Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/
//

function getRoutes()
{
  $routes = array(
    'media'          => array('view' => 'media', 'params' => array('media_id')),
    'invoice'        => array('view' => 'invoice', 'params' => array('invoice_id', 'tmpl')),
    'media-comments' => array('view' => 'mediacomments', 'params' => array('media_id')),
    'edit'           => array('view' => 'edit', 'params' => array('media_id')),
    'media-log'      => array('view' => 'medialog', 'params' => array('media_id')),
    'categories'     => array('view' => 'categories', 'params' => array('category_id')),
  );

  return $routes;
}

function MediaMallFactoryBuildRoute(&$query)
{
  if (!isset($query['view']) && !isset($query['controller']))
  {
    return array();
  }

  $routes   = getRoutes();
  $segments = array();

  foreach ($routes as $alias => $route)
  {
    if (isset($query['view']))
    {
      if (!isset($route['view']) || $route['view'] != $query['view'])
      {
        continue;
      }
    }
    elseif (isset($query['controller']))
    {
      if (!isset($route['controller']) || $route['controller'] != $query['controller'] || $route['task'] != $query['task'])
      {
        continue;
      }
    }

    $valid = true;
    $temp  = array();

    if (isset($route['params']))
    {
      foreach ($route['params'] as $type => $param)
      {
        if (!isset($query[$param]))
        {
          if ('optional' !== $type)
          {
            $valid = false;
            break;
          }
        }
      }
    }

    if (!$valid)
    {
      continue;
    }

    $segments[] = $alias;
    if (isset($query['view']))
    {
      unset($query['view']);
    }
    else
    {
      unset($query['controller']);
    }

    if (isset($route['controller']))
    {
      unset($query['task']);
    }

    if (isset($route['params']))
    {
      foreach ($route['params'] as $param)
      {
        if (isset($query[$param]))
        {
          $segments[] = $query[$param];
          unset($query[$param]);
        }
      }
    }

    break;
  }

  if (!$segments) {
    $segments[] = $query['view'];
    unset($query['view']);
  }

  return $segments;
}

function MediaMallFactoryParseRoute($segments)
{
  $routes = getRoutes();
  $vars   = array();

  $segments[0] = str_replace(':', '-', $segments[0]);

  if (array_key_exists($segments[0], $routes))
  {
    $route = $routes[$segments[0]];

    if (isset($route['view']))
    {
      $vars['view'] = $route['view'];
    }
    else
    {
      $vars['controller'] = $route['controller'];
      $vars['task']       = $route['task'];
    }

    if (isset($route['params']))
    {
      $i = 1;
      foreach ($route['params'] as $type => $param)
      {
        if (isset($segments[$i]))
        {
          $vars[$param] = $segments[$i];
        }

        $i++;
      }
    }
  }

  if (!$vars) {
    $vars['view'] = $segments[0];
  }

  return $vars;
}

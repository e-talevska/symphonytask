<?php
/**
 * Created by PhpStorm.
 * User: emilijatalevska
 * Date: 12/17/17
 * Time: 2:56 PM
 */

namespace QuickBetOnline\Controllers;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController
{
    protected $template = null;

    /**
     * Get the templating engine from the container
     *
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container) {
        $this->template = $container->get('templating');
    }

    /**
     *
     * return templating engine
     */
    public function getTemplate() {
        return $this->template;
    }

    function render_template($template, $attributes)
    {
        extract($attributes, EXTR_SKIP);
        $template = str_replace(array('.', '/', '\\'), DIRECTORY_SEPARATOR, $template);
        ob_start();

        include sprintf(__DIR__.'/../Views/%s.php', $template);

        return new Response(ob_get_clean());
    }
}
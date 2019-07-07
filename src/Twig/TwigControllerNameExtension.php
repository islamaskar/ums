<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
// use Twig\TwigFilter;
use Twig\TwigFunction;
use Symfony\Component\HttpFoundation\RequestStack;

class TwigControllerNameExtension extends AbstractExtension
{
    // public function getFilters(): array
    // {
    //     return [
    //         // If your filter generates SAFE HTML, you should add a third
    //         // parameter: ['is_safe' => ['html']]
    //         // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
    //         new TwigFilter('filter_name', [$this, 'doSomething']),
    //     ];
    // }
    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('controller_name', [$this, 'get_controller_name']),
        ];
    }

    public function get_controller_name()
    {
        $pattern = "/Controller\\\\([a-zA-Z]*)Controller/";
        $matches = array();
        preg_match($pattern, $this->request->getCurrentRequest()->get("_controller"), $matches);

        return $matches[1];
    }
}

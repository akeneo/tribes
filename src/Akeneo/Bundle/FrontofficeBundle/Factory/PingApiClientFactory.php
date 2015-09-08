<?php

namespace Akeneo\Bundle\FrontofficeBundle\Factory;

use GuzzleHttp\Client;
use Symfony\Component\Routing\Router;

/**
 * Ping api client factory
 *
 * @author    Willy Mesnage <willy.mesnage@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class PingApiClientFactory
{
    /** @var Router */
    protected $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param array $options Options to add or override
     *
     * @return Client
     */
    public function create(array $options = [])
    {
        $baseOptions = [
            'base_uri' => $this->router->generate('akeneo_api_event')
        ];
        $options = array_merge($baseOptions, $options);

        return new Client($options);
    }
}

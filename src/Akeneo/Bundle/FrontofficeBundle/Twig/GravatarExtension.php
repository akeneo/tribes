<?php

namespace Akeneo\Bundle\FrontofficeBundle\Twig;

class GravatarExtension extends \Twig_Extension
{
    /** @var  string */
    protected $gravatarUrl;

    /**
     * @param string $gravatarUrl
     */
    public function __construct($gravatarUrl)
    {
        $this->gravatarUrl = $gravatarUrl;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('gravatar_url', [$this, 'getGravatarUrl'])
        ];
    }

    /**
     * Get the corresponding gravatar url given the email adress
     *
     * @param string $email
     *
     * @return string
     */
    public function getGravatarUrl($email)
    {
        $hash = md5(strtolower(trim($email)));

        return $this->gravatarUrl . $hash;
    }

    public function getName()
    {
        return 'gravatar_extension';
    }
}
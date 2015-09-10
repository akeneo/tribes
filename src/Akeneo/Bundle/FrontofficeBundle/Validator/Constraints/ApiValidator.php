<?php

namespace Akeneo\Bundle\FrontofficeBundle\Validator\Constraints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Api validator
 *
 * @author    Willy Mesnage <willy.mesnage@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ApiValidator extends ConstraintValidator
{
    /** @var Client */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        try {
            $this->client->request('POST', $constraint->resource, [
                'json' => $value
            ]);
        } catch (ClientException $e) {
            $content = json_decode($e->getResponse()->getBody()->getContents(), true);
            $this->bindViolations($content['errors']);
        }
    }

    /**
     * Bind violations on form
     *
     * @param array  $errors
     * @param string $path
     */
    protected function bindViolations(array $errors, $path = null)
    {
        foreach ($errors as $key => $error) {
            if ('errors' !== $key && 'children' !== $key && !is_numeric($key)) {
                null === $key ? $path = $key : $path = sprintf('[%s]', $key);
            }
            if (is_array($error) && !empty($error)) {
                $this->bindViolations($error, $path);
            } elseif (!empty($error)) {
                $this->context->buildViolation($error)
                    ->atPath($path)
                    ->addViolation();
            }
        }
    }
}

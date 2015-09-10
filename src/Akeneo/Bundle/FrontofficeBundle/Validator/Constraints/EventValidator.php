<?php

namespace Akeneo\Bundle\FrontofficeBundle\Validator\Constraints;

use GuzzleHttp\Client;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Event validator
 *
 * @author    Willy Mesnage <willy.mesnage@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class EventValidator extends ConstraintValidator
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
            $response = $this->client->request('POST', 'events', [
                'json' => $value
            ]);
            if (400 === $response->getStatusCode()) {
                $this->context->buildViolation($constraint->invalidMessage)->addViolation();
            }
        } catch (\Exception $e) {
            $this->context->buildViolation($e->getMessage())->addViolation();
        }
    }
}

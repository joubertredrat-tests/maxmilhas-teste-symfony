<?php
/**
 * MaxMilhas Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace AppBundle\Component;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Api Request
 *
 * @package AppBundle\Component
 */
class ApiRequest
{
    /**
     * Rest content type
     */
    const CONTENT_TYPE = 'json';

    /**
     * @var Request
     */
    private $request;

    /**
     * ApiRequest constructor
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $request = $requestStack->getCurrentRequest();

        if (!self::isValidContentType($request)) {
            throw new \RuntimeException(
                sprintf(
                    'Invalid content-type on request: %s',
                    $request->headers->get('CONTENT_TYPE')
                )
            );
        }

        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return (array) json_decode($this->request->getContent());
    }

    /**
     * @param Request $request
     * @return bool
     */
    public static function isValidContentType(Request $request): bool
    {
        return self::CONTENT_TYPE === $request->getContentType();
    }
}

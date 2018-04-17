<?php
/**
 * MaxMilhas Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Docs Controller
 *
 * @package AppBundle\Controller
 */
class DocsController extends Controller
{
    /**
     * @return Response
     */
    public function showAction(): Response
    {
        return $this->render('@App/docs.html.twig');
    }
}

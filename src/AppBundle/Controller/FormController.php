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
 * Form Controller
 *
 * @package AppBundle\Controller
 */
class FormController extends Controller
{
    /**
     * @return Response
     */
    public function showAction(): Response
    {
        return $this->render('@App/form.html.twig');
    }
}

<?php
/**
 * MaxMilhas Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Status Controller
 *
 * @package AppBundle\Controller
 */
class StatusController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function showAction(): JsonResponse
    {
        try {
            $statusService = $this->get('app.service.status');
            $status = $statusService->getStatus();

            return new JsonResponse($status->toArray());
        } catch (\Throwable $e) {
            throw new HttpException(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }
}

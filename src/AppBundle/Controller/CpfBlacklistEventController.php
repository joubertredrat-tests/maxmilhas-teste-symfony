<?php
/**
 * MaxMilhas Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace AppBundle\Controller;

use Application\Domain\Exception\Cpf\Blacklist\Event\InvalidSortException as CpfBlacklistEventInvalidSortException;
use Application\Domain\Exception\Cpf\Blacklist\Event\InvalidTypeException as CpfBlacklistEventInvalidTypeException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Cpf Blacklist Event Controller
 * @package AppBundle\Controller
 */
class CpfBlacklistEventController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function listAction(Request $request): JsonResponse
    {
        try {
            $cpfBlacklistEventService = $this->get('app.service.cpf_blacklist_event');

            $sort = $request->get('sort', null);
            $type = $request->get('type', null);
            $cpf = $request->get('cpf', null);

            $apiListPresenter = $cpfBlacklistEventService->listEventsApi($sort, $cpf, $type);

            return new JsonResponse($apiListPresenter->toArray());
        } catch (CpfBlacklistEventInvalidSortException|CpfBlacklistEventInvalidTypeException $e) {
            throw new HttpException(
                Response::HTTP_BAD_REQUEST,
                $e->getMessage()
            );
        } catch (\Throwable $e) {
            throw new HttpException(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }
}

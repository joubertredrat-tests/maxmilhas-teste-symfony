<?php
/**
 * MaxMilhas Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace AppBundle\Controller;

use AppBundle\Component\ApiRequest;
use Application\Domain\Exception\Cpf\Blacklist\HasExistException as CpfBlacklistHasExistException;
use Application\Domain\Exception\Cpf\Blacklist\NotFoundException as CpfBlacklistNotFoundException;
use Application\Domain\Exception\Cpf\InvalidNumberException as CpfInvalidNumberException;
use Application\Domain\Model\CpfBlacklist;
use Application\Domain\Presenter\CpfBlacklistPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Cpf Blacklist Controller
 *
 * @package AppBundle\Controller
 */
class CpfBlacklistController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function consultAction(Request $request): JsonResponse
    {
        try {
            $cpf = $request->get('cpf');

            if (!CpfBlacklist::isValid($cpf)) {
                throw new CpfInvalidNumberException(
                    sprintf('Cpf with invalid number %s', $cpf)
                );
            }

            $cpfBlacklistService = $this->get('app.service.cpf_blacklist');
            $cpfBlacklistEventService = $this->get('app.service.cpf_blacklist_event');

            $cpfBlacklistConsult = new CpfBlacklist();
            $cpfBlacklistConsult->setNumber($cpf);
            $cpfBlacklistEventService->registerEventConsult($cpfBlacklistConsult);

            $cpfBlacklistPresenter = $cpfBlacklistService->getCpfByNumberApi(
                $cpfBlacklistConsult->getNumber()
            );

            return new JsonResponse($cpfBlacklistPresenter->toArray());
        } catch (CpfInvalidNumberException $e) {
            throw new HttpException(
                Response::HTTP_BAD_REQUEST,
                $e->getMessage()
            );
        } catch (CpfBlacklistNotFoundException $e) {
            throw new HttpException(
                Response::HTTP_NOT_FOUND,
                $e->getMessage()
            );
        } catch (\Throwable $e) {
            throw new HttpException(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    /**
     * @return JsonResponse
     */
    public function listAction(): JsonResponse
    {
        try {
            $cpfBlacklistService = $this->get('app.service.cpf_blacklist');
            $cpfBlacklistEventService = $this->get('app.service.cpf_blacklist_event');

            $apiListPresenter = $cpfBlacklistService->listCpfApi();
            $cpfBlacklistEventService->registerEventList();

            return new JsonResponse($apiListPresenter->toArray());
        } catch (\Throwable $e) {
            throw new HttpException(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getAction(int $id): JsonResponse
    {
        try {
            $cpfBlacklistService = $this->get('app.service.cpf_blacklist');
            $cpfBlacklistEventService = $this->get('app.service.cpf_blacklist_event');

            /** @var CpfBlacklistPresenter $cpfBlacklistPresenter */
            $cpfBlacklistPresenter = $cpfBlacklistService->getCpfApi($id);

            $cpfBlacklistEventService->registerEventGet(
                $cpfBlacklistPresenter->getCpfBlacklist()
            );

            return new JsonResponse($cpfBlacklistPresenter->toArray());
        } catch (CpfBlacklistNotFoundException $e) {
            throw new HttpException(
                Response::HTTP_NOT_FOUND,
                $e->getMessage()
            );
        } catch (\Throwable $e) {
            throw new HttpException(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    /**
     * @param ApiRequest $request
     * @return JsonResponse
     */
    public function postAction(ApiRequest $request): JsonResponse
    {
        try {
            $data = $request->getData();

            if (!isset($data['number']) || !CpfBlacklist::isValid($data['number'])) {
                throw new CpfInvalidNumberException(
                    sprintf('Cpf with invalid number %s', $data['number'])
                );
            }

            $cpfBlacklistService = $this->get('app.service.cpf_blacklist');
            $cpfBlacklistEventService = $this->get('app.service.cpf_blacklist_event');

            /** @var CpfBlacklistPresenter $cpfBlacklistPresenter */
            $cpfBlacklistPresenter = $cpfBlacklistService->addCpfApi($data['number']);

            $cpfBlacklistEventService->registerEventAdd(
                $cpfBlacklistPresenter->getCpfBlacklist()
            );

            return new JsonResponse(
                $cpfBlacklistPresenter->toArray(),
                Response::HTTP_CREATED
            );
        } catch (CpfInvalidNumberException|CpfBlacklistHasExistException $e) {
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

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteAction(int $id): JsonResponse
    {
        try {
            $cpfBlacklistService = $this->get('app.service.cpf_blacklist');
            $cpfBlacklistEventService = $this->get('app.service.cpf_blacklist_event');

            $cpfBlacklist = $cpfBlacklistService->deleteCpf($id);
            $cpfBlacklistEventService->registerEventDelete($cpfBlacklist);

            return new JsonResponse([], Response::HTTP_NO_CONTENT);
        } catch (CpfBlacklistNotFoundException $e) {
            throw new HttpException(
                Response::HTTP_NOT_FOUND,
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

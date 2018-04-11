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

            $service = $this->get('app.service.cpf_blacklist');
            $cpfPresenter = $service->getCpfByNumberApi($cpf);

            return new JsonResponse($cpfPresenter->toArray());
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
            $service = $this->get('app.service.cpf_blacklist');
            $apiListPresenter = $service->listCpfApi();

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
            $service = $this->get('app.service.cpf_blacklist');
            $cpfPresenter = $service->getCpfApi($id);

            return new JsonResponse($cpfPresenter->toArray());
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

            $service = $this->get('app.service.cpf_blacklist');
            $cpfPresenter = $service->addCpfApi($data['number']);

            return new JsonResponse(
                $cpfPresenter->toArray(),
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
            $service = $this->get('app.service.cpf_blacklist');
            $service->deleteCpf($id);

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

<?php
/**
 * MaxMilhas Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Presenter;

use Application\Domain\Model\CpfBlacklistInterface;

/**
 * Cpf Blacklist Presenter
 *
 * @package Application\Domain\Presenter
 */
class CpfBlacklistPresenter implements ApiPresenterInterface
{
    /**
     * @var CpfBlacklistInterface
     */
    private $cpf;

    /**
     * Cpf Blacklist Presenter constructor
     *
     * @param CpfBlacklistInterface $cpf
     */
    public function __construct(CpfBlacklistInterface $cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $createdAt = $this->cpf->getCreatedAt() instanceof \DateTime ?
            $this->cpf->getCreatedAt()->format('Y-m-d H:i:s') :
            null
        ;

        $updatedAt = $this->cpf->getUpdatedAt() instanceof \DateTime ?
            $this->cpf->getUpdatedAt()->format('Y-m-d H:i:s') :
            null
        ;

        return [
            'id' => $this->cpf->getId(),
            'number' => $this->cpf->getNumber(),
            'createdAt' => $createdAt,
            'updatedAt' => $updatedAt,
        ];
    }
}

<?php
/**
 * MaxMilhas Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace AppBundle\Repository;

use Application\Domain\Model\CpfBlacklistEventInterface;
use Application\Domain\Repository\CpfBlacklistEventRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Cpf Blacklist Event Repository
 *
 * @package AppBundle\Repository
 */
class CpfBlacklistEventRepository extends EntityRepository implements
    CpfBlacklistEventRepositoryInterface
{
    /**
     * {@inheritdoc}
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add(
        CpfBlacklistEventInterface $cpfBlacklistEvent
    ): CpfBlacklistEventInterface {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($cpfBlacklistEvent);
        $entityManager->flush();

        return $cpfBlacklistEvent;
    }

    /**
     * {@inheritdoc}
     */
    public function get(int $id): ?CpfBlacklistEventInterface
    {
        /** @var CpfBlacklistEventInterface $cpfBlacklistEvent */
        $cpfBlacklistEvent = $this->find($id);

        return $cpfBlacklistEvent;
    }

    /**
     * {@inheritdoc}
     */
    public function list(?string $number = null): array
    {
        return $this->findAll();
    }
}

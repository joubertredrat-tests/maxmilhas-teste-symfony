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
    public function list(
        ?string $sort = null,
        ?string $number = null,
        ?string $type = null
    ): array {
        $queryBuilder = $this->createQueryBuilder('e');

        if ($number) {
            $queryBuilder
                ->where('e.number = :number')
                ->setParameter('number', $number)
            ;
        }

        if ($type) {
            $queryBuilder
                ->where('e.type = :type')
                ->setParameter('type', $type)
            ;
        }

        if ($sort) {
            $queryBuilder->orderBy('e.id', $sort);
        }

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function countByEvents(): array
    {
        $queryBuilder = $this->createQueryBuilder('e');

        return $queryBuilder
            ->select('e.type', 'COUNT(e.id) AS total')
            ->groupBy('e.type')
            ->getQuery()
            ->getResult()
        ;
    }
}

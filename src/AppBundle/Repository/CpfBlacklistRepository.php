<?php
/**
 * MaxMilhas Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace AppBundle\Repository;

use Application\Domain\Model\CpfBlacklistInterface;
use Application\Domain\Repository\CpfBlacklistRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Cpf Blacklist Repository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 *
 * @package AppBundle\Repository
 */
class CpfBlacklistRepository extends EntityRepository implements CpfBlacklistRepositoryInterface
{
    /**
     * {@inheritdoc}
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add(CpfBlacklistInterface $cpf): CpfBlacklistInterface
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($cpf);
        $entityManager->flush();

        return $cpf;
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(CpfBlacklistInterface $cpf): CpfBlacklistInterface
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($cpf);
        $entityManager->flush($cpf);

        return $cpf;
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(CpfBlacklistInterface $cpf): bool
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($cpf);
        $entityManager->flush($cpf);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function get(int $id): ?CpfBlacklistInterface
    {
        /** @var CpfBlacklistInterface $cpf */
        $cpf = $this->find($id);

        return $cpf;
    }

    /**
     * {@inheritdoc}
     */
    public function getByNumber(string $number): ?CpfBlacklistInterface
    {
        /** @var CpfBlacklistInterface $cpf */
        $cpf = $this->findOneBy(['number' => $number]);

        return $cpf;
    }
}
<?php
/**
 * MaxMilhas Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Repository;

use Application\Domain\Model\CpfBlacklistEventInterface;

/**
 * Cpf Blacklist Event Repository Interface
 *
 * @package Application\Domain\Repository
 */
interface CpfBlacklistEventRepositoryInterface
{
    /**
     * @param CpfBlacklistEventInterface $cpfBlacklistEvent
     * @return CpfBlacklistEventInterface
     */
    public function add(
        CpfBlacklistEventInterface $cpfBlacklistEvent
    ): CpfBlacklistEventInterface;

    /**
     * @param int $id
     * @return CpfBlacklistEventInterface|null
     */
    public function get(int $id): ?CpfBlacklistEventInterface;

    /**
     * @param null|string $number
     * @return array
     */
    public function list(?string $number = null): array;
}

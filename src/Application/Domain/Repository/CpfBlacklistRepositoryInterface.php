<?php
/**
 * MaxMilhas Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Repository;

use Application\Domain\Model\CpfBlacklistInterface;

/**
 * Cpf Blacklist Repository Interface
 *
 * @package Application\Domain\Repository
 */
interface CpfBlacklistRepositoryInterface
{
    /**
     * @param CpfBlacklistInterface $cpf
     * @return CpfBlacklistInterface
     */
    public function add(CpfBlacklistInterface $cpf): CpfBlacklistInterface;

    /**
     * @param CpfBlacklistInterface $cpf
     * @return CpfBlacklistInterface
     */
    public function update(CpfBlacklistInterface $cpf): CpfBlacklistInterface;

    /**
     * @param CpfBlacklistInterface $cpf
     * @return bool
     */
    public function delete(CpfBlacklistInterface $cpf): bool;

    /**
     * @param int $id
     * @return CpfBlacklistInterface|null
     */
    public function get(int $id): ?CpfBlacklistInterface;

    /**
     * @param string $number
     * @return CpfBlacklistInterface|null
     */
    public function getByNumber(string $number): ?CpfBlacklistInterface;
}

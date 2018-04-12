<?php
/**
 * MaxMilhas Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Service;

use Application\Domain\Model\CpfBlacklistEvent;
use Application\Domain\Model\CpfBlacklistEventInterface;
use Application\Domain\Model\CpfBlacklistInterface;
use Application\Domain\Repository\CpfBlacklistEventRepositoryInterface;

/**
 * Cpf Blacklist Event Service
 *
 * @package Application\Domain\Service
 */
class CpfBlacklistEventService
{
    /**
     * @var CpfBlacklistEventRepositoryInterface
     */
    private $cpfBlacklistEventRepository;

    /**
     * Cpf Blacklist Event Service constructor
     *
     * @param CpfBlacklistEventRepositoryInterface $cpfBlacklistEventRepository
     */
    public function __construct(
        CpfBlacklistEventRepositoryInterface $cpfBlacklistEventRepository
    ) {
        $this->cpfBlacklistEventRepository = $cpfBlacklistEventRepository;
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function registerEventList(): void
    {
        $this->registerEvent(CpfBlacklistEvent::EVENT_TYPE_LIST);
    }

    /**
     * @param CpfBlacklistInterface $cpfBlacklist
     * @return void
     * @throws \ReflectionException
     */
    public function registerEventConsult(CpfBlacklistInterface $cpfBlacklist): void
    {
        $this->registerEvent(
            CpfBlacklistEvent::EVENT_TYPE_CONSULT,
            $cpfBlacklist->getNumber()
        );
    }

    /**
     * @param CpfBlacklistInterface $cpfBlacklist
     * @return void
     * @throws \ReflectionException
     */
    public function registerEventGet(CpfBlacklistInterface $cpfBlacklist): void
    {
        $this->registerEvent(
            CpfBlacklistEvent::EVENT_TYPE_GET,
            $cpfBlacklist->getNumber()
        );
    }

    /**
     * @param CpfBlacklistInterface $cpfBlacklist
     * @return void
     * @throws \ReflectionException
     */
    public function registerEventAdd(CpfBlacklistInterface $cpfBlacklist): void
    {
        $this->registerEvent(
            CpfBlacklistEvent::EVENT_TYPE_ADD,
            $cpfBlacklist->getNumber()
        );
    }

    /**
     * @param CpfBlacklistInterface $cpfBlacklist
     * @return void
     * @throws \ReflectionException
     */
    public function registerEventDelete(CpfBlacklistInterface $cpfBlacklist): void
    {
        $this->registerEvent(
            CpfBlacklistEvent::EVENT_TYPE_DELETE,
            $cpfBlacklist->getNumber()
        );
    }

    /**
     * @param string $type
     * @param string|null $number
     * @throws \ReflectionException
     */
    public function registerEvent(string $type, ?string $number = null): void
    {
        $cpfBlacklistEvent = new CpfBlacklistEvent($type);

        if ($number) {
            $cpfBlacklistEvent->setNumber($number);
        }

        $this->add($cpfBlacklistEvent);
    }

    /**
     * @param CpfBlacklistEventInterface $cpfBlacklistEvent
     * @return CpfBlacklistEventInterface
     */
    public function add(
        CpfBlacklistEventInterface $cpfBlacklistEvent)
    : CpfBlacklistEventInterface {
        return $this
            ->cpfBlacklistEventRepository
            ->add($cpfBlacklistEvent)
        ;
    }
}

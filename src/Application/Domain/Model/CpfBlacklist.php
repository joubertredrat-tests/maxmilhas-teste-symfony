<?php
/**
 * MaxMilhas Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Model;

/**
 * Cpf Blacklist
 *
 * @package Application\Domain\Model
 */
class CpfBlacklist implements CpfBlacklistInterface
{
    use DateTimeTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $number;

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * {@inheritdoc}
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * {@inheritdoc}
     */
    public static function isValid(?string $number): bool
    {
        if (is_null($number)) {
            return false;
        }

        $number = preg_replace("/[^0-9]/", "", $number);

        if (strlen($number) != 11) {
            return false;
        }

        if (preg_match("/^(\d)\1+$/", $number)) {
            return false;
        }

        $sum = [];

        for ($i = 0, $j = 10; $i < 9; $i++, $j--) {
            $sum[] = $number{$i} * $j;
        }

        $rest = array_sum($sum) % 11;
        $digit1 = $rest < 2 ? 0 : 11 - $rest;

        if ($number{9} != $digit1) {
            return false;
        }

        $sum = [];

        for ($i = 0, $j = 11; $i < 10; $i++, $j--) {
            $sum[] = $number{$i} * $j;
        }

        $rest = array_sum($sum) % 11;
        $digit2 = $rest < 2 ? 0 : 11 - $rest;

        return $number{10} == $digit2;
    }
}

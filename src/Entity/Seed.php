<?php

declare(strict_types=1);

namespace Alpha\VisitorTrackingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Seed
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Lifetime
     *
     * @ORM\ManyToOne(targetEntity="Lifetime", inversedBy="seeds")
     */
    protected $lifetime;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $value;

    /**
     * @param string $name
     * @param int $numberOfValues
     * @param array $weights
     */
    public function __construct(string $name, int $numberOfValues, ?array $weights = null)
    {
        $this->name = $name;
        $this->setValue($numberOfValues, $weights);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Lifetime
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * @param Lifetime $lifetime
     *
     * @return $this
     */
    public function setLifetime(Lifetime $lifetime)
    {
        $this->lifetime = $lifetime;

        if (!$this->lifetime->getSeeds()->contains($this)) {
            $this->lifetime->addSeed($this);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    private function setValue(int $numberOfValues, ?array $weights = null): void
    {
        if ($weights === null) {
            $weights = array_fill(1, $numberOfValues, 1);
        }

        if (\count($weights) !== $numberOfValues) {
            throw new \RuntimeException('Number of seed values must equal the count of the weights array');
        }

        // This does not need to be cryptographically secure, mt_rand() is roughly 2x faster than random_int().
        /** @noinspection RandomApiMigrationInspection */
        $random = mt_rand(1, array_sum($weights));
        $total = 0;

        foreach ($weights as $seed => $weight) {
            $total += $weight;
            if ($random <= $total) {

                if (!\is_string($seed)) {
                    $seed = (string) $seed;
                }

                $this->value = $seed;

                return;
            }
        }
    }
}

<?php

namespace Alpha\VisitorTrackingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Seed
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Lifetime
     * @ORM\ManyToOne(targetEntity="Lifetime", inversedBy="seeds")
     */
    protected $lifetime;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $value;

    /**
     * Seed constructor.
     * @param string $name
     * @param int $numberOfValues
     * @param array $weights
     */
    public function __construct($name, $numberOfValues, $weights = null)
    {
        $this->name = $name;
        $this->setValue($numberOfValues, $weights);
    }

    private function setValue($numberOfValues, $weights)
    {
        if($weights === null){
            $weights = array_fill(1, $numberOfValues, 1);
        }

        if(count($weights) !== $numberOfValues){
            throw new \RuntimeException("Number of seed values must equal the count of the weights array");
        }

        $random = mt_rand(1, array_sum($weights));

        $total = 0;

        foreach($weights as $seed => $weight)
        {
            $total += $weight;
            if($random <= $total){
                $this->value = $seed;
                return;
            }
        }
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
     */
    public function setLifetime(Lifetime $lifetime)
    {
        $this->lifetime = $lifetime;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }
}
<?php

namespace Alpha\VisitorTrackingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Lifetime
 * @package Alpha\VisitorTrackingBundle\Entity
 *
 * @ORM\Entity()
 */
class Lifetime
{
    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Session", mappedBy="lifetime", cascade={"persist"})
     */
    protected $sessions;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $created;

    /**
     * @var ArrayCollection|Seed[]
     * @ORM\OneToMany(targetEntity="Seed", mappedBy="lifetime", cascade={"persist"})
     */
    protected $seeds;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sessions = new ArrayCollection();
        $this->seeds = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param  \DateTime $created
     * @return Lifetime
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Add sessions
     *
     * @param  \Alpha\VisitorTrackingBundle\Entity\Session $sessions
     * @return Lifetime
     */
    public function addSession(\Alpha\VisitorTrackingBundle\Entity\Session $sessions)
    {
        $this->sessions[] = $sessions;
        $sessions->setLifetime($this);

        return $this;
    }

    /**
     * Remove sessions
     *
     * @param \Alpha\VisitorTrackingBundle\Entity\Session $sessions
     */
    public function removeSession(\Alpha\VisitorTrackingBundle\Entity\Session $sessions)
    {
        $this->sessions->removeElement($sessions);
    }

    /**
     * Get sessions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSessions()
    {
        return $this->sessions;
    }

    /**
     * @param Seed $seed
     * @return $this
     */
    public function addSeed(Seed $seed)
    {
        if (!$this->seeds->contains($seed)) {
            $seed->setLifetime($this);
            $this->seeds->add($seed);
        }

        return $this;
    }

    /**
     * @param Seed $seed
     */
    public function removeSeed(Seed $seed)
    {
        $this->seeds->removeElement($seed);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSeeds()
    {
        return $this->seeds;
    }

    /**
     * $weights is an optional array, ideally associative to name your variations and set their likelihood
     * eg you want 75% of people to see a green button and 25% to see red use:
     * $name = "button-colour-test";
     * $numberOfValues = 2;
     * $weights = ["green" => 3, "red" => 1]; (or ["green" => 75, "red" => 25])
     * This method will then return the string "green" 75% of the time and "red" 25% of the time. Since this cookie lasts 2 years, its very sticky
     * Querying your test results then becomes very easy and descriptive
     *
     * @param $name
     * @param $numberOfValues
     * @param null $weights
     * @return string
     */
    public function getSeed($name, $numberOfValues, $weights = null)
    {
        foreach($this->seeds as $seed)
        {
            if($seed->getName() === $name) {
                return $seed->getValue();
            }
        }

        $seed = new Seed($name, $numberOfValues, $weights);
        $this->addSeed($seed);

        return $seed->getValue();
    }
}

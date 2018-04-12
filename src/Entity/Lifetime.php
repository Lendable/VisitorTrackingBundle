<?php

declare(strict_types=1);

namespace Alpha\VisitorTrackingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 */
class Lifetime
{
    /**
     * @var string
     *
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $created;

    /**
     * @var Collection|Session[]
     *
     * @ORM\OneToMany(targetEntity="Session", mappedBy="lifetime", cascade={"persist"})
     */
    protected $sessions;

    /**
     * @var Collection|Seed[]
     *
     * @ORM\OneToMany(targetEntity="Seed", mappedBy="lifetime", cascade={"persist"})
     */
    protected $seeds;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
        $this->seeds = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param  \DateTime $created
     *
     * @return $this
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @param Session $session
     *
     * @return $this
     */
    public function addSession(Session $session)
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions->add($session);
        }

        if ($session->getLifetime() !== $this) {
            $session->setLifetime($this);
        }

        return $this;
    }

    /**
     * @param Session $session
     *
     * @return $this
     */
    public function removeSession(Session $session)
    {
        $this->sessions->removeElement($session);

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    /**
     * @param Seed $seed
     *
     * @return $this
     */
    public function addSeed(Seed $seed)
    {
        if (!$this->seeds->contains($seed)) {
            $this->seeds->add($seed);
        }

        $seed->setLifetime($this);

        return $this;
    }

    /**
     * @param Seed $seed
     *
     * @return $this
     */
    public function removeSeed(Seed $seed)
    {
        $this->seeds->removeElement($seed);

        return $this;
    }

    /**
     * @return Collection|Seed[]
     */
    public function getSeeds(): Collection
    {
        return $this->seeds;
    }

    /**
     * Gets a pre-existing seed, or creates a fresh seed if one does not exist for the given name.
     *
     * $weights is an optional array, ideally associative to name your variations and set their likelihood
     * eg you want 75% of people to see a green button and 25% to see red use:
     * $name = "button-colour-test";
     * $numberOfValues = 2;
     * $weights = ["green" => 3, "red" => 1]; (or ["green" => 75, "red" => 25])
     * This method will then return the string "green" 75% of the time and "red" 25% of the time. Since this cookie lasts 2 years, its very sticky
     * Querying your test results then becomes very easy and descriptive
     *
     * @param string $name
     * @param int $numberOfValues
     * @param array|null $weights
     *
     * @return string
     */
    public function getSeed(string $name, int $numberOfValues, array $weights = null): string
    {
        foreach ($this->seeds as $seed) {
            if ($seed->getName() === $name) {
                return $seed->getValue();
            }
        }

        $seed = new Seed($name, $numberOfValues, $weights);
        $this->addSeed($seed);

        return $seed->getValue();
    }

    public function hasSeed(string $name): bool
    {
        foreach ($this->seeds as $seed) {
            if ($seed->getName() === $name) {
                return true;
            }
        }

        return false;
    }
}

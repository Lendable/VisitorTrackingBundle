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
     * @ORM\Column(type="integer")
     */
    protected $seed;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sessions = new ArrayCollection();
        $this->setSeed(mt_rand(1, 100));
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
     * Set seed
     *
     * @param integer $seed
     * @return Lifetime
     */
    public function setSeed($seed)
    {
        $this->seed = $seed;

        return $this;
    }

    /**
     * Get seed
     *
     * @return integer 
     */
    public function getSeed()
    {
        return $this->seed;
    }
}

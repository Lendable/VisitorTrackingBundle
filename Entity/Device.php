<?php

namespace Alpha\VisitorTrackingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 */
class Device
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Session", inversedBy="device")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $session;

    /**
     * @ORM\Column(type="json_array")
     */
    protected $fingerprint;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $canvas;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $fonts;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $navigator;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $plugins;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $screen;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $systemColors;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $storedIds;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $created;

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    public function setSession(Session $session = null)
    {
        $this->session = $session;

        return $this;
    }

    public function getSession()
    {
        return $this->session;
    }

    public function setFingerprint($fingerprint)
    {
        $this->fingerprint = $fingerprint;

        return $this;
    }

    public function getFingerprint()
    {
        return $this->fingerprint;
    }

    /**
     * Set created
     *
     * @param  \DateTime $created
     * @return Session
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
     * Set canvas
     *
     * @param string $canvas
     * @return Device
     */
    public function setCanvas($canvas)
    {
        $this->canvas = $canvas;

        return $this;
    }

    /**
     * Get canvas
     *
     * @return string 
     */
    public function getCanvas()
    {
        return $this->canvas;
    }

    /**
     * Set fonts
     *
     * @param string $fonts
     * @return Device
     */
    public function setFonts($fonts)
    {
        $this->fonts = $fonts;

        return $this;
    }

    /**
     * Get fonts
     *
     * @return string 
     */
    public function getFonts()
    {
        return $this->fonts;
    }

    /**
     * Set navigator
     *
     * @param string $navigator
     * @return Device
     */
    public function setNavigator($navigator)
    {
        $this->navigator = $navigator;

        return $this;
    }

    /**
     * Get navigator
     *
     * @return string 
     */
    public function getNavigator()
    {
        return $this->navigator;
    }

    /**
     * Set plugins
     *
     * @param string $plugins
     * @return Device
     */
    public function setPlugins($plugins)
    {
        $this->plugins = $plugins;

        return $this;
    }

    /**
     * Get plugins
     *
     * @return string 
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    /**
     * Set screen
     *
     * @param string $screen
     * @return Device
     */
    public function setScreen($screen)
    {
        $this->screen = $screen;

        return $this;
    }

    /**
     * Get screen
     *
     * @return string 
     */
    public function getScreen()
    {
        return $this->screen;
    }

    /**
     * Set systemColors
     *
     * @param string $systemColors
     * @return Device
     */
    public function setSystemColors($systemColors)
    {
        $this->systemColors = $systemColors;

        return $this;
    }

    /**
     * Get systemColors
     *
     * @return string 
     */
    public function getSystemColors()
    {
        return $this->systemColors;
    }

    /**
     * Set storedIds
     *
     * @param string $storedIds
     * @return Device
     */
    public function setStoredIds($storedIds)
    {
        $this->storedIds = $storedIds;

        return $this;
    }

    /**
     * Get storedIds
     *
     * @return string 
     */
    public function getStoredIds()
    {
        return $this->storedIds;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 08/09/14
 * Time: 19:30
 */

namespace Alpha\VisitorTrackingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Session
 * @package Alpha\VisitorTrackingBundle\Entity
 *
 * @ORM\Entity()
 */
class Session
{
    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Lifetime", inversedBy="sessions")
     */
    protected $lifetime;

    /**
     * @ORM\OneToMany(targetEntity="PageView", mappedBy="session", cascade={"persist"})
     */
    protected $pageViews;

    /**
     * @ORM\OneToMany(targetEntity="Device", mappedBy="session", cascade={"persist"})
     */
    protected $devices;

    /**
     * @ORM\Column(type="string")
     */
    protected $ip;

    /**
     * @ORM\Column(type="string")
     */
    protected $referrer;

    /**
     * @ORM\Column(type="string")
     */
    protected $userAgent;

    /**
     * @ORM\Column(type="string")
     */
    protected $queryString;

    /**
     * @ORM\Column(type="string")
     */
    protected $utmSource;

    /**
     * @ORM\Column(type="string")
     */
    protected $utmMedium;

    /**
     * @ORM\Column(type="string")
     */
    protected $utmCampaign;

    /**
     * @ORM\Column(type="string")
     */
    protected $utmTerm;

    /**
     * @ORM\Column(type="string")
     */
    protected $utmContent;

    /**
     * @ORM\Column(type="string")
     */
    protected $loanTerm;

    /**
     * @ORM\Column(type="string")
     */
    protected $repApr;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $created;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pageViews = new \Doctrine\Common\Collections\ArrayCollection();
        $this->devices = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getId();
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
     * Set ip
     *
     * @param  string $ip
     * @return Session
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set referrer
     *
     * @param  string $referrer
     * @return Session
     */
    public function setReferrer($referrer)
    {
        $this->referrer = $referrer;

        return $this;
    }

    /**
     * Get referrer
     *
     * @return string
     */
    public function getReferrer()
    {
        return $this->referrer;
    }

    /**
     * Set userAgent
     *
     * @param  string $userAgent
     * @return Session
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Get userAgent
     *
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Set queryString
     *
     * @param  string $queryString
     * @return Session
     */
    public function setQueryString($queryString)
    {
        $this->queryString = $queryString;

        return $this;
    }

    /**
     * Get queryString
     *
     * @return string
     */
    public function getQueryString()
    {
        return $this->queryString;
    }

    /**
     * Set utmSource
     *
     * @param  string $utmSource
     * @return Session
     */
    public function setUtmSource($utmSource)
    {
        $this->utmSource = $utmSource;

        return $this;
    }

    /**
     * Get utmSource
     *
     * @return string
     */
    public function getUtmSource()
    {
        return $this->utmSource;
    }

    /**
     * Set utmMedium
     *
     * @param  string $utmMedium
     * @return Session
     */
    public function setUtmMedium($utmMedium)
    {
        $this->utmMedium = $utmMedium;

        return $this;
    }

    /**
     * Get utmMedium
     *
     * @return string
     */
    public function getUtmMedium()
    {
        return $this->utmMedium;
    }

    /**
     * Set utmCampaign
     *
     * @param  string $utmCampaign
     * @return Session
     */
    public function setUtmCampaign($utmCampaign)
    {
        $this->utmCampaign = $utmCampaign;

        return $this;
    }

    /**
     * Get utmCampaign
     *
     * @return string
     */
    public function getUtmCampaign()
    {
        return $this->utmCampaign;
    }

    /**
     * Set utmTerm
     *
     * @param  string $utmTerm
     * @return Session
     */
    public function setUtmTerm($utmTerm)
    {
        $this->utmTerm = $utmTerm;

        return $this;
    }

    /**
     * Get utmTerm
     *
     * @return string
     */
    public function getUtmTerm()
    {
        return $this->utmTerm;
    }

    /**
     * Set utmContent
     *
     * @param  string $utmContent
     * @return Session
     */
    public function setUtmContent($utmContent)
    {
        $this->utmContent = $utmContent;

        return $this;
    }

    /**
     * Get utmContent
     *
     * @return string
     */
    public function getUtmContent()
    {
        return $this->utmContent;
    }

    /**
     * Set loanTerm
     *
     * @param  string $loanTerm
     * @return Session
     */
    public function setLoanTerm($loanTerm)
    {
        $this->loanTerm = $loanTerm;

        return $this;
    }

    /**
     * Get loanTerm
     *
     * @return string
     */
    public function getLoanTerm()
    {
        return $this->loanTerm;
    }

    /**
     * Set repApr
     *
     * @param  string $repApr
     * @return Session
     */
    public function setRepApr($repApr)
    {
        $this->repApr = $repApr;

        return $this;
    }

    /**
     * Get repApr
     *
     * @return string
     */
    public function getRepApr()
    {
        return $this->repApr;
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
     * Set lifetime
     *
     * @param  \Alpha\VisitorTrackingBundle\Entity\Lifetime $lifetime
     * @return Session
     */
    public function setLifetime(\Alpha\VisitorTrackingBundle\Entity\Lifetime $lifetime = null)
    {
        $this->lifetime = $lifetime;

        return $this;
    }

    /**
     * Get lifetime
     *
     * @return \Alpha\VisitorTrackingBundle\Entity\Lifetime
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * Add pageViews
     *
     * @param  \Alpha\VisitorTrackingBundle\Entity\PageView $pageViews
     * @return Session
     */
    public function addPageView(\Alpha\VisitorTrackingBundle\Entity\PageView $pageViews)
    {
        $this->pageViews[] = $pageViews;
        $pageViews->setSession($this);

        return $this;
    }

    /**
     * Remove pageViews
     *
     * @param \Alpha\VisitorTrackingBundle\Entity\PageView $pageViews
     */
    public function removePageView(\Alpha\VisitorTrackingBundle\Entity\PageView $pageViews)
    {
        $this->pageViews->removeElement($pageViews);
    }

    public function addDevice(Device $device)
    {
        $this->devices[] = $device;
        $device->setSession($this);

        return $this;
    }

    public function removeDevice(Device $device)
    {
        $this->devices->removeElement($device);
    }

    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * Get pageViews
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPageViews()
    {
        return $this->pageViews;
    }
}

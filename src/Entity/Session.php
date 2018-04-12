<?php

declare(strict_types=1);

namespace Alpha\VisitorTrackingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 * @ORM\Table(name="session",indexes={@ORM\Index(name="session_created_index", columns={"created"})})
 */
class Session
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
     * @var Lifetime
     *
     * @ORM\ManyToOne(targetEntity="Lifetime", inversedBy="sessions")
     */
    protected $lifetime;

    /**
     * @var Collection|PageView[]
     *
     * @ORM\OneToMany(targetEntity="PageView", mappedBy="session", cascade={"persist"}, fetch="EXTRA_LAZY")
     */
    protected $pageViews;

    /**
     * @var Collection|Device[]
     *
     * @ORM\OneToMany(targetEntity="Device", mappedBy="session", cascade={"persist"})
     */
    protected $devices;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $ip;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $referrer;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $userAgent;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $queryString;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $utmSource;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $utmMedium;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $utmCampaign;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $utmTerm;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $utmContent;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $loanTerm;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $repApr;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $created;

    public function __construct()
    {
        $this->pageViews = new ArrayCollection();
        $this->devices = new ArrayCollection();
    }

    public function __toString(): string
    {
        $id = $this->getId();

        if (!\is_string($id)) {
            return 'N/A';
        }

        return $id;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param  string $ip
     *
     * @return Session
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return string
     */
    public function getReferrer()
    {
        return $this->referrer;
    }

    /**
     * @param  string $referrer
     *
     * @return Session
     */
    public function setReferrer($referrer)
    {
        $this->referrer = $referrer;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @param  string $userAgent
     *
     * @return Session
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * @return string
     */
    public function getQueryString()
    {
        return $this->queryString;
    }

    /**
     * @param  string $queryString
     *
     * @return Session
     */
    public function setQueryString($queryString)
    {
        $this->queryString = $queryString;

        return $this;
    }

    /**
     * @return string
     */
    public function getUtmSource()
    {
        return $this->utmSource;
    }

    /**
     * @param  string $utmSource
     *
     * @return Session
     */
    public function setUtmSource($utmSource)
    {
        $this->utmSource = $utmSource;

        return $this;
    }

    /**
     * @return string
     */
    public function getUtmMedium()
    {
        return $this->utmMedium;
    }

    /**
     * @param  string $utmMedium
     *
     * @return Session
     */
    public function setUtmMedium($utmMedium)
    {
        $this->utmMedium = $utmMedium;

        return $this;
    }

    /**
     * @return string
     */
    public function getUtmCampaign()
    {
        return $this->utmCampaign;
    }

    /**
     * @param  string $utmCampaign
     *
     * @return Session
     */
    public function setUtmCampaign($utmCampaign)
    {
        $this->utmCampaign = $utmCampaign;

        return $this;
    }

    /**
     * @return string
     */
    public function getUtmTerm()
    {
        return $this->utmTerm;
    }

    /**
     * @param  string $utmTerm
     *
     * @return Session
     */
    public function setUtmTerm($utmTerm)
    {
        $this->utmTerm = $utmTerm;

        return $this;
    }

    /**
     * @return string
     */
    public function getUtmContent()
    {
        return $this->utmContent;
    }

    /**
     * @param  string $utmContent
     *
     * @return Session
     */
    public function setUtmContent($utmContent)
    {
        $this->utmContent = $utmContent;

        return $this;
    }

    /**
     * @return string
     */
    public function getLoanTerm()
    {
        return $this->loanTerm;
    }

    /**
     * @param  string $loanTerm
     *
     * @return Session
     */
    public function setLoanTerm($loanTerm)
    {
        $this->loanTerm = $loanTerm;

        return $this;
    }

    /**
     * @return string
     */
    public function getRepApr()
    {
        return $this->repApr;
    }

    /**
     * @param  string $repApr
     *
     * @return Session
     */
    public function setRepApr($repApr)
    {
        $this->repApr = $repApr;

        return $this;
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
     * @return Session
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return Lifetime
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * @param  Lifetime $lifetime
     *
     * @return Session
     */
    public function setLifetime(?Lifetime $lifetime = null)
    {
        $this->lifetime = $lifetime;

        if ($lifetime instanceof Lifetime && !$this->lifetime->getSessions()->contains($this)) {
            $this->lifetime->addSession($this);
        }

        return $this;
    }

    /**
     * @param  PageView $pageView
     *
     * @return Session
     */
    public function addPageView(PageView $pageView)
    {
        if ($pageView->getSession() !== $this) {
            $pageView->setSession($this);
        }

        if (!$this->pageViews->contains($pageView)) {
            $this->pageViews->add($pageView);
        }

        return $this;
    }

    /**
     * @param PageView $pageViews
     *
     * @return $this
     */
    public function removePageView(PageView $pageViews)
    {
        $this->pageViews->removeElement($pageViews);

        return $this;
    }

    public function addDevice(Device $device)
    {
        if ($device->getSession() !== $this) {
            $device->setSession($this);
        }

        if (!$this->devices->contains($device)) {
            $this->devices->add($device);
        }

        return $this;
    }

    /**
     * @param Device $device
     *
     * @return $this
     */
    public function removeDevice(Device $device)
    {
        $this->devices->removeElement($device);

        return $this;
    }

    /**
     * @return Collection|Device[]
     */
    public function getDevices(): Collection
    {
        return $this->devices;
    }

    /**
     * @return Collection|PageView[]
     */
    public function getPageViews(): Collection
    {
        return $this->pageViews;
    }
}

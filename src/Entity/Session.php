<?php

declare(strict_types=1);

namespace Alpha\VisitorTrackingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="session", indexes={@ORM\Index(name="session_created_index", columns={"created"})})
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
     * @var Lifetime|null
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
     * @param string $ip
     */
    public function setIp($ip): self
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
     * @param string $referrer
     */
    public function setReferrer($referrer): self
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
     * @param string $userAgent
     */
    public function setUserAgent($userAgent): self
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
     * @param string $queryString
     */
    public function setQueryString($queryString): self
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
     * @param string $utmSource
     */
    public function setUtmSource($utmSource): self
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
     * @param string $utmMedium
     */
    public function setUtmMedium($utmMedium): self
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
     * @param string $utmCampaign
     */
    public function setUtmCampaign($utmCampaign): self
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
     * @param string $utmTerm
     */
    public function setUtmTerm($utmTerm): self
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
     * @param string $utmContent
     */
    public function setUtmContent($utmContent): self
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
     * @param string $loanTerm
     */
    public function setLoanTerm($loanTerm): self
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
     * @param string $repApr
     */
    public function setRepApr($repApr): self
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

    public function setCreated(\DateTime $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return Lifetime|null
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    public function setLifetime(?Lifetime $lifetime = null): self
    {
        $this->lifetime = $lifetime;

        if ($lifetime instanceof Lifetime && $this->lifetime instanceof Lifetime && !$this->lifetime->getSessions()->contains($this)) {
            $this->lifetime->addSession($this);
        }

        return $this;
    }

    public function addPageView(PageView $pageView): self
    {
        if ($pageView->getSession() !== $this) {
            $pageView->setSession($this);
        }

        if (!$this->pageViews->contains($pageView)) {
            $this->pageViews->add($pageView);
        }

        return $this;
    }

    public function removePageView(PageView $pageViews): self
    {
        $this->pageViews->removeElement($pageViews);

        return $this;
    }

    public function addDevice(Device $device): self
    {
        if ($device->getSession() !== $this) {
            $device->setSession($this);
        }

        if (!$this->devices->contains($device)) {
            $this->devices->add($device);
        }

        return $this;
    }

    public function removeDevice(Device $device): self
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

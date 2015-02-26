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
 * Class PageView
 * @package Alpha\VisitorTrackingBundle\Entity
 * @ORM\Entity()
 */
class PageView
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Session", inversedBy="pageViews")
     */
    protected $session;

    /**
     * @ORM\Column(type="string")
     */
    protected $url;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $created;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param  string   $url
     * @return PageView
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set created
     *
     * @param  \DateTime $created
     * @return PageView
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
     * Set session
     *
     * @param  \Alpha\VisitorTrackingBundle\Entity\Session $session
     * @return PageView
     */
    public function setSession(\Alpha\VisitorTrackingBundle\Entity\Session $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return \Alpha\VisitorTrackingBundle\Entity\Session
     */
    public function getSession()
    {
        return $this->session;
    }
}

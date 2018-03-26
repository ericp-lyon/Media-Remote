<?php

namespace MediaRemoteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Media
 *
 * @ORM\Table(name="media", uniqueConstraints={@ORM\UniqueConstraint(name="media_name", columns={"media_name"})})
 * @ORM\Entity
 */
class Media
{
    /**
     * @var string
     *
     * @ORM\Column(name="media_name", type="string", length=255, nullable=false)
     */
    private $mediaName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="media_description", type="string", length=255, nullable=false)
     */
    private $mediaDescription;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="media_active", type="boolean", nullable=false)
     */
    private $mediaActive;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="media_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $mediaId;
    
    
    
    /**
     * Set mediaName
     *
     * @param string $mediaName
     *
     * @return Media
     */
    public function setMediaName($mediaName)
    {
        $this->mediaName = $mediaName;
        
        return $this;
    }
    
    /**
     * Get mediaName
     *
     * @return string
     */
    public function getMediaName()
    {
        return $this->mediaName;
    }
    
    /**
     * Set mediaDescription
     *
     * @param string $mediaDescription
     *
     * @return Media
     */
    public function setMediaDescription($mediaDescription)
    {
        $this->mediaDescription = $mediaDescription;
        
        return $this;
    }
    
    /**
     * Get mediaDescription
     *
     * @return string
     */
    public function getMediaDescription()
    {
        return $this->mediaDescription;
    }
    
    /**
     * Set mediaActive
     *
     * @param boolean $mediaActive
     *
     * @return Media
     */
    public function setMediaActive($mediaActive)
    {
        $this->mediaActive = $mediaActive;
        
        return $this;
    }
    
    /**
     * Get mediaActive
     *
     * @return boolean
     */
    public function getMediaActive()
    {
        return $this->mediaActive;
    }
    
    /**
     * Get mediaId
     *
     * @return integer
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }
}


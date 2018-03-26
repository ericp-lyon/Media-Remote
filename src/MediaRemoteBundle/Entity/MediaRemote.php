<?php

namespace MediaRemoteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MediaRemote
 *
 * @ORM\Table(name="media_remote", uniqueConstraints={@ORM\UniqueConstraint(name="remote_id_2", columns={"remote_id", "media_id"})}, indexes={@ORM\Index(name="remote_id", columns={"remote_id"}), @ORM\Index(name="media_id", columns={"media_id"})})
 * @ORM\Entity(repositoryClass="MediaRemoteBundle\Repository\MediaRemoteRepository")
 */
class MediaRemote
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="media_remote_active", type="boolean", nullable=false)
     */
    private $mediaRemoteActive;

    /**
     * @var integer
     *
     * @ORM\Column(name="media_remote_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $mediaRemoteId;

    /**
     * @var \MediaRemoteBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="MediaRemoteBundle\Entity\Media")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="media_id", referencedColumnName="media_id")
     * })
     */
    private $media;

    /**
     * @var \MediaRemoteBundle\Entity\Remote
     *
     * @ORM\ManyToOne(targetEntity="MediaRemoteBundle\Entity\Remote")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="remote_id", referencedColumnName="remote_id")
     * })
     */
    private $remote;



    /**
     * Set mediaRemoteActive
     *
     * @param boolean $mediaRemoteActive
     *
     * @return MediaRemote
     */
    public function setMediaRemoteActive($mediaRemoteActive)
    {
        $this->mediaRemoteActive = $mediaRemoteActive;

        return $this;
    }

    /**
     * Get mediaRemoteActive
     *
     * @return boolean
     */
    public function getMediaRemoteActive()
    {
        return $this->mediaRemoteActive;
    }

    /**
     * Get mediaRemoteId
     *
     * @return integer
     */
    public function getMediaRemoteId()
    {
        return $this->mediaRemoteId;
    }

    /**
     * Set media
     *
     * @param \MediaRemoteBundle\Entity\Media $media
     *
     * @return MediaRemote
     */
    public function setMedia(\MediaRemoteBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \MediaRemoteBundle\Entity\Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set remote
     *
     * @param \MediaRemoteBundle\Entity\Remote $remote
     *
     * @return MediaRemote
     */
    public function setRemote(\MediaRemoteBundle\Entity\Remote $remote = null)
    {
        $this->remote = $remote;

        return $this;
    }

    /**
     * Get remote
     *
     * @return \MediaRemoteBundle\Entity\Remote
     */
    public function getRemote()
    {
        return $this->remote;
    }
}

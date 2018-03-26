<?php

namespace MediaRemoteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Remote
 *
 * @ORM\Table(name="remote", uniqueConstraints={@ORM\UniqueConstraint(name="remote_name", columns={"remote_name"})})
 * @ORM\Entity
 */
class Remote
{
    /**
     * @var string
     *
     * @ORM\Column(name="remote_name", type="string", length=255, nullable=false)
     */
    private $remoteName;

    /**
     * @var integer
     *
     * @ORM\Column(name="remote_duration", type="integer", nullable=false)
     */
    private $remoteDuration;

    /**
     * @var integer
     *
     * @ORM\Column(name="remote_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $remoteId;



    /**
     * Set remoteName
     *
     * @param string $remoteName
     *
     * @return Remote
     */
    public function setRemoteName($remoteName)
    {
        $this->remoteName = $remoteName;

        return $this;
    }

    /**
     * Get remoteName
     *
     * @return string
     */
    public function getRemoteName()
    {
        return $this->remoteName;
    }

    /**
     * Set remoteDuration
     *
     * @param integer $remoteDuration
     *
     * @return Remote
     */
    public function setRemoteDuration($remoteDuration)
    {
        $this->remoteDuration = $remoteDuration;

        return $this;
    }

    /**
     * Get remoteDuration
     *
     * @return integer
     */
    public function getRemoteDuration()
    {
        return $this->remoteDuration;
    }

    /**
     * Get remoteId
     *
     * @return integer
     */
    public function getRemoteId()
    {
        return $this->remoteId;
    }
}

<?php

namespace Acme\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 * @ORM\Entity
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="text", type="string", length=255)
     */
    protected $text;

    /**
     * @ORM\ManyToOne(targetEntity="Acme\UserBundle\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user = null;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    public function __construct($text = null)
    {
        $this->text = $text;
        $this->created = new \DateTime();
    }

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
     * Set text
     *
     * @param string $text
     * @return Comment
     */
    public function setText($text)
    {
        $this->text = $text;
    
        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set post
     *
     * @param \Acme\BlogBundle\Entity\Post $post
     * @return Comment
     */
    public function setPost(\Acme\BlogBundle\Entity\Post $post = null)
    {
        $this->post = $post;
    
        return $this;
    }

    /**
     * Get post
     *
     * @return \Acme\BlogBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Comment
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
     * Set user
     *
     * @param \Acme\UserBundle\Entity\User $user
     * @return Comment
     */
    public function setUser(\Acme\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Acme\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
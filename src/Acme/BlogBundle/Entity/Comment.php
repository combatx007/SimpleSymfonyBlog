<?php

namespace Acme\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Comment as BaseComment;

/**
 * @ORM\Entity
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Comment extends BaseComment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Thread of this comment
     *
     * @var Thread
     * @ORM\ManyToOne(targetEntity="Acme\BlogBundle\Entity\Thread")
     */
    protected $thread;

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
     * Get thread
     *
     * @return \Acme\BlogBundle\Entity\Thread 
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Set thread
     *
     * @param \Acme\BlogBundle\Entity\Thread $thread
     * @return Comment
     */

    /**
     * Set thread
     *
     * @param \Acme\BlogBundle\Entity\Thread $thread
     * @return Comment
     */

    /**
     * Set thread
     *
     * @param \Acme\BlogBundle\Entity\Thread $thread
     * @return Comment
     */
}
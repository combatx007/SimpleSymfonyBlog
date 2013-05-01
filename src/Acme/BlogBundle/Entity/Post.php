<?php


namespace Acme\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping\HasLifecycleCallBacks;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity HasLifecycleCallBacks
 * @ORM\Table(name="post")
*/
class Post
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $description;

    /**
     * @ORM\Column(type="string")
     */
    protected $keyword;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\ManyToOne(targetEntity="Acme\UserBundle\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="Acme\BlogBundle\Entity\Comment", mappedBy="post")
     */
    protected $comments;

    /**
     * @ORM\Column(type="text")
     */
    protected $annotation;

    /**
     * @ORM\Column(type="text")
     */
    protected $post;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
        $this->comments = new ArrayCollection();
        $this->user = new ArrayCollection();
    }

    /**
     * @ORM\PreUpdate
     */
    public function doStuffOnPreUpdate()
    {
        $this->setCreated($this->getCreated());
        $this->setUpdated($this->getUpdated());
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
     * Set title
     *
     * @param string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set user
     *
     * @param string $user
     * @return Post
     */
    public function setUser($user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set post
     *
     * @param string $post
     * @return Post
     */
    public function setPost($post)
    {
        $this->post = $post;
    
        return $this;
    }

    /**
     * Get post
     *
     * @return string 
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Post
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
     * Set updated
     *
     * @param \DateTime $updated
     * @return Post
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Post
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set keyword
     *
     * @param string $keyword
     * @return Post
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    
        return $this;
    }

    /**
     * Get keyword
     *
     * @return string 
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Set annotation
     *
     * @param string $annotation
     * @return Post
     */
    public function setAnnotation($annotation)
    {
        $this->annotation = $annotation;
    
        return $this;
    }

    /**
     * Get annotation
     *
     * @return string 
     */
    public function getAnnotation()
    {
        return $this->annotation;
    }

    /**
     * Add comments
     *
     * @param \Acme\BlogBundle\Entity\Comment $comments
     * @return Post
     */
    public function addComment(\Acme\BlogBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;
    
        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Acme\BlogBundle\Entity\Comment $comments
     */
    public function removeComment(\Acme\BlogBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
}
<?php


namespace Acme\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 * @ORM\Entity
*/
class Tag
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
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Acme\BlogBundle\Entity\Post", mappedBy="tags")
     */
    protected $posts;

    /**
     * @ORM\Column(type="integer")
     */
    protected $count;

    public function __construct($text = null)
    {
        $this->text = $text;
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
     * @return Tag
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
     * Add posts
     *
     * @param \Acme\BlogBundle\Entity\Post $posts
     * @return Tag
     */
    public function addPost(\Acme\BlogBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;

        return $this;
    }

    /**
     * Remove posts
     *
     * @param \Acme\BlogBundle\Entity\Post $posts
     */
    public function removePost(\Acme\BlogBundle\Entity\Post $posts)
    {
        $this->posts->removeElement($posts);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPosts()
    {
        return $this->posts;
    }

    public function __toString()
    {
        return $this->getText();
    }

    /**
     * Set count
     *
     * @param integer $count
     * @return Tag
     */
    public function setCount($count)
    {
        $this->count = $count;
    
        return $this;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }
}
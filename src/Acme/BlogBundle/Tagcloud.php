<?php
namespace Acme\BlogBundle;

use Acme\BlogBundle\Entity\Post;
use Acme\BlogBundle\Entity\Tag;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Tagcloud {

    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function check(EntityManager $em)
    {
        $dql = "SELECT a.id FROM AcmeBlogBundle:Post u JOIN u.tags a";
        $query = $em->createQuery($dql);

        $id = $query->getResult();

        $dql = "SELECT u.id FROM AcmeBlogBundle:Tag u";
        $query = $em->createQuery($dql);

        $idt = $query->getResult();

        $dql = "SELECT COUNT(u.id) FROM AcmeBlogBundle:Tag u";
        $query = $em->createQuery($dql);

        $idtc = $query->getResult();

        $dql = "SELECT COUNT(a.id) FROM AcmeBlogBundle:Post u JOIN u.tags a";
        $query = $em->createQuery($dql);
        $count = $query->getResult();
        $offset = $count['0']['1'];

        $collection = array();
        for ($k = 0; $k < $offset; $k++){
            for($i = 0; $i < $idtc['0']['1']; $i++){
                if ($idt[$i]['id'] == $id[$k]['id']){
                    $c = $idt[$i]['id'];
                    $collection[$c] = $collection[$c] + 1;
                }

            }
        }
        foreach ( $collection as $key => $value ){
            $dql = "UPDATE AcmeBlogBundle:Tag u SET u.count = $value WHERE u.id IN ($key)";
            $query = $em->createQuery($dql);
            $result = $query->getResult();
        }
    }
}

<?php
namespace Acme\BlogBundle;

use Acme\BlogBundle\Entity\Post;
use Acme\BlogBundle\Entity\Tag;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Tagcloud {

    /**
     *
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function check()
    {
        $emm = $this->em;
        $dql = "SELECT a.id FROM AcmeBlogBundle:Post u JOIN u.tags a";
        $query = $emm->createQuery($dql);

        $id = $query->getResult();

        $dql = "SELECT u.id FROM AcmeBlogBundle:Tag u";
        $query = $emm->createQuery($dql);

        $idt = $query->getResult();

        $dql = "SELECT COUNT(u.id) FROM AcmeBlogBundle:Tag u";
        $query = $emm->createQuery($dql);

        $idtc = $query->getResult();

        $dql = "SELECT COUNT(a.id) FROM AcmeBlogBundle:Post u JOIN u.tags a";
        $query = $emm->createQuery($dql);
        $count = $query->getResult();
        $offset = $count['0']['1'];

        $collection = array();
        for ($k = 0; $k < $offset; $k++){
            for($i = 0; $i < $idtc['0']['1']; $i++){
                if ($idt[$i]['id'] == $id[$k]['id']){
                    $c = $idt[$i]['id'];
                    @$collection[$c] = $collection[$c] + 1;
                }

            }
        }
        foreach ( $collection as $key => $value ){
            $dql = "UPDATE AcmeBlogBundle:Tag u SET u.count = $value WHERE u.id IN ($key)";
            $query = $emm->createQuery($dql);
            $result = $query->getResult();
        }
    }
}

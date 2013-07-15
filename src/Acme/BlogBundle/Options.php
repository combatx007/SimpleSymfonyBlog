<?php
namespace Acme\BlogBundle;
use Doctrine\ORM\EntityManager;

class Options {

    /**
     *
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getOptions()
    {
        $emm = $this->em;
        $dql = "SELECT u.id FROM AcmeBlogBundle:Options u";
        $query = $emm->createQuery($dql);

        $id = $query->getResult();
        $id = $id['0']['id'];


        $option = $emm->find('AcmeBlogBundle:Options', $id);

        return $option;
    }
}

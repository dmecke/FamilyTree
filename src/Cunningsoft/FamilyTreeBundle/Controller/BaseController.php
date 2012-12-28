<?php

namespace Cunningsoft\FamilyTreeBundle\Controller;

use Cunningsoft\FamilyTreeBundle\Entity\Person;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class BaseController extends Controller
{
    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @param int $id
     * @return Person
     */
    protected function findPersonById($id)
    {
        return $this->getEntityManager()->getRepository('FamilyTreeBundle:Person')->find($id);
    }
}

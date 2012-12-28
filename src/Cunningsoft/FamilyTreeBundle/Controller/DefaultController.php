<?php

namespace Cunningsoft\FamilyTreeBundle\Controller;

use Cunningsoft\FamilyTreeBundle\Entity\Person;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends BaseController
{
    /**
     * @return array
     *
     * @Route("/tree", name="tree")
     * @Template
     */
    public function treeAction()
    {
        return array(
            'rootPerson' => $this->getEntityManager()->getRepository('FamilyTreeBundle:Person')->findOneBy(array('firstname' => 'Daniel', 'lastname' => 'Mecke')),
        );
    }

    /**
     * @param int $childId
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @Route("/addFather/{childId}", name="addFather")
     */
    public function addFatherAction($childId, Request $request)
    {
        $person = new Person();
        $person->setFirstname($request->get('firstname'));
        $person->setLastname($request->get('lastname'));
        $this->findPersonById($childId)->setFather($person);
        $this->getEntityManager()->persist($person);
        $this->getEntityManager()->flush();

        return $this->redirect($this->generateUrl('tree'));
    }

    /**
     * @param int $childId
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @Route("/addMother/{childId}", name="addMother")
     */
    public function addMotherAction($childId, Request $request)
    {
        $person = new Person();
        $person->setFirstname($request->get('firstname'));
        $person->setLastname($request->get('lastname'));
        $this->findPersonById($childId)->setMother($person);
        $this->getEntityManager()->persist($person);
        $this->getEntityManager()->flush();

        return $this->redirect($this->generateUrl('tree'));
    }
}

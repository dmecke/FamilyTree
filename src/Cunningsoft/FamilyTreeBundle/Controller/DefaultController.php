<?php

namespace Cunningsoft\FamilyTreeBundle\Controller;

use Cunningsoft\FamilyTreeBundle\Entity\Person;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @param Person $child
     *
     * @return RedirectResponse
     *
     * @Route("/addFather/{id}", name="addFather")
     */
    public function addFatherAction(Person $child)
    {
        $person = new Person();
        $child->setFather($person);
        $this->getEntityManager()->persist($person);
        $this->getEntityManager()->flush();

        return $this->redirect($this->generateUrl('tree'));
    }

    /**
     * @param Person $child
     *
     * @return RedirectResponse
     *
     * @Route("/addMother/{id}", name="addMother")
     */
    public function addMotherAction(Person $child)
    {
        $person = new Person();
        $child->setMother($person);
        $this->getEntityManager()->persist($person);
        $this->getEntityManager()->flush();

        return $this->redirect($this->generateUrl('tree'));
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/edit", name="edit")
     */
    public function editAction(Request $request)
    {
        list($field, $id) = explode('_', $request->get('id'));
        $setter = 'set' . ucfirst($field);

        if (in_array($field, array('dateOfBirth', 'dateOfDeath'))) {
            $value = new \DateTime($request->get('value'));
        } else {
            $value = $request->get('value');
        }

        $person = $this->findPersonById($id);
        $person->$setter($value);
        $this->getEntityManager()->flush();

        return new Response($request->get('value'));
    }
}

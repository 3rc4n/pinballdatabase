<?php

namespace Pinball\PinballBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pinball\PinballBundle\Entity\Tables;
use Pinball\PinballBundle\Form\TablesType;

/**
 * Tables controller.
 *
 * @Route("/tables")
 */
class TablesController extends Controller
{

    /**
     * Lists all Tables entities.
     *
     * @Route("/", name="tables")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {   
        
        $repository = $this->getDoctrine()->getRepository('PinballPinballBundle:Tables');
        
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PinballPinballBundle:Tables')->findAll();
        
        return array(
            'entities' => $entities,
            'manufacturers' => $this->getManufacturers()
        );
    }
    /**
     * Creates a new Tables entity.
     *
     * @Route("/", name="tables_create")
     * @Method("POST")
     * @Template("PinballPinballBundle:Tables:new.html.twig")
     */
    public function createAction(Request $request)
    {
        
        $entity = new Tables();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            return $this->redirect($this->generateUrl('tables_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Tables entity.
     *
     * @param Tables $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Tables $entity)
    {
        $form = $this->createForm(new TablesType(), $entity, array(
            'action' => $this->generateUrl('tables_create'),
            'method' => 'POST',
        ));
        
        $form->add('manufacturer_id', 'choice', array(
            'choices' => $this->getManufacturers() )
        );
        
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
    
    /**
     * Returns an Array of the Manufacturers table
     * 
     */
    private function getManufacturers() {
        $em = $this->getDoctrine()->getManager();
        $manufacturers = $em->getRepository('PinballPinballBundle:Manufacturer')->findAll();
        
        $a_manufacturer = array();
        
        foreach ( $manufacturers as $key => $value ) {
            list( $i_manufacturer_id, $s_manufacturer_name ) = array_values( (array)$value );
            $a_manufacturer[ $i_manufacturer_id ] = $s_manufacturer_name;
        }
        return $a_manufacturer;
    }
    
    /**
     * Displays a form to create a new Tables entity.
     *
     * @Route("/new", name="tables_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        
        $entity = new Tables();
        $form   = $this->createCreateForm($entity);
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Tables entity.
     *
     * @Route("/{id}", name="tables_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PinballPinballBundle:Tables')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tables entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'manufacturers' => $this->getManufacturers(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Tables entity.
     *
     * @Route("/{id}/edit", name="tables_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PinballPinballBundle:Tables')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tables entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Tables entity.
    *
    * @param Tables $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Tables $entity)
    {
        $form = $this->createForm(new TablesType(), $entity, array(
            'action' => $this->generateUrl('tables_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        
        $form->add('manufacturer_id', 'choice', array(
            'choices' => $this->getManufacturers() )
        );
        
        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Tables entity.
     *
     * @Route("/{id}", name="tables_update")
     * @Method("PUT")
     * @Template("PinballPinballBundle:Tables:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PinballPinballBundle:Tables')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tables entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tables_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Tables entity.
     *
     * @Route("/{id}", name="tables_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PinballPinballBundle:Tables')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tables entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tables'));
    }

    /**
     * Creates a form to delete a Tables entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tables_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

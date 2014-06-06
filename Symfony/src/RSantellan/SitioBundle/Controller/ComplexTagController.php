<?php

namespace RSantellan\SitioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use RSantellan\SitioBundle\Entity\ComplexTag;
use RSantellan\SitioBundle\Form\ComplexTagType;

/**
 * ComplexTag controller.
 *
 */
class ComplexTagController extends Controller
{

    /**
     * Lists all ComplexTag entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RSantellanSitioBundle:ComplexTag')->findAll();

        return $this->render('RSantellanSitioBundle:ComplexTag:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ComplexTag entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ComplexTag();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_blocktags_show', array('id' => $entity->getId())));
        }

        return $this->render('RSantellanSitioBundle:ComplexTag:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a ComplexTag entity.
    *
    * @param ComplexTag $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ComplexTag $entity)
    {
        $form = $this->createForm(new ComplexTagType(), $entity, array(
            'action' => $this->generateUrl('admin_blocktags_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new ComplexTag entity.
     *
     */
    public function newAction()
    {
        $entity = new ComplexTag();
        $form   = $this->createCreateForm($entity);

        return $this->render('RSantellanSitioBundle:ComplexTag:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ComplexTag entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RSantellanSitioBundle:ComplexTag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ComplexTag entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('RSantellanSitioBundle:ComplexTag:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing ComplexTag entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RSantellanSitioBundle:ComplexTag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ComplexTag entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('RSantellanSitioBundle:ComplexTag:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ComplexTag entity.
    *
    * @param ComplexTag $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ComplexTag $entity)
    {
        $form = $this->createForm(new ComplexTagType(), $entity, array(
            'action' => $this->generateUrl('admin_blocktags_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        return $form;
    }
    /**
     * Edits an existing ComplexTag entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RSantellanSitioBundle:ComplexTag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ComplexTag entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_blocktags_edit', array('id' => $id)));
        }

        return $this->render('RSantellanSitioBundle:ComplexTag:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ComplexTag entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RSantellanSitioBundle:ComplexTag')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ComplexTag entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_blocktags'));
    }

    /**
     * Creates a form to delete a ComplexTag entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_blocktags_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

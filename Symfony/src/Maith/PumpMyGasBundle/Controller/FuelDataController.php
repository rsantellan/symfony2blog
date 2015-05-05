<?php

namespace Maith\PumpMyGasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Maith\PumpMyGasBundle\Entity\FuelData;
use Maith\PumpMyGasBundle\Form\FuelDataType;

/**
 * FuelData controller.
 *
 */
class FuelDataController extends Controller
{

    /**
     * Lists all FuelData entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MaithPumpMyGasBundle:FuelData')->findAll();

        return $this->render('MaithPumpMyGasBundle:FuelData:index.html.twig', array(
            'entities' => $entities,
            'smallnavigation' => true,
        ));
    }
    /**
     * Creates a new FuelData entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new FuelData();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('notif-success', 'Consumo agregado con exito');
            return $this->redirect($this->generateUrl('admin_pump_fueldata_edit', array('id' => $entity->getId())));
        }else{
            $this->get('session')->getFlashBag()->add('notif-error', 'A ocurrido un error con el formulario. Revisa los campos.');
        }

        return $this->render('MaithPumpMyGasBundle:FuelData:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a FuelData entity.
     *
     * @param FuelData $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(FuelData $entity)
    {
        $form = $this->createForm(new FuelDataType(), $entity, array(
            'action' => $this->generateUrl('admin_pump_fueldata_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new FuelData entity.
     *
     */
    public function newAction()
    {
        $entity = new FuelData();
        $form   = $this->createCreateForm($entity);

        return $this->render('MaithPumpMyGasBundle:FuelData:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FuelData entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MaithPumpMyGasBundle:FuelData')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FuelData entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MaithPumpMyGasBundle:FuelData:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FuelData entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MaithPumpMyGasBundle:FuelData')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FuelData entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MaithPumpMyGasBundle:FuelData:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a FuelData entity.
    *
    * @param FuelData $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(FuelData $entity)
    {
        $form = $this->createForm(new FuelDataType(), $entity, array(
            'action' => $this->generateUrl('admin_pump_fueldata_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing FuelData entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MaithPumpMyGasBundle:FuelData')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FuelData entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_pump_fueldata_edit', array('id' => $id)));
        }
        else
        {
            $this->get('session')->getFlashBag()->add('notif-error', 'A ocurrido un error con el formulario. Revisa los campos.');
        }

        return $this->render('MaithPumpMyGasBundle:FuelData:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a FuelData entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MaithPumpMyGasBundle:FuelData')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FuelData entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_pump_fueldata'));
    }

    /**
     * Creates a form to delete a FuelData entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_pump_fueldata_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

<?php

namespace Maith\PumpMyGasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Maith\PumpMyGasBundle\Entity\Car;
use Maith\PumpMyGasBundle\Form\CarType;

/**
 * Car controller.
 *
 */
class CarController extends Controller
{

    /**
     * Lists all Car entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MaithPumpMyGasBundle:Car')->findAll();

        return $this->render('MaithPumpMyGasBundle:Car:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Car entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Car();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('notif-success', 'Auto creado con exito');
            return $this->redirect($this->generateUrl('admin_pump_car_edit', array('id' => $entity->getId())));
        }else{
            $this->get('session')->getFlashBag()->add('notif-error', 'A ocurrido un error con el formulario. Revisa los campos.');
        }

        return $this->render('MaithPumpMyGasBundle:Car:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Car entity.
     *
     * @param Car $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Car $entity)
    {
        $form = $this->createForm(new CarType(), $entity, array(
            'action' => $this->generateUrl('admin_pump_car_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Car entity.
     *
     */
    public function newAction()
    {
        $entity = new Car();
        $form   = $this->createCreateForm($entity);

        return $this->render('MaithPumpMyGasBundle:Car:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Car entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MaithPumpMyGasBundle:Car')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Car entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MaithPumpMyGasBundle:Car:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Car entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MaithPumpMyGasBundle:Car')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Car entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MaithPumpMyGasBundle:Car:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Car entity.
    *
    * @param Car $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Car $entity)
    {
        $form = $this->createForm(new CarType(), $entity, array(
            'action' => $this->generateUrl('admin_pump_car_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Car entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MaithPumpMyGasBundle:Car')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Car entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add('notif-success', 'Auto actualizado con exito');
            return $this->redirect($this->generateUrl('admin_pump_car_edit', array('id' => $id)));
        }else{
            $this->get('session')->getFlashBag()->add('notif-error', 'A ocurrido un error con el formulario. Revisa los campos.');
        }

        return $this->render('MaithPumpMyGasBundle:Car:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Car entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MaithPumpMyGasBundle:Car')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Car entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_pump_car'));
    }

    /**
     * Creates a form to delete a Car entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_pump_car_delete', array('id' => $id)))
            ->setMethod('DELETE')
            //->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

<?php

namespace RSantellan\SitioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use RSantellan\SitioBundle\Entity\Project;

/**
 * Description of LoadUserFixture
 *
 * @author Rodrigo Santellan
 */
class LoadProjectsFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface{
    
    /**
     * @var ContainerInterface
     */
    private $container;
    
    public function getOrder() {
        return 4;
    }

    public function load(ObjectManager $manager) {
        $cnea = new Project();
        $cnea->setName("CNEA");
        $cnea->setCliente("CNEA");
        $cnea->setTipoDeTrabajo("Sitio web con registro de personas y instituciones");
        $description = "Con este sitio CNEA pasa a tener el control de los nuevos ";
        $description .= "registros mediante formularios web, haciendo posible el mejor ";
        $description .= "mantenimiento de los ingresados y las fechas de vencimiento de los ";
        $description .= "mismos. Gracias al manejo de alarmas del Administrador el funcionamiento y ";
        $description .= "las inscripciones se a agilizado";
        $cnea->setDescription($description);
        $cnea->setTranslatableLocale('es');
        $manager->persist($cnea);
        
        $metalizadorauruguaya = new Project();
        $metalizadorauruguaya->setName("Metalizadora Uruguaya");
        $metalizadorauruguaya->setCliente("Metalizadora Uruguaya");
        $metalizadorauruguaya->setTipoDeTrabajo("Sitio web con registro de proyectos realizados");
        $description = "Con este sitio Metalizadora uruguaya puede subir todos los projectos realizados ";
        $description .= "con las categorias que los corresponden sin necesitar a una persona tecnica que lo realice. ";
        $description .= "Todos los textos de la pagina son editable haciendo posible que se vaya cambiando los mismos ";
        $description .= "sin conocimiento previo de HTML o CSS";
        $metalizadorauruguaya->setDescription($description);
        $metalizadorauruguaya->setTranslatableLocale('es');
        $manager->persist($metalizadorauruguaya);
        
        $datosaccuchek = new Project();
        $datosaccuchek->setName("Accu-check Uruguay");
        $datosaccuchek->setCliente("Accu-check Uruguay");
        $datosaccuchek->setTipoDeTrabajo("Sitio web con registro de todos los productos vendidos");
        $description = "Este sitio web esta destinado para la facil busqueda de todos los productos vendidos. ";
        $description .= " El mismo es privado para los usuarios que trabajan en la empresa y les permite buscar facilmente los usuarios a quien les vendieron los productos.  ";
        $description .= "Con un sistema de subir facturas y agregar personas facilmente se pueden localizar todas las ventas realizadas en segundos para una rapida respuesta al cliente final. ";
        $datosaccuchek->setDescription($description);
        $datosaccuchek->setTranslatableLocale('es');
        $manager->persist($datosaccuchek);
        
        $surco = new Project();
        $surco->setName("Surco Uruguay");
        $surco->setCliente("Surco Uruguay");
        $surco->setTipoDeTrabajo("Sitio web con una trivia para los escolares del plan ceibal");
        $description = "Este sitio web esta destinado para que los escolares utilicen aprendan sobre las nuevas normas de vialidad en Uruguay.";
        $description .= " En la misma van contestan preguntas multiple opción haciendo que el semaforo se prende en relación a las preguntas.";
        $surco->setDescription($description);
        $surco->setTranslatableLocale('es');
        $manager->persist($surco);
        
        $c5 = new Project();
        $c5->setName("C5 Negocios Inmobiliarios");
        $c5->setCliente("C5 Negocios Inmobiliarios");
        $c5->setTipoDeTrabajo("Sitio web para buscar propiedades para alquilar y comprar.");
        $description = "Este sitio web esta destinado para que sea facil subir las propiedades para que los potenciales clientes puedan ";
        $description .= " buscar las mismas pudiendo tener una primera aproximación a traves de las imagenes subidas.";
        $c5->setDescription($description);
        $c5->setTranslatableLocale('es');
        $manager->persist($c5);
        
        $rentnchill = new Project();
        $rentnchill->setName("Rent and Chill");
        $rentnchill->setCliente("Rent and Chill");
        $rentnchill->setTipoDeTrabajo("Mantenimiento del sitio.");
        $description = "A este sitio se le hizo el mantenimiento inicial para que el mismo funcione. ";
        $description .= "Se le creo y mejoro el sistema de newsletter para que soporte todos los mismos, se integro con PayPal y se mejoro el administrador.";
        $rentnchill->setDescription($description);
        $rentnchill->setTranslatableLocale('es');
        $manager->persist($rentnchill);

        $airsoft = new Project();
        $airsoft->setName("Airsoft Uruguay");
        $airsoft->setCliente("Airsoft Uruguay");
        $airsoft->setTipoDeTrabajo("Creación del sitio y del foro");
        $description = "Este sitio web se creo para remplazar el viejo foro que se estaba utilizando. El mismo se creo en Wordpress para agilizar el funcionamiento del mismo. ";
        $description .= "Se le adaptaron varios plugins para que el manejo de imagenes, videos y el foro se facilmente utilizable y pueda ser una transición facil para los usuarios.";
        $description .= "Al mismo se le hace un manteniento para que continue funcionando agilmente.";
        $airsoft->setDescription($description);
        $airsoft->setTranslatableLocale('es');
        $manager->persist($airsoft);
        
        $ums = new Project();
        $ums->setName("UMS");
        $ums->setCliente("Ums");
        $ums->setTipoDeTrabajo("Mantenimiento del sitio.");
        $description = "A este sitio se le hizo el mantenimiento inicial para que el mismo funcione. ";
        $description .= "Con el cual el mismo pudo salir a producción.";
        $ums->setDescription($description);
        $ums->setTranslatableLocale('es');
        $manager->persist($ums);
        
        
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}



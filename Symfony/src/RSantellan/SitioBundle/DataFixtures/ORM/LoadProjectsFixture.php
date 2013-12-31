<?php

namespace RSantellan\SitioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
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
class LoadProjectsFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
    
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
        $cnea->addCategory($this->getReference('category-web'));
        $cnea->addComplexTag($this->getReference('block-forms'));
        $cnea->addComplexTag($this->getReference('block-codeigniter'));
        $cnea->addComplexTag($this->getReference('block-mysql'));
        $cnea->addComplexTag($this->getReference('block-php'));
        $cnea->addComplexTag($this->getReference('block-javascript'));
        $cnea->addComplexTag($this->getReference('block-jquery'));
        $cnea->addComplexTag($this->getReference('block-jqueryui'));
        $cnea->addComplexTag($this->getReference('block-texts'));
        
        
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
        $metalizadorauruguaya->addCategory($this->getReference('category-web'));
        $metalizadorauruguaya->addComplexTag($this->getReference('block-codeigniter'));
        $metalizadorauruguaya->addComplexTag($this->getReference('block-mysql'));
        $metalizadorauruguaya->addComplexTag($this->getReference('block-php'));
        $metalizadorauruguaya->addComplexTag($this->getReference('block-javascript'));
        $metalizadorauruguaya->addComplexTag($this->getReference('block-jquery'));
        $metalizadorauruguaya->addComplexTag($this->getReference('block-jqueryui'));
        $metalizadorauruguaya->addComplexTag($this->getReference('block-texts'));
        $metalizadorauruguaya->addComplexTag($this->getReference('block-slider'));
        
        
        $datosaccuchek = new Project();
        $datosaccuchek->setName("Accu-check Uruguay");
        $datosaccuchek->setCliente("Accu-check Uruguay");
        $datosaccuchek->setTipoDeTrabajo("Sitio web con registro de todos los productos vendidos");
        $description = "Este sitio web esta destinado para la facil busqueda de todos los productos vendidos. ";
        $description .= " El mismo es privado para los usuarios que trabajan en la empresa y les permite buscar facilmente los usuarios a quien les vendieron los productos.  ";
        $description .= "Con un sistema de subir facturas y agregar personas facilmente se pueden localizar todas las ventas realizadas en segundos para una rapida respuesta al cliente final. ";
        $datosaccuchek->setDescription($description);
        $datosaccuchek->setTranslatableLocale('es');
        $datosaccuchek->addCategory($this->getReference('category-web'));
        $datosaccuchek->addComplexTag($this->getReference('block-forms'));
        $datosaccuchek->addComplexTag($this->getReference('block-codeigniter'));
        $datosaccuchek->addComplexTag($this->getReference('block-mysql'));
        $datosaccuchek->addComplexTag($this->getReference('block-php'));
        $datosaccuchek->addComplexTag($this->getReference('block-javascript'));
        $datosaccuchek->addComplexTag($this->getReference('block-jquery'));
        $datosaccuchek->addComplexTag($this->getReference('block-jqueryui'));
        $datosaccuchek->addComplexTag($this->getReference('block-texts'));
        
        
        $surco = new Project();
        $surco->setName("Surco Uruguay");
        $surco->setCliente("Surco Uruguay");
        $surco->setTipoDeTrabajo("Sitio web con una trivia para los escolares del plan ceibal");
        $description = "Este sitio web esta destinado para que los escolares utilicen aprendan sobre las nuevas normas de vialidad en Uruguay.";
        $description .= " En la misma van contestan preguntas multiple opción haciendo que el semaforo se prende en relación a las preguntas.";
        $surco->setDescription($description);
        $surco->setTranslatableLocale('es');
        $surco->addCategory($this->getReference('category-web'));
        $surco->addComplexTag($this->getReference('block-mysql'));
        $surco->addComplexTag($this->getReference('block-php'));
        $surco->addComplexTag($this->getReference('block-javascript'));
        $surco->addComplexTag($this->getReference('block-jquery'));
        $surco->addComplexTag($this->getReference('block-jqueryui'));
        $surco->addComplexTag($this->getReference('block-html'));
        
        
        $c5 = new Project();
        $c5->setName("C5 Negocios Inmobiliarios");
        $c5->setCliente("C5 Negocios Inmobiliarios");
        $c5->setTipoDeTrabajo("Sitio web para buscar propiedades para alquilar y comprar.");
        $description = "Este sitio web esta destinado para que sea facil subir las propiedades para que los potenciales clientes puedan ";
        $description .= " buscar las mismas pudiendo tener una primera aproximación a traves de las imagenes subidas.";
        $c5->setDescription($description);
        $c5->setTranslatableLocale('es');
        $c5->addCategory($this->getReference('category-web'));
        $c5->addComplexTag($this->getReference('block-forms'));
        $c5->addComplexTag($this->getReference('block-codeigniter'));
        $c5->addComplexTag($this->getReference('block-mysql'));
        $c5->addComplexTag($this->getReference('block-php'));
        $c5->addComplexTag($this->getReference('block-javascript'));
        $c5->addComplexTag($this->getReference('block-jquery'));
        $c5->addComplexTag($this->getReference('block-jqueryui'));
        $c5->addComplexTag($this->getReference('block-texts'));
        
        
        $rentnchill = new Project();
        $rentnchill->setName("Rent and Chill");
        $rentnchill->setCliente("Rent and Chill");
        $rentnchill->setTipoDeTrabajo("Mantenimiento del sitio.");
        $description = "A este sitio se le hizo el mantenimiento inicial para que el mismo funcione. ";
        $description .= "Se le creo y mejoro el sistema de newsletter para que soporte todos los mismos, se integro con PayPal y se mejoro el administrador.";
        $rentnchill->setDescription($description);
        $rentnchill->setTranslatableLocale('es');
        $rentnchill->addCategory($this->getReference('category-web'));
        $rentnchill->addCategory($this->getReference('category-scripting'));
        $rentnchill->addComplexTag($this->getReference('block-forms'));
        $rentnchill->addComplexTag($this->getReference('block-wordpress'));
        $rentnchill->addComplexTag($this->getReference('block-mysql'));
        $rentnchill->addComplexTag($this->getReference('block-php'));
        $rentnchill->addComplexTag($this->getReference('block-javascript'));
        $rentnchill->addComplexTag($this->getReference('block-jquery'));
        $rentnchill->addComplexTag($this->getReference('block-jqueryui'));
        $rentnchill->addComplexTag($this->getReference('block-texts'));
        $rentnchill->addComplexTag($this->getReference('block-bash'));
        $rentnchill->addComplexTag($this->getReference('block-slider'));
        $rentnchill->addComplexTag($this->getReference('block-ecommerce'));
        
        

        $airsoft = new Project();
        $airsoft->setName("Airsoft Uruguay");
        $airsoft->setCliente("Airsoft Uruguay");
        $airsoft->setTipoDeTrabajo("Creación del sitio y del foro");
        $description = "Este sitio web se creo para remplazar el viejo foro que se estaba utilizando. El mismo se creo en Wordpress para agilizar el funcionamiento del mismo. ";
        $description .= "Se le adaptaron varios plugins para que el manejo de imagenes, videos y el foro se facilmente utilizable y pueda ser una transición facil para los usuarios.";
        $description .= "Al mismo se le hace un manteniento para que continue funcionando agilmente.";
        $airsoft->setDescription($description);
        $airsoft->setTranslatableLocale('es');
        $airsoft->addCategory($this->getReference('category-web'));
        $airsoft->addCategory($this->getReference('category-wordpress'));
        $airsoft->addCategory($this->getReference('category-scripting'));
        $airsoft->addComplexTag($this->getReference('block-forms'));
        $airsoft->addComplexTag($this->getReference('block-wordpress'));
        $airsoft->addComplexTag($this->getReference('block-mysql'));
        $airsoft->addComplexTag($this->getReference('block-php'));
        $airsoft->addComplexTag($this->getReference('block-javascript'));
        $airsoft->addComplexTag($this->getReference('block-jquery'));
        $airsoft->addComplexTag($this->getReference('block-jqueryui'));
        $airsoft->addComplexTag($this->getReference('block-bash'));
        $airsoft->addComplexTag($this->getReference('block-slider'));
        $airsoft->addComplexTag($this->getReference('block-desgin'));
        $airsoft->addComplexTag($this->getReference('block-html'));
        
        
        
        $ums = new Project();
        $ums->setName("UMS");
        $ums->setCliente("Ums");
        $ums->setTipoDeTrabajo("Mantenimiento del sitio.");
        $description = "A este sitio se le hizo el mantenimiento inicial para que el mismo funcione. ";
        $description .= "Con el cual el mismo pudo salir a producción.";
        $ums->setDescription($description);
        $ums->setTranslatableLocale('es');
        $ums->addCategory($this->getReference('category-web'));
        $ums->addCategory($this->getReference('category-scripting'));
        $ums->addComplexTag($this->getReference('block-html'));
        $ums->addComplexTag($this->getReference('block-mysql'));
        $ums->addComplexTag($this->getReference('block-php'));
        $ums->addComplexTag($this->getReference('block-javascript'));
        $ums->addComplexTag($this->getReference('block-jquery'));
        $ums->addComplexTag($this->getReference('block-bash'));
        $ums->addComplexTag($this->getReference('block-webscrapping'));
        $ums->addComplexTag($this->getReference('block-python'));
        
        $datascrapping = new Project();
        $datascrapping->setName("Data analytics");
        $datascrapping->setCliente("Data analytics");
        $datascrapping->setTipoDeTrabajo("Obtención de datos a traves de script para obtener datos de paginas web");
        $description = "Mediante web scrapping se obtuvieron todos los datos necesarios para popular ";
        $description .= "una base de datos con datos obtenidos de diferentes sitios web";
        $datascrapping->setDescription($description);
        $datascrapping->setTranslatableLocale('es');
        $datascrapping->addCategory($this->getReference('category-scripting'));
        $datascrapping->addComplexTag($this->getReference('block-bash'));
        $datascrapping->addComplexTag($this->getReference('block-webscrapping'));
        $datascrapping->addComplexTag($this->getReference('block-python'));
        
        $rsantellan = new Project();
        $rsantellan->setName("Rodrigo Santellan");
        $rsantellan->setCliente("Rodrigo Santellan");
        $rsantellan->setTipoDeTrabajo("Sitio intitucional");
        $description = "Creación del sitio que estas viendo!";
        $rsantellan->setDescription($description);
        $rsantellan->setTranslatableLocale('es');
        $rsantellan->addCategory($this->getReference('category-web'));
        $rsantellan->addCategory($this->getReference('category-scripting'));
        $rsantellan->addComplexTag($this->getReference('block-symfony2'));
        $rsantellan->addComplexTag($this->getReference('block-html'));
        $rsantellan->addComplexTag($this->getReference('block-desgin'));
        $rsantellan->addComplexTag($this->getReference('block-texts'));
        $rsantellan->addComplexTag($this->getReference('block-slider'));
        $rsantellan->addComplexTag($this->getReference('block-mysql'));
        $rsantellan->addComplexTag($this->getReference('block-php'));
        $rsantellan->addComplexTag($this->getReference('block-javascript'));
        $rsantellan->addComplexTag($this->getReference('block-jquery'));
        $rsantellan->addComplexTag($this->getReference('block-jqueryui'));
        $rsantellan->addComplexTag($this->getReference('block-bash'));
        $rsantellan->addComplexTag($this->getReference('block-webscrapping'));
        $rsantellan->addComplexTag($this->getReference('block-python'));
        
        $manager->persist($ums);
        $manager->persist($c5);
        $manager->persist($rentnchill);
        $manager->persist($airsoft);
        $manager->persist($datosaccuchek);
        $manager->persist($metalizadorauruguaya);
        $manager->persist($cnea);
        $manager->persist($surco);
        $manager->persist($datascrapping);
        $manager->persist($rsantellan);
        
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}



<?php

namespace RSantellan\SitioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use RSantellan\SitioBundle\Entity\ComplexTag;

/**
 * Description of LoadUserFixture
 *
 * @author Rodrigo Santellan
 */
class LoadBlocksFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
    
    /**
     * @var ContainerInterface
     */
    private $container;
    
    public function getOrder() {
        return 3;
    }

    public function load(ObjectManager $manager) {
        $php = new ComplexTag();
        $php->setName("PHP");
        $php->setDescription("Sitio creado en lenguaje PHP");
        $php->setTranslatableLocale('es');
        $manager->persist($php);
        
        $javascript = new ComplexTag();
        $javascript->setName("Javascript");
        $javascript->setDescription("Este sitio contiene uso importante de javascript");
        $javascript->setTranslatableLocale('es');
        $manager->persist($javascript);
        
        $jquery = new ComplexTag();
        $jquery->setName("JQuery");
        $jquery->setDescription("Este sitio esta creado con JQuery");
        $jquery->setTranslatableLocale('es');
        $manager->persist($jquery);
        
        $jqueryui = new ComplexTag();
        $jqueryui->setName("JQuery UI");
        $jqueryui->setDescription("Este sitio tiene efectos creados con JQuery UI");
        $jqueryui->setTranslatableLocale('es');
        $manager->persist($jqueryui);
        
        $slider = new ComplexTag();
        $slider->setName("Slideshows");
        $slider->setDescription("Este sitio contiene efectos de imagenes creados con sliders");
        $slider->setTranslatableLocale('es');
        $manager->persist($slider);
        
        $mysql = new ComplexTag();
        $mysql->setName("MySQL");
        $mysql->setDescription("Se maneja una base de datos MySQL");
        $mysql->setTranslatableLocale('es');
        $manager->persist($mysql);
        
        $sqlite = new ComplexTag();
        $sqlite->setName("SQLite");
        $sqlite->setDescription("Se maneja una base de datos SQLite");
        $sqlite->setTranslatableLocale('es');
        $manager->persist($sqlite);
        
        $python = new ComplexTag();
        $python->setName("Python");
        $python->setDescription("El lenguaje de programacion fue Python");
        $python->setTranslatableLocale('es');
        $manager->persist($python);
        
        $oracle = new ComplexTag();
        $oracle->setName("Oracle");
        $oracle->setDescription("Se maneja una base de datos Oracle");
        $oracle->setTranslatableLocale('es');
        $manager->persist($oracle);
        
        $wordpress = new ComplexTag();
        $wordpress->setName("Wordpress");
        $wordpress->setDescription("Sitio creado en wordpress");
        $wordpress->setTranslatableLocale('es');
        $manager->persist($wordpress);
        
        $codeigniter = new ComplexTag();
        $codeigniter->setName("Codeigniter");
        $codeigniter->setDescription("Sitio creado con Codeigniter");
        $codeigniter->setTranslatableLocale('es');
        $manager->persist($codeigniter);
        
        $symfony = new ComplexTag();
        $symfony->setName("Symfony 1.4");
        $symfony->setDescription("Sitio creado con Symfony 1.4");
        $symfony->setTranslatableLocale('es');
        $manager->persist($symfony);
        
        $symfony2 = new ComplexTag();
        $symfony2->setName("Symfony 2");
        $symfony2->setDescription("Sitio creado con Symfony 2");
        $symfony2->setTranslatableLocale('es');
        $manager->persist($symfony2);
        
        $bash = new ComplexTag();
        $bash->setName("Bash");
        $bash->setDescription("Scripting en Bash");
        $bash->setTranslatableLocale('es');
        $manager->persist($bash);
        
        $webscrapping = new ComplexTag();
        $webscrapping->setName("Web scrapping");
        $webscrapping->setDescription("Analisis y guardado de sitios web");
        $webscrapping->setTranslatableLocale('es');
        $manager->persist($webscrapping);
        
        $formularios = new ComplexTag();
        $formularios->setName("Formularios");
        $formularios->setDescription("Se manejan formularios complejos en este sitio");
        $formularios->setTranslatableLocale('es');
        $manager->persist($formularios);
        
        $foro = new ComplexTag();
        $foro->setName("Foro");
        $foro->setDescription("Se maneja un foro en este sitio");
        $foro->setTranslatableLocale('es');
        $manager->persist($foro);
        
        $textosDinamicos = new ComplexTag();
        $textosDinamicos->setName("Textos dinamicos");
        $textosDinamicos->setDescription("Todos los textos son editables");
        $textosDinamicos->setTranslatableLocale('es');
        $manager->persist($textosDinamicos);
        
        $design = new ComplexTag();
        $design->setName("Diseño");
        $design->setDescription("El diseño fue creado");
        $design->setTranslatableLocale('es');
        $manager->persist($design);
        
        $html = new ComplexTag();
        $html->setName("HTML Creado");
        $html->setDescription("A partir de un psd se creo la pagina");
        $html->setTranslatableLocale('es');
        $manager->persist($html);
        
        $ecommmerce = new ComplexTag();
        $ecommmerce->setName("Integracion con e-commerce");
        $ecommmerce->setDescription("El sitio soporta medios de pagos");
        $ecommmerce->setTranslatableLocale('es');
        $manager->persist($ecommmerce);
        
        $manager->flush();
        
        $this->addReference('block-php', $php);
        $this->addReference('block-javascript', $javascript);
        $this->addReference('block-jquery', $jquery);
        $this->addReference('block-jqueryui', $jqueryui);
        $this->addReference('block-slider', $slider);
        $this->addReference('block-mysql', $mysql);
        $this->addReference('block-sqlite', $sqlite);
        $this->addReference('block-python', $python);
        $this->addReference('block-oracle', $oracle);
        $this->addReference('block-wordpress', $wordpress);
        $this->addReference('block-codeigniter', $codeigniter);
        $this->addReference('block-symfony', $symfony);
        $this->addReference('block-symfony2', $symfony2);
        $this->addReference('block-bash', $bash);
        $this->addReference('block-webscrapping', $webscrapping);
        $this->addReference('block-html', $html);
        $this->addReference('block-forms', $formularios);
        $this->addReference('block-forum', $foro);
        $this->addReference('block-texts', $textosDinamicos);
        $this->addReference('block-desgin', $design);
        $this->addReference('block-ecommerce', $ecommmerce);
        
        
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}



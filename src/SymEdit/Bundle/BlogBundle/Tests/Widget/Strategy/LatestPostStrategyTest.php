<?php

namespace SymEdit\Bundle\BlogBundle\Tests\Widget\Strategy;

use SymEdit\Bundle\BlogBundle\Tests\TestCase;
use SymEdit\Bundle\BlogBundle\Widget\Strategy\LatestPostStrategy;

class LatestPostStrategyTest extends TestCase
{
    public function createWidget()
    {
        return $this->getMockForAbstractClass('SymEdit\Bundle\WidgetBundle\Model\WidgetInterface');
    }

    public function testExecute()
    {
        $repository = $this->getMockBuilder('Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository')
                           ->setMethods(array('getLatestPost'))
                           ->disableOriginalConstructor()
                           ->getMock();

        $repository->expects($this->once())
                   ->method('getLatestPost')
                   ->will($this->returnValue('foo'));

        $strategy = $this->getMock('SymEdit\Bundle\BlogBundle\Widget\Strategy\LatestPostStrategy', array('render'), array($repository));
        $strategy->expects($this->once())
                 ->method('render')
                 ->with(
                    $this->equalTo('@SymEdit/Widget/Blog/latest-post.html.twig'),
                    $this->equalTo(array(
                        'post' => 'foo',
                    ))
                 );

        $strategy->execute($this->createWidget());
    }

    protected function createStrategy()
    {
        $repository = $this->getMockForAbstractClass('Sylius\Component\Resource\Repository\RepositoryInterface');

        return new LatestPostStrategy($repository);
    }

    public function testName()
    {
        $strategy = $this->createStrategy();
        $this->assertEquals('blog_latest_post', $strategy->getName());
    }

    public function testDescription()
    {
        $strategy = $this->createStrategy();
        $this->assertEquals('blog.latest_post', $strategy->getDescription());
    }

    public function testBuildForm()
    {
        $strategy = $this->createStrategy();
        $builder = $this->getMockForAbstractClass('Symfony\Component\Form\FormBuilderInterface');

        $builder->expects($this->once())
                ->method('add')
                ->with(
                    $this->equalTo('show_image'),
                    $this->equalTo('checkbox')
                );

        $strategy->buildForm($builder);
    }

    public function testDefaultOptions()
    {
        $strategy = $this->createStrategy();
        $widget = $this->createWidget();
        $widget->expects($this->once())
               ->method('setOptions')
               ->with($this->equalTo(array(
                   'show_image' => true,
               )));

        $strategy->setDefaultOptions($widget);
    }
}

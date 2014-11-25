<?php

namespace SymEdit\Bundle\BlogBundle\Tests\Widget\Strategy;

use SymEdit\Bundle\WidgetBundle\Test\WidgetStrategyTest;

class PopularPostsStrategyTest extends WidgetStrategyTest
{
    public function testExecute()
    {
        $reporter = $this->getReporter();
        $reporter->expects($this->once())
                 ->method('runReport')
                 ->with($this->equalTo('popular_posts'))
                 ->will($this->returnValue(array(
                     array('post1', 1),
                     array('post2', 2),
                 )));

        $strategy = $this->createStrategy($reporter);
        $strategy->expects($this->once())
                 ->method('render')
                 ->with(
                    $this->equalTo('@SymEdit/Widget/Blog/popular-posts.html.twig'),
                    $this->equalTo(array(
                        'posts' => array('post1', 'post2'),
                    ))
                 );

        $strategy->execute($this->createWidget());
    }

    protected function createStrategy($reporter = null)
    {
        $reporter = $reporter === null ? $this->getReporter() : $reporter;
        return $this->getMockBuilder('SymEdit\Bundle\BlogBundle\Widget\Strategy\PopularPostsStrategy')
                    ->setMethods(array('render'))
                    ->setConstructorArgs(array($reporter))
                    ->getMock();
    }

    protected function getReporter()
    {
        return $this->getMockBuilder('SymEdit\Bundle\AnalyticsBundle\Report\Reporter')
                    ->disableOriginalConstructor()
                    ->getMock();
    }

    protected function getFormBuilder()
    {
        $builder = parent::getFormBuilder();
        $builder->expects($this->once())
                ->method('add')
                ->with(
                    $this->equalTo('max'),
                    $this->equalTo('integer')
                );

        return $builder;
    }

    protected function getDefaultOptions()
    {
        return array(
            'max' => 3,
        );
    }

    protected function getStrategyName()
    {
        return 'blog_popular_posts';
    }

    protected function getStrategyDescription()
    {
        return 'blog.popular_posts';
    }
}

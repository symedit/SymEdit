<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\Tests\Widget\Strategy;

use SymEdit\Bundle\WidgetBundle\Test\WidgetStrategyTest;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PopularPostsStrategyTest extends WidgetStrategyTest
{
    public function testExecute()
    {
        $reporter = $this->getReporter();
        $reporter->expects($this->once())
                 ->method('runReport')
                 ->with($this->equalTo('popular_posts'))
                 ->will($this->returnValue([
                     ['post1', 1],
                     ['post2', 2],
                 ]));

        $widget = $this->createWidget();
        $strategy = $this->createStrategy($reporter);
        $strategy->expects($this->once())
                 ->method('render')
                 ->with(
                    $this->equalTo($widget),
                    $this->equalTo([
                        'posts' => ['post1', 'post2'],
                    ])
                 );

        $strategy->execute($widget);
    }

    protected function createStrategy($reporter = null)
    {
        $reporter = $reporter === null ? $this->getReporter() : $reporter;

        return $this->getMockBuilder('SymEdit\Bundle\BlogBundle\Widget\Strategy\PopularPostsStrategy')
                    ->setMethods(['render'])
                    ->setConstructorArgs([$reporter])
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
                    $this->equalTo(IntegerType::class)
                );

        return $builder;
    }

    protected function getDefaultOptions()
    {
        return [
            'max' => 3,
            'template' => '@SymEdit/Widget/Blog/popular-posts.html.twig',
        ];
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

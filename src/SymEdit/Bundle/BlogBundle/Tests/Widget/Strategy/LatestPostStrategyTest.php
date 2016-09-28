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

use SymEdit\Bundle\BlogBundle\Widget\Strategy\LatestPostStrategy;
use SymEdit\Bundle\WidgetBundle\Test\WidgetStrategyTest;

class LatestPostStrategyTest extends WidgetStrategyTest
{
    public function testExecute()
    {
        $repository = $this->getMockBuilder('SymEdit\Bundle\BlogBundle\Repository\PostRepositoryInterface')
           ->disableOriginalConstructor()
           ->getMock()
        ;

        $repository->expects($this->once())
           ->method('getLatestPost')
           ->will($this->returnValue('foo'))
        ;

        $widget = $this->createWidget();

        $strategy = $this->getMockBuilder('SymEdit\Bundle\BlogBundle\Widget\Strategy\LatestPostStrategy')
            ->setConstructorArgs([$repository])
            ->setMethods(['render'])
            ->getMock()
        ;

        $strategy->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo($widget),
                $this->equalTo([
                    'post' => 'foo',
                ])
            )
        ;

        $strategy->execute($widget);
    }

    protected function createStrategy()
    {
        $repository = $this->getMockBuilder('SymEdit\Bundle\BlogBundle\Repository\PostRepositoryInterface')
            ->getMock()
        ;

        return new LatestPostStrategy($repository);
    }

    protected function getFormBuilder()
    {
        $builder = parent::getFormBuilder();
        $builder->expects($this->once())
            ->method('add')
            ->with(
                $this->equalTo('show_image'),
                $this->equalTo('checkbox')
            )
        ;

        return $builder;
    }

    protected function getDefaultOptions()
    {
        return [
            'show_image' => true,
            'template' => '@SymEdit/Widget/Blog/latest-post.html.twig',
        ];
    }

    protected function getStrategyDescription()
    {
        return 'blog.latest_post';
    }

    protected function getStrategyName()
    {
        return 'blog_latest_post';
    }
}

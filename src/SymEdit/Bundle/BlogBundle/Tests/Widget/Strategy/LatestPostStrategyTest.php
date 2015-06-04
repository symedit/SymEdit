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
        $repository = $this->getMock('SymEdit\Bundle\BlogBundle\Repository\PostRepositoryInterface');

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
                );

        return $builder;
    }

    protected function getDefaultOptions()
    {
        return array(
            'show_image' => true,
        );
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

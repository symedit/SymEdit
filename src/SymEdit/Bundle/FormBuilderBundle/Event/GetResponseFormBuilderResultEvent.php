<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\FormBuilderBundle\Event;

use Symfony\Component\HttpFoundation\Response;

class GetResponseFormBuilderResultEvent extends FormBuilderResultEvent
{
    protected $response;

    /**
     * Set Response for event.
     *
     * @param Response $response
     */
    public function setReponse(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Get Response.
     *
     * @return Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }
}

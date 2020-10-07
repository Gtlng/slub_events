<?php

namespace Slub\SlubEvents\ViewHelpers\Condition;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Alexander Bigga <alexander.bigga@slub-dresden.de>, SLUB Dresden
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Check if given link is local or not
 *
 * = Examples =
 *
 * <code title="Defaults">
 * <f:if condition="<se:link.islocal link='{event.location.link}' />">
 * </code>
 * <output>
 * 1
 * </output>
 *
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @api
 */
class IsSubscriptionAllowedViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * subscriberRepository
     *
     * @var \Slub\SlubEvents\Domain\Repository\SubscriberRepository
     */
    protected $subscriberRepository;

    /**
     * injectSubscriberRepository
     *
     * @param \Slub\SlubEvents\Domain\Repository\SubscriberRepository $subscriberRepository
     *
     * @return void
     */
    public function injectSubscriberRepository(
        \Slub\SlubEvents\Domain\Repository\SubscriberRepository $subscriberRepository
    ) {
        $this->subscriberRepository = $subscriberRepository;
    }

    /**
     * Render the supplied DateTime object as a formatted date.
     *
     * @param \Slub\SlubEvents\Domain\Model\Event $event
     *
     * @return boolean
     * @author Alexander Bigga <alexander.bigga@slub-dresden.de>
     * @api
     */
    public function render($event)
    {

        // event is cancelled
        if ($event->getCancelled()) {
            return false;
        }

        // deadline reached....
        if (is_object($event->getSubEndDateTime())) {
            if ($event->getSubEndDateTime()->getTimestamp() < time()) {
                return false;
            }
        }

        // limit reached already --> overbooked
        if ($this->subscriberRepository->countAllByEvent($event) >= $event->getMaxSubscriber()) {
            return false;
        }


        return true;
    }
}

<?php
	
namespace AQ\Rephactor\Refactoring;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RefactorCollection implements RefactorInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

	/**
	 * @var RefactorInterface[]
	 */
	private $refactorings;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function addRefactoring(RefactorInterface $refactoring)
    {
        $this->refactorings[] = $refactoring;
        if ($refactoring instanceof EventSubscriberInterface) {

            $this->eventDispatcher->addSubscriber($refactoring);
        }
    }

    public function doRefactor()
    {
        foreach ($this->refactorings as $refactoring) {
            $refactoring->doRefactor();
        }
    }


}
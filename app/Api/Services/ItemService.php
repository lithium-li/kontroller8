<?php

namespace App\Api\Services;

use App\Api\Repositories\ItemRepository;
use App\Api\Snapshots\ItemSnapshot;

/**
 * Сервис для сущности «продукт»
 */
class ItemService
{
    /** @var ItemRepository  */
    private $itemRepository;

    /**
     * @param ItemRepository $itemRepository
     */
    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository =  $itemRepository;
    }

    /**
     * @param ItemSnapshot $itemSnapshot
     */
    public function create(ItemSnapshot $itemSnapshot): void
    {
        $this->itemRepository->create($itemSnapshot);
    }
}
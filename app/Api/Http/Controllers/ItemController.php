<?php

namespace App\Api\Http\Controllers;

use App\Api\DTO\ItemDTO;
use App\Api\Http\Requests\ItemRequest;
use App\Api\Http\Resources\ItemResource;
use App\Api\Repositories\ItemRepository;
use App\Api\Services\ItemService;
use App\Http\Controllers\Controller;
use App\Api\Models\Item;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

/**
 * API for items.
 */
class ItemController extends Controller
{
    /** @var ItemService */
    private $itemService;

    /** @var ItemRepository */
    private $itemRepository;

    /**
     * @param ItemService $itemService
     * @param ItemRepository $itemRepository
     */
    public function __construct(ItemService $itemService, ItemRepository $itemRepository)
    {
        $this->itemService = $itemService;
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $userId = Auth::user()->getAuthIdentifier();
        $items = $this->itemRepository->paginate()->findByOwner($userId);

        return ResourceCollection::make($items);
    }

    /**
     * @param Item $item
     * @return ItemResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Item $item): ItemResource
    {
        $this->authorize('view', $item);

        return ItemResource::make($item);
    }

    /**
     * @param ItemRequest $request
     * @return ItemResource
     * @throws \App\Api\DTO\DTOException
     */
    public function store(ItemRequest $request): ItemResource
    {
        $dto = new ItemDTO($request->all());
        $dto->setId(\Ulid::generate());

        $this->itemService->create($dto);
        $item = $this->itemRepository->findById($dto->getId());
        $item->wasRecentlyCreated = true;

        return ItemResource::make($item);
    }


    /**
     * @param Item $item
     * @param ItemRequest $request
     * @return ItemResource
     * @throws \ErrorException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \App\Api\DTO\DTOException
     */
    public function update(Item $item, ItemRequest $request): ItemResource
    {
        $this->authorize('update', $item);

        $dto = new ItemDTO($request->all());

        $this->itemService->update($item, $dto);

        $updatedItem = $this->itemRepository->findById($item->id);

        return ItemResource::make($updatedItem);
    }

    /**
     * @param Item $item
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);
        $this->itemService->delete($item);

        return response()->json(null, 204);
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemCollection;
use App\Http\Resources\ItemResource;
use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
  public function index()
  {
    $items = Item::paginate(15);
    $items = $items->sortKeysDesc();

    return (new ItemCollection($items))->response()->setStatusCode(200);
  }

  public function store(Request $request)
  {
    $request->validate([
      'item_name' => 'required',
      'item_price' => 'required'
    ]);

    $item = Item::create($request->all());

    return response()->json([
      'error' => false,
      'message' => 'Item added successfully!'
    ], 200);
  }

  public function update(Item $item, Request $request)
  {
    $item->update($request->all());

    return response()->json([
      'error' => false,
      'message' => 'Item updated successfully!'
    ], 200);
  }

  public function destroy(Item $item)
  {
    $item->delete();

    return response()->json([
      'error' => false,
      'message' => 'Item deleted successfully!'
    ], 200);
  }
}

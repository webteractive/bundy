<?php

namespace App\Bundy;

use Illuminate\Pagination\LengthAwarePaginator;

class Paginator
{
  
  protected $url;

  protected $page;
  
  protected $items;
  
  protected $perPage;

  public function __construct($items) {
    $this->items = $items;
    $this->page = request()->query('page', 1);
    $this->perPage = request()->query('per_page', 6);
    $this->pagination = new LengthAwarePaginator(
      $this->items->forPage($this->page, $this->perPage),
      $this->page,
      $this->perPage
    );
  }

  public function withUrl($url)
  {
    $this->url = $url;
    return $this;
  }

  public function paginate()
  {
    if (is_null($this->url)) {
      return $this->pagination;
    }

    return $this->pagination->withPath($this->url);
  }

  public function toJson()
  {
    return response()->json($this->paginate());
  }
}

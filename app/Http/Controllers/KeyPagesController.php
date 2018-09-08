<?php

namespace App\Http\Controllers;

use App\Events\RandomPageGenerated;
use App\Keys\PageKeys;
use App\Keys\PageNumbers\PageNumber;
use App\Models\CoinStats;
use Illuminate\Routing\Controller as BaseController;

abstract class KeyPagesController extends BaseController
{
    protected $coinType;

    /** @var PageNumber */
    protected $pageNumber;

    /** @var PageKeys */
    protected $pageKeys;

    public function index()
    {
        return view($this->coinType.'-index', [
            'keysToday' => CoinStats::today($this->coinType)->keys_generated,
        ]);
    }

    public function keysPage($pageNumber = null)
    {
        /** @var PageNumber $page */
        $page = new $this->pageNumber($pageNumber);

        if ($page->shouldRedirect()) {
            return $page->redirect();
        }

        $keys = $this->pageKeys::generate($pageNumber);

        CoinStats::coinPageViewed($this->coinType, count($keys));

        return view($this->coinType.'-page', [
            'pageNumber'    => $pageNumber,
            'nextPage'      => increment_string($pageNumber),
            'previousPage'  => decrement_string($pageNumber),
            'lastPage'      => $this->pageNumber::lastPageNumber(),
            'isOnFirstPage' => $pageNumber === '1',
            'isOnLastPage'  => $pageNumber === $this->pageNumber::lastPageNumber(),
            'keys'          => $keys,
        ]);
    }

    public function randomPage()
    {
        $randomPage = $this->pageNumber::random();

        RandomPageGenerated::dispatch($randomPage);

        CoinStats::randomPageGenerated($this->coinType);

        return redirect()->route($this->coinType.'Pages', $randomPage->getPageNumber());
    }

    public function pageTooBig()
    {
        return view($this->coinType.'-page-too-big');
    }
}

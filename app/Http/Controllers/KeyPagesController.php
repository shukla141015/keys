<?php

namespace App\Http\Controllers;

use App\Events\RandomPageGenerated;
use App\Keys\PageKeys;
use App\Keys\PageNumbers\PageNumber;
use App\Keys\Search\CoinSearch;
use App\Models\BiggestRandomPage;
use App\Models\CoinStats;
use App\Models\SmallestRandomPage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

abstract class KeyPagesController extends Controller
{
    public function __construct(Request $request)
    {
        $page = $request->segment(2);

        if (! $page || $page === '1' || $page === $this->pageNumber::lastPageNumber()) {
            return;
        }

        $this->middleware('only-for-humans');
    }

    protected $coinType;

    /** @var PageNumber */
    protected $pageNumber;

    /** @var PageKeys */
    protected $pageKeys;

    protected $privateKeyRule;

    protected $coinSearch;

    public function index()
    {
        return view($this->coinType.'-index');
    }

    public function showSearch()
    {
        return view($this->coinType.'-search');
    }

    public function search(Request $request)
    {
        $request->validate([
            'private_key' => ['required', 'string', new $this->privateKeyRule],
        ]);

        $pk = $request->get('private_key');

        /** @var CoinSearch $search */
        $search = new $this->coinSearch($pk);

        return $search->valid()
            ? redirect()->route($this->coinType.'Pages', $search->pageNumber())
            : back()->withInput()->withErrors(['private_key' => 'error']);
    }

    public function stats()
    {
        $allTime = CoinStats::whereCoin($this->coinType)->get();

        $dateCurrentMonth = now()->format('-m-');

        $thisMonth = $allTime->filter(function (CoinStats $coinStats) use ($dateCurrentMonth) {
            return strpos($coinStats->date, $dateCurrentMonth) !== false;
        });

        $dateLastMonth = now()->startOfMonth()->subDays(1)->format('-m-');

        $lastMonth = $allTime->filter(function (CoinStats $coinStats) use ($dateLastMonth) {
            return strpos($coinStats->date, $dateLastMonth) !== false;
        });

        return view($this->coinType.'-stats', [
            'today'     => $allTime->firstWhere('date', now()->toDateString()) ?? optional(),
            'thisMonth' => CoinStats::combine($thisMonth),
            'lastMonth' => CoinStats::combine($lastMonth),
            'allTime'   => CoinStats::combine($allTime),
            'smallestPages' => SmallestRandomPage::listForCoin($this->coinType),
            'biggestPages'  => BiggestRandomPage::listForCoin($this->coinType),
            'maxPage' => $this->pageNumber::lastPageNumber(),
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

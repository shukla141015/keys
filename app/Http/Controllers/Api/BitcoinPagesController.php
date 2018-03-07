<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BitcoinPageRequest;
use App\Models\BtcPage;

class BitcoinPagesController extends Controller
{
    public function put(BitcoinPageRequest $request)
    {
        BtcPage::updateOrCreate([
            'page_number' => $request->getPageNumber(),
        ], [
            'empty'      => $request->isEmptyPage(),
            'updated_at' => now(),
        ]);

        return response('', 200);
    }
}

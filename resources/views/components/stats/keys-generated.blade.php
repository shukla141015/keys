<span class="inline-block w-24 mr-2">Today:</span> {{ string_number_format($today->keys_generated) ?: 'n/a' }}
<br>
<span class="inline-block w-24 mr-2">This month:</span> {{ string_number_format($thisMonth->keys_generated) ?: 'n/a' }}
<br>
<span class="inline-block w-24 mr-2">Last month:</span> {{ string_number_format($lastMonth->keys_generated) ?: 'n/a' }}
<br>
<span class="inline-block w-24 mr-2">All time:</span> {{ string_number_format($allTime->keys_generated) ?: 'n/a' }}
